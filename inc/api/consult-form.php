<?php
/**
 * Consult Form API Endpoint
 * ==========================================================================
 * Route: POST /wp-json/linsy/v1/consult
 * 
 * Logic:
 * 1. Validate inputs (Name, Email, Message, etc.)
 * 2. Handle file upload (if any)
 * 3. Send email via Resend PHP SDK
 * 4. Return JSON response
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 确保 Composer Autoload 已加载
if ( file_exists( get_stylesheet_directory() . '/vendor/autoload.php' ) ) {
	require_once get_stylesheet_directory() . '/vendor/autoload.php';
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'linsy/v1', '/consult', array(
		'methods'  => 'POST',
		'callback' => 'handle_consult_form_submission',
		'permission_callback' => function( $request ) {
			// 1. Origin Check
			$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
			
			// Allow requests only from our domain
			// In local development, origin might be different or empty for same-origin requests, 
			// but for strict production, we should check against site_url().
			$allowed_origin = home_url(); // e.g. https://site.com
			
			// Note: Localhost might not send Origin header for same-origin fetch. 
			// If Origin is present, check it.
			if ( ! empty( $origin ) && strpos( $origin, $allowed_origin ) === false ) {
				return false;
			}

			return true;
		},
	) );
} );

function handle_consult_form_submission( $request ) {
	
	// 1. 获取参数
	$params = $request->get_params();
	$files  = $request->get_file_params();

	// --- Anti-Spam Logic Start ---
	
	// A. Nonce Check (CSRF Protection)
	$nonce = $params['_wpnonce'] ?? '';
	if ( ! wp_verify_nonce( $nonce, 'consult_nonce' ) ) {
		return new WP_Error( 'invalid_nonce', 'Invalid request. Please refresh the page.', array( 'status' => 403 ) );
	}

	// B. Honeypot Check
	// If the hidden field 'website_url' is filled, it's a bot.
	if ( ! empty( $params['website_url'] ) ) {
		// Return success to fool the bot, but do nothing.
		return new WP_REST_Response( array( 'success' => true, 'message' => 'Message sent.' ), 200 );
	}

	// C. Rate Limiting (10 minutes per IP)
	$ip = $_SERVER['REMOTE_ADDR'];
	// Use a hashed IP for the transient key to be safe
	$lock_key = 'consult_limit_' . md5( $ip );

	if ( get_transient( $lock_key ) ) {
		return new WP_Error( 'rate_limit_exceeded', 'Too many requests. Please try again in 10 minutes.', array( 'status' => 429 ) );
	}
	
	// D. Cloudflare Turnstile Check
	$turnstile_token = $params['cf-turnstile-response'] ?? '';
	if ( empty( $turnstile_token ) ) {
		return new WP_Error( 'turnstile_missing', 'Security check failed. Please refresh the page.', array( 'status' => 403 ) );
	}
	
	// Verify token with Cloudflare
	$secret_key = defined( 'TURNSTILE_SECRET_KEY' ) ? TURNSTILE_SECRET_KEY : ( getenv( 'TURNSTILE_SECRET_KEY' ) ? getenv( 'TURNSTILE_SECRET_KEY' ) : '' );
	if ( empty( $secret_key ) ) {
		return new WP_Error( 'server_config_error', 'Server Error: Security configuration missing.', array( 'status' => 500 ) );
	}
	
	$verify_response = wp_remote_post( 'https://challenges.cloudflare.com/turnstile/v0/siteverify', array(
		'body' => array(
			'secret' => $secret_key,
			'response' => $turnstile_token,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		)
	) );
	
	if ( is_wp_error( $verify_response ) ) {
		return new WP_Error( 'turnstile_error', 'Security check error. Please try again.', array( 'status' => 500 ) );
	}
	
	$verify_result = json_decode( wp_remote_retrieve_body( $verify_response ), true );
	if ( ! isset( $verify_result['success'] ) || ! $verify_result['success'] ) {
		return new WP_Error( 'turnstile_failed', 'Security verification failed. Are you a robot?', array( 'status' => 403 ) );
	}

	// --- Anti-Spam Logic End ---

	// 2. 基础验证
	$name    = sanitize_text_field( $params['name'] ?? '' );
	$company = sanitize_text_field( $params['company'] ?? '' );
	$phone   = sanitize_text_field( $params['phone'] ?? '' );
	$country = sanitize_text_field( $params['country'] ?? '' );
	$message = sanitize_textarea_field( $params['message'] ?? '' );

	if ( empty( $name ) || empty( $company ) || empty( $phone ) || empty( $country ) || empty( $message ) ) {
		return new WP_Error( 'missing_fields', 'Please fill in all required fields.', array( 'status' => 400 ) );
	}

	// 3. 构建邮件内容
	$subject = "[New Inquiry] from $name - $company";
	$html_content = "
		<h2>New Inquiry Received</h2>
		<p><strong>Name:</strong> $name</p>
		<p><strong>Company:</strong> $company</p>
		<p><strong>Phone:</strong> $phone</p>
		<p><strong>Country:</strong> $country</p>
		<hr>
		<p><strong>Message:</strong></p>
		<p>" . nl2br( $message ) . "</p>
	";

	// 4. 调用 Resend API (SDK)
	$resend_key = defined( 'RESEND_API_KEY' ) ? RESEND_API_KEY : ( getenv( 'RESEND_API_KEY' ) ? getenv( 'RESEND_API_KEY' ) : '' );
	if ( empty( $resend_key ) ) {
		return new WP_Error( 'server_config_error', 'Server Error: Email configuration missing.', array( 'status' => 500 ) );
	}
	$resend = Resend::client( $resend_key );

	$to_emails = ['david@linsyaluminum.com', 'javen_1998519@163.com'];
	$from_email = 'info@linsycopper.com';

	try {
		$email_params = [
			'from'    => "Linsy Copper <$from_email>",
			'to'      => $to_emails,
			'subject' => $subject,
			'html'    => $html_content,
		];

		// 5. 处理附件 (直接流式传输)
		if ( ! empty( $files['attachment'] ) ) {
			$file = $files['attachment'];
			
			// 安全检查: 文件类型
			$allowed_types = [
				'application/pdf', 
				'application/msword', 
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
				'image/jpeg', 
				'image/png', 
				'application/vnd.ms-excel', 
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			];
			
			if ( in_array( $file['type'], $allowed_types ) ) {
				// 读取文件内容并进行 Base64 编码 (Resend SDK 要求)
				// 注意: 虽然 Resend API 支持 content buffer, 但 PHP SDK 通常接受 content 字符串
				$file_content = file_get_contents( $file['tmp_name'] );
				
				$email_params['attachments'] = [
					[
						'filename' => $file['name'],
						'content'  => base64_encode( $file_content ), // Explicitly encode to avoid JSON errors with binary data
					]
				];
			}
		}

		$result = $resend->emails->send( $email_params );
		
		// Set rate limit transient for 10 minutes (600 seconds)
		set_transient( $lock_key, true, 600 );

		return new WP_REST_Response( array( 'success' => true, 'message' => 'Email sent successfully.', 'id' => $result->id ), 200 );

	} catch ( \Exception $e ) {
		error_log( 'Resend SDK Error: ' . $e->getMessage() );
		return new WP_Error( 'resend_error', 'Failed to send email: ' . $e->getMessage(), array( 'status' => 500 ) );
	}
}
