<?php
/**
 * Product AI Content Import — Admin Page (方案 B 框架)
 *
 * 功能:
 * 在 Tools 菜单下注册 "Product Import" 管理页，支持批量导入 JSON。
 * 当前为框架版本：提供 UI 入口，具体批量导入逻辑复用方案 A 的 linsy_process_product_json_import()。
 *
 * 未来扩展:
 * - 支持上传 JSON 文件
 * - 支持粘贴 JSON 数组（多个产品）
 * - 自动创建 Draft 产品 + 写入 ACF 字段
 * - 导入报告（成功/失败统计）
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ============================================================
// 1. Register Admin Menu
// ============================================================

add_action( 'admin_menu', 'linsy_register_product_import_admin_page' );

function linsy_register_product_import_admin_page() {
	add_management_page(
		__( 'Product Import', 'generatepress_child' ),
		__( 'Product Import', 'generatepress_child' ),
		'edit_posts',
		'linsy-product-import',
		'linsy_render_product_import_admin_page'
	);
}

// ============================================================
// 2. Render Admin Page
// ============================================================

function linsy_render_product_import_admin_page() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'Permission denied.', 'generatepress_child' ) );
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<div class="notice notice-info">
			<p>
				<strong><?php esc_html_e( 'Batch Import (方案 B)', 'generatepress_child' ); ?></strong><br>
				<?php esc_html_e( 'Paste a JSON array containing multiple products. Each object must include "post_title" and all content sections. Products will be created as Drafts.', 'generatepress_child' ); ?>
			</p>
		</div>

		<form id="linsy-batch-import-form" method="post">
			<?php wp_nonce_field( 'linsy_batch_import_action', 'linsy_batch_import_nonce' ); ?>

			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="linsy-batch-json">
							<?php esc_html_e( 'JSON Data', 'generatepress_child' ); ?>
						</label>
					</th>
					<td>
						<textarea
							id="linsy-batch-json"
							name="batch_json"
							class="large-text code"
							rows="20"
							style="font-family:monospace;"
							placeholder='[
  {
    "post_title": "Copper Sheet C11000",
    "hero": { "short_desc": "...", "specs": [...] },
    "description": { "content": "...", "features": [...] },
    "applications": [...],
    "specifications": [...],
    "faq": { "title": "...", "description": "...", "list": [...] }
  }
]'
						></textarea>
						<p class="description">
							<?php esc_html_e( 'Accepts a single product object or an array of product objects. All products will be created as Drafts.', 'generatepress_child' ); ?>
						</p>
					</td>
				</tr>
			</table>

			<p class="submit">
				<button type="submit" class="button button-primary">
					<?php esc_html_e( 'Batch Import', 'generatepress_child' ); ?>
				</button>
			</p>
		</form>

		<div id="linsy-batch-result" style="margin-top:20px;"></div>
	</div>

	<script>
	(function($) {
		$(document).ready(function() {
			var $form   = $('#linsy-batch-import-form');
			var $result = $('#linsy-batch-result');

			$form.on('submit', function(e) {
				e.preventDefault();
				$result.html('<p><?php echo esc_js( __( 'Processing...', 'generatepress_child' ) ); ?></p>');

				var raw  = $form.find('[name="batch_json"]').val().trim();
				var nonce = $form.find('[name="linsy_batch_import_nonce"]').val();

				if (!raw) {
					$result.html('<div class="notice notice-error"><p><?php echo esc_js( __( 'Please paste JSON data.', 'generatepress_child' ) ); ?></p></div>');
					return;
				}

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'linsy_batch_import_products',
						nonce:  nonce,
						json:   raw
					},
					success: function(res) {
						if (res.success) {
							var html = '<div class="notice notice-success"><p><strong>' +
								'<?php echo esc_js( __( 'Import Complete!', 'generatepress_child' ) ); ?>' +
								'</strong></p><ul>';
							html += '<li><?php echo esc_js( __( 'Created:', 'generatepress_child' ) ); ?> ' + (res.data.created || 0) + '</li>';
							html += '<li><?php echo esc_js( __( 'Failed:', 'generatepress_child' ) ); ?> ' + (res.data.failed || 0) + '</li>';
							html += '</ul>';
							if (res.data.links && res.data.links.length) {
								html += '<p><?php echo esc_js( __( 'View products:', 'generatepress_child' ) ); ?></p><ul>';
								res.data.links.forEach(function(link) {
									html += '<li><a href="' + link.edit + '" target="_blank">' + link.title + '</a></li>';
								});
								html += '</ul>';
							}
							html += '</div>';
							$result.html(html);
						} else {
							var msg = res.data && res.data.message ? res.data.message : '<?php echo esc_js( __( 'Batch import failed.', 'generatepress_child' ) ); ?>';
							$result.html('<div class="notice notice-error"><p>' + msg + '</p></div>');
						}
					},
					error: function() {
						$result.html('<div class="notice notice-error"><p><?php echo esc_js( __( 'AJAX error. Please try again.', 'generatepress_child' ) ); ?></p></div>');
					}
				});
			});
		});
	})(jQuery);
	</script>
	<?php
}

// ============================================================
// 3. AJAX Handler (Batch Import)
// ============================================================

add_action( 'wp_ajax_linsy_batch_import_products', 'linsy_handle_batch_product_import' );

function linsy_handle_batch_product_import() {
	// Verify nonce
	if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'linsy_batch_import_action' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed.', 'generatepress_child' ) ) );
	}

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( array( 'message' => __( 'Permission denied.', 'generatepress_child' ) ) );
	}

	$raw_json = wp_unslash( $_POST['json'] ?? '' );
	if ( ! $raw_json ) {
		wp_send_json_error( array( 'message' => __( 'No JSON provided.', 'generatepress_child' ) ) );
	}

	$data = json_decode( $raw_json, true );
	if ( json_last_error() !== JSON_ERROR_NONE ) {
		wp_send_json_error( array( 'message' => __( 'JSON parse error: ', 'generatepress_child' ) . json_last_error_msg() ) );
	}

	// Normalize: single object -> array
	if ( isset( $data['post_title'] ) ) {
		$data = array( $data );
	}

	if ( ! is_array( $data ) || empty( $data ) ) {
		wp_send_json_error( array( 'message' => __( 'JSON must be an object or array of objects.', 'generatepress_child' ) ) );
	}

	if ( ! function_exists( 'update_field' ) ) {
		wp_send_json_error( array( 'message' => __( 'ACF Pro is not active.', 'generatepress_child' ) ) );
	}

	$created = 0;
	$failed  = 0;
	$links   = array();

	foreach ( $data as $index => $product_data ) {
		if ( ! is_array( $product_data ) || empty( $product_data['post_title'] ) ) {
			++$failed;
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => sanitize_text_field( $product_data['post_title'] ),
				'post_type'    => 'product',
				'post_status'  => 'draft',
				'post_content' => '',
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			++$failed;
			continue;
		}

		// Import ACF fields using the same logic as Meta Box import
		if ( function_exists( 'linsy_process_product_json_import' ) ) {
			linsy_process_product_json_import( $post_id, $product_data );
		}

		++$created;
		$links[] = array(
			'title' => sanitize_text_field( $product_data['post_title'] ),
			'edit'  => get_edit_post_link( $post_id, 'raw' ),
		);
	}

	wp_send_json_success(
		array(
			'created' => $created,
			'failed'  => $failed,
			'links'   => $links,
		)
	);
}
