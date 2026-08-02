<?php
/**
 * Product AI Content Import — Meta Box (方案 A)
 *
 * 功能:
 * 1. 在 Product 编辑页右侧注册 "AI Content Import" Meta Box。
 * 2. 提供一个 Textarea，用户粘贴 AI 生成的 JSON。
 * 3. 点击 "Import" 按钮后，通过 AJAX 将 JSON 解析并写入对应的 ACF 字段。
 *
 * 架构:
 * - Meta Box: WordPress add_meta_boxes API
 * - AJAX: wp_ajax_{action}，nonce 校验
 * - ACF 写入: update_field()，支持 Repeater 嵌套
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ============================================================
// 1. Register Meta Box
// ============================================================

add_action( 'add_meta_boxes', 'linsy_register_product_import_metabox' );

function linsy_register_product_import_metabox() {
	add_meta_box(
		'linsy_product_ai_import',
		__( 'AI Content Import', 'generatepress_child' ),
		'linsy_render_product_import_metabox',
		'product',
		'side',
		'high'
	);
}

// ============================================================
// 2. Render Meta Box UI
// ============================================================

function linsy_render_product_import_metabox( $post ) {
	wp_nonce_field( 'linsy_product_import_action', 'linsy_product_import_nonce' );
	?>
	<div class="linsy-ai-import-wrap">
		<p class="description" style="margin-top:0;">
			<?php esc_html_e( 'Paste the AI-generated JSON below and click Import to populate all ACF fields.', 'generatepress_child' ); ?>
		</p>
		<textarea
			id="linsy-import-json"
			style="width:100%; min-height:180px; font-family:monospace; font-size:11px;"
			placeholder='{"hero":{"short_desc":"...","specs":[...]},"description":{...},...}'
		></textarea>

		<label style="display:block; margin:8px 0 4px; font-size:12px;">
			<input type="checkbox" id="linsy-import-update-title" value="1" />
			<?php esc_html_e( 'Also update Post Title from JSON (if present)', 'generatepress_child' ); ?>
		</label>

		<button
			type="button"
			id="linsy-import-btn"
			class="button button-primary"
			style="width:100%; margin-top:6px;"
			data-post-id="<?php echo (int) $post->ID; ?>"
		>
			<?php esc_html_e( 'Import Content', 'generatepress_child' ); ?>
		</button>

		<div id="linsy-import-feedback" style="margin-top:8px; font-size:12px;"></div>
	</div>

	<script>
	(function($) {
		$(document).ready(function() {
			var $btn      = $('#linsy-import-btn');
			var $area     = $('#linsy-import-json');
			var $feedback = $('#linsy-import-feedback');
			var $titleCb  = $('#linsy-import-update-title');
			var postId    = $btn.data('post-id');
			var nonce     = $('#linsy_product_import_nonce').val();

			$btn.on('click', function(e) {
				e.preventDefault();
				$feedback.html('');

				var raw = $area.val().trim();
				if (!raw) {
					$feedback.html('<span style="color:#d63638;">Please paste JSON first.</span>');
					return;
				}

				// Basic JSON syntax check
				try {
					JSON.parse(raw);
				} catch (err) {
					$feedback.html('<span style="color:#d63638;">Invalid JSON: ' + err.message + '</span>');
					return;
				}

				$btn.prop('disabled', true).text('Importing...');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action:   'linsy_import_product_json',
						nonce:    nonce,
						post_id:  postId,
						json:     raw,
						update_title: $titleCb.is(':checked') ? 1 : 0
					},
					success: function(res) {
						if (res.success) {
							var msg = '<span style="color:#00a32a;">Import successful! Updated ' + (res.data.fields_updated || 0) + ' fields.</span>';
							if (res.data.title_updated) {
								msg += '<br><span style="color:#00a32a;">Post title also updated.</span>';
							}
							$feedback.html(msg);
							$area.val('');
							// Refresh ACF fields visually
							if (typeof acf !== 'undefined') {
								setTimeout(function() { location.reload(); }, 800);
							}
						} else {
							var error = res.data && res.data.message ? res.data.message : 'Import failed.';
							$feedback.html('<span style="color:#d63638;">' + error + '</span>');
						}
					},
					error: function(xhr, status, error) {
						$feedback.html('<span style="color:#d63638;">AJAX Error: ' + error + '</span>');
					},
					complete: function() {
						$btn.prop('disabled', false).text('Import Content');
					}
				});
			});
		});
	})(jQuery);
	</script>
	<?php
}

// ============================================================
// 3. AJAX Handler
// ============================================================

add_action( 'wp_ajax_linsy_import_product_json', 'linsy_handle_product_json_import' );

function linsy_handle_product_json_import() {
	// Verify nonce
	if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'linsy_product_import_action' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed.', 'generatepress_child' ) ) );
	}

	// Verify capabilities
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( array( 'message' => __( 'Permission denied.', 'generatepress_child' ) ) );
	}

	$post_id = (int) ( $_POST['post_id'] ?? 0 );
	if ( ! $post_id || get_post_type( $post_id ) !== 'product' ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product ID.', 'generatepress_child' ) ) );
	}

	$raw_json = wp_unslash( $_POST['json'] ?? '' );
	if ( ! $raw_json ) {
		wp_send_json_error( array( 'message' => __( 'No JSON provided.', 'generatepress_child' ) ) );
	}

	$data = json_decode( $raw_json, true );
	if ( json_last_error() !== JSON_ERROR_NONE ) {
		wp_send_json_error( array( 'message' => __( 'JSON parse error: ', 'generatepress_child' ) . json_last_error_msg() ) );
	}

	if ( ! is_array( $data ) ) {
		wp_send_json_error( array( 'message' => __( 'JSON must be an object.', 'generatepress_child' ) ) );
	}

	// Check if ACF is active
	if ( ! function_exists( 'update_field' ) ) {
		wp_send_json_error( array( 'message' => __( 'ACF Pro is not active.', 'generatepress_child' ) ) );
	}

	// Execute import
	$result = linsy_process_product_json_import( $post_id, $data );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}

	wp_send_json_success( $result );
}

// ============================================================
// 4. Core Import Logic
// ============================================================

/**
 * Process JSON data and write to ACF fields.
 *
 * @param int   $post_id Post ID.
 * @param array $data    Decoded JSON data.
 * @return array|WP_Error Result or error.
 */
function linsy_process_product_json_import( $post_id, $data ) {
	$fields_updated = 0;
	$errors         = array();
	$title_updated  = false;

	// ── Optional: Update Post Title ──
	if ( ! empty( $data['post_title'] ) && ! empty( $_POST['update_title'] ) ) {
		wp_update_post(
			array(
				'ID'         => $post_id,
				'post_title' => sanitize_text_field( $data['post_title'] ),
			)
		);
		$title_updated = true;
	}

	// ── Hero Section ──
	if ( isset( $data['hero'] ) && is_array( $data['hero'] ) ) {
		$hero = $data['hero'];

		if ( isset( $hero['short_desc'] ) ) {
			update_field( 'product_hero_desc', sanitize_textarea_field( $hero['short_desc'] ), $post_id );
			++$fields_updated;
		}

		if ( isset( $hero['specs'] ) && is_array( $hero['specs'] ) ) {
			$specs = array_map(
				function ( $item ) {
					return array(
						'value' => isset( $item['value'] ) ? sanitize_text_field( $item['value'] ) : '',
						'label' => isset( $item['label'] ) ? sanitize_text_field( $item['label'] ) : '',
					);
				},
				$hero['specs']
			);
			update_field( 'product_hero_specs', $specs, $post_id );
			++$fields_updated;
		}
	}

	// ── Description Section ──
	if ( isset( $data['description'] ) && is_array( $data['description'] ) ) {
		$desc = $data['description'];

		if ( isset( $desc['content'] ) ) {
			update_field( 'product_desc_content', wp_kses_post( $desc['content'] ), $post_id );
			++$fields_updated;
		}

		if ( isset( $desc['features'] ) && is_array( $desc['features'] ) ) {
			$features = array_map(
				function ( $item ) {
					$text = is_array( $item ) ? ( $item['text'] ?? '' ) : (string) $item;
					return array( 'text' => sanitize_text_field( $text ) );
				},
				$desc['features']
			);
			update_field( 'product_desc_features', $features, $post_id );
			++$fields_updated;
		}
	}

	// ── Applications Section ──
	if ( isset( $data['applications'] ) && is_array( $data['applications'] ) ) {
		$apps = array_map(
			function ( $item ) {
				return array(
					'application_name'      => isset( $item['name'] ) ? sanitize_text_field( $item['name'] ) : '',
					'application_shortdesc' => isset( $item['short_desc'] ) ? sanitize_textarea_field( $item['short_desc'] ) : '',
				);
			},
			$data['applications']
		);
		update_field( 'product_application_list', $apps, $post_id );
		++$fields_updated;
	}

	// ── Specifications Section ──
	if ( isset( $data['specifications'] ) && is_array( $data['specifications'] ) ) {
		$tables = array_map(
			function ( $item ) {
				$table_data = array();
				if ( isset( $item['table_data'] ) && is_array( $item['table_data'] ) ) {
					$table_data = array_map(
						function ( $row ) {
							if ( ! is_array( $row ) ) {
								$row = array( (string) $row );
							}
							return array(
								'col_1' => isset( $row[0] ) ? sanitize_text_field( $row[0] ) : '',
								'col_2' => isset( $row[1] ) ? sanitize_text_field( $row[1] ) : '',
								'col_3' => isset( $row[2] ) ? sanitize_text_field( $row[2] ) : '',
								'col_4' => isset( $row[3] ) ? sanitize_text_field( $row[3] ) : '',
							);
						},
						$item['table_data']
					);
				}
				return array(
					'spec_table_name' => isset( $item['table_name'] ) ? sanitize_text_field( $item['table_name'] ) : '',
					'spec_table_data' => $table_data,
				);
			},
			$data['specifications']
		);
		update_field( 'product_spec_tables', $tables, $post_id );
		++$fields_updated;
	}

	// ── FAQ Section ──
	if ( isset( $data['faq'] ) && is_array( $data['faq'] ) ) {
		$faq = $data['faq'];

		if ( isset( $faq['title'] ) ) {
			update_field( 'contact_faq_title', sanitize_text_field( $faq['title'] ), $post_id );
			++$fields_updated;
		}

		if ( isset( $faq['description'] ) ) {
			update_field( 'contact_faq_desc', sanitize_textarea_field( $faq['description'] ), $post_id );
			++$fields_updated;
		}

		if ( isset( $faq['list'] ) && is_array( $faq['list'] ) ) {
			$list = array_map(
				function ( $item ) {
					return array(
						'contact_faq_question' => isset( $item['question'] ) ? sanitize_text_field( $item['question'] ) : '',
						'contact_faq_answer'   => isset( $item['answer'] ) ? sanitize_textarea_field( $item['answer'] ) : '',
					);
				},
				$faq['list']
			);
			update_field( 'contact_faq_list', $list, $post_id );
			++$fields_updated;
		}
	}

	return array(
		'fields_updated' => $fields_updated,
		'title_updated'  => $title_updated,
		'post_id'        => $post_id,
	);
}
