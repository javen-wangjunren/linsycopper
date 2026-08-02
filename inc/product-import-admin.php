<?php
/**
 * Product AI Content Import — Admin Page
 *
 * 功能:
 * 在 Tools 菜单下注册 "Product Import" 管理页。
 * 支持上传 JSON 文件（单个产品）或 ZIP 压缩包（批量产品）。
 * 所有产品以 Draft 状态创建，并自动写入 ACF 字段。
 *
 * 使用方式:
 * - 单个 JSON: 上传 .json 文件，包含一个产品对象或产品数组
 * - 批量 ZIP: 上传 .zip 文件，内含多个 .json 文件，每个 JSON 文件 = 一个产品
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

	$max_upload = size_format( wp_max_upload_size() );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<div class="notice notice-info">
			<p><strong><?php esc_html_e( 'Quick Guide', 'generatepress_child' ); ?></strong></p>
			<ul style="list-style:disc;padding-left:20px;">
				<li><?php esc_html_e( 'Upload .json / .zip to create new products (Draft).', 'generatepress_child' ); ?></li>
				<li><?php esc_html_e( 'Check "Update existing" to match products by post_id and append/update fields without creating new posts.', 'generatepress_child' ); ?></li>
				<li><?php esc_html_e( 'Use "Export All Products" to download a JSON snapshot for editing or AI processing.', 'generatepress_child' ); ?></li>
			</ul>
		</div>

		<form id="linsy-batch-import-form" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'linsy_batch_import_action', 'linsy_batch_import_nonce' ); ?>

			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="linsy-import-file">
							<?php esc_html_e( 'Upload File', 'generatepress_child' ); ?>
						</label>
					</th>
					<td>
						<input
							type="file"
							id="linsy-import-file"
							name="import_file"
							accept=".json,.zip"
							style="font-size:14px;"
						/>
						<p class="description">
							<?php
							printf(
								esc_html__( 'Accepted: .json (single/batch) or .zip (multiple .json files). Max size: %s.', 'generatepress_child' ),
								esc_html( $max_upload )
							);
							?>
						</p>
						<label style="display:block;margin-top:8px;">
							<input type="checkbox" id="linsy-update-existing" name="update_existing" value="1" />
							<?php esc_html_e( 'Update existing products (match by post_id in JSON)', 'generatepress_child' ); ?>
						</label>
					</td>
				</tr>
			</table>

			<p class="submit">
				<button type="submit" class="button button-primary" id="linsy-import-submit">
					<?php esc_html_e( 'Upload & Import', 'generatepress_child' ); ?>
				</button>
				<button type="button" class="button" id="linsy-export-btn">
					<?php esc_html_e( 'Export All Products', 'generatepress_child' ); ?>
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
			var $btn    = $('#linsy-import-submit');
			var $file   = $('#linsy-import-file');

			$form.on('submit', function(e) {
				e.preventDefault();

				var file = $file[0].files[0];
				if (!file) {
					$result.html('<div class="notice notice-error"><p><?php echo esc_js( __( 'Please select a file.', 'generatepress_child' ) ); ?></p></div>');
					return;
				}

				var ext = file.name.split('.').pop().toLowerCase();
				if (ext !== 'json' && ext !== 'zip') {
					$result.html('<div class="notice notice-error"><p><?php echo esc_js( __( 'Only .json and .zip files are accepted.', 'generatepress_child' ) ); ?></p></div>');
					return;
				}

				$result.html('<p><?php echo esc_js( __( 'Uploading and processing...', 'generatepress_child' ) ); ?></p>');
				$btn.prop('disabled', true).text('<?php echo esc_js( __( 'Processing...', 'generatepress_child' ) ); ?>');

				var formData = new FormData();
				formData.append('action', 'linsy_batch_import_products');
				formData.append('nonce', $form.find('[name="linsy_batch_import_nonce"]').val());
				formData.append('import_file', file);
				formData.append('update_existing', $('#linsy-update-existing').is(':checked') ? '1' : '0');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: formData,
					processData: false,
					contentType: false,
					success: function(res) {
						if (res.success) {
							var html = '<div class="notice notice-success"><p><strong>' +
								'<?php echo esc_js( __( 'Import Complete!', 'generatepress_child' ) ); ?>' +
								'</strong></p><ul>';
							if (res.data.created) html += '<li><?php echo esc_js( __( 'Created:', 'generatepress_child' ) ); ?> ' + res.data.created + '</li>';
							if (res.data.updated) html += '<li><?php echo esc_js( __( 'Updated:', 'generatepress_child' ) ); ?> ' + res.data.updated + '</li>';
							if (res.data.skipped) html += '<li><?php echo esc_js( __( 'Skipped:', 'generatepress_child' ) ); ?> ' + res.data.skipped + '</li>';
							if (res.data.failed) html += '<li><?php echo esc_js( __( 'Failed:', 'generatepress_child' ) ); ?> ' + res.data.failed + '</li>';
							html += '</ul>';
							if (res.data.links && res.data.links.length) {
								html += '<p><?php echo esc_js( __( 'Created products:', 'generatepress_child' ) ); ?></p><ul>';
								res.data.links.forEach(function(link) {
									html += '<li><a href="' + link.edit + '" target="_blank">' + link.title + ' (Draft)</a></li>';
								});
								html += '</ul>';
							}
							html += '</div>';
							$result.html(html);
							$file.val('');
						} else {
							var msg = res.data && res.data.message ? res.data.message : '<?php echo esc_js( __( 'Import failed.', 'generatepress_child' ) ); ?>';
							$result.html('<div class="notice notice-error"><p>' + msg + '</p></div>');
						}
					},
					error: function(xhr) {
						var msg = '<?php echo esc_js( __( 'Upload error.', 'generatepress_child' ) ); ?>';
						if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
							msg = xhr.responseJSON.data.message;
						}
						$result.html('<div class="notice notice-error"><p>' + msg + '</p></div>');
					},
					complete: function() {
						$btn.prop('disabled', false).text('<?php echo esc_js( __( 'Upload & Import', 'generatepress_child' ) ); ?>');
					}
				});
			});
		// Export button
			$('#linsy-export-btn').on('click', function(e) {
				e.preventDefault();
				var $exportBtn = $(this);
				$exportBtn.prop('disabled', true).text('<?php echo esc_js( __( 'Exporting...', 'generatepress_child' ) ); ?>');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'linsy_export_products',
						nonce: $form.find('[name="linsy_batch_import_nonce"]').val()
					},
					success: function(res) {
						if (res.success) {
							var jsonStr = JSON.stringify(res.data.products, null, 2);
							var blob = new Blob([jsonStr], {type: 'application/json'});
							var url = URL.createObjectURL(blob);
							var a = document.createElement('a');
							a.href = url;
							a.download = 'products-export-' + new Date().toISOString().slice(0,10) + '.json';
							document.body.appendChild(a);
							a.click();
							document.body.removeChild(a);
							URL.revokeObjectURL(url);
							$result.html('<div class="notice notice-success"><p><?php echo esc_js( __( 'Exported', 'generatepress_child' ) ); ?> ' + (res.data.count || 0) + ' <?php echo esc_js( __( 'products.', 'generatepress_child' ) ); ?></p></div>');
						} else {
							$result.html('<div class="notice notice-error"><p>' + (res.data && res.data.message ? res.data.message : '<?php echo esc_js( __( 'Export failed.', 'generatepress_child' ) ); ?>') + '</p></div>');
						}
					},
					error: function() {
						$result.html('<div class="notice notice-error"><p><?php echo esc_js( __( 'Export error.', 'generatepress_child' ) ); ?></p></div>');
					},
					complete: function() {
						$exportBtn.prop('disabled', false).text('<?php echo esc_js( __( 'Export All Products', 'generatepress_child' ) ); ?>');
					}
				});
			});
		});
	})(jQuery);
	</script>
	<?php
}

// ============================================================
// 3. Core Import Logic — Write ACF Fields
// ============================================================

/**
 * Process JSON data and write to ACF fields.
 *
 * @param int   $post_id Post ID.
 * @param array $data    Decoded JSON data.
 * @return array Result with fields_updated count.
 */
function linsy_process_product_json_import( $post_id, $data ) {
	$fields_updated = 0;

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
		'post_id'        => $post_id,
	);
}

// ============================================================
// 4. Export AJAX Handler
// ============================================================

add_action( 'wp_ajax_linsy_export_products', 'linsy_handle_export_products' );

function linsy_handle_export_products() {
	if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'linsy_batch_import_action' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed.', 'generatepress_child' ) ) );
	}

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_send_json_error( array( 'message' => __( 'Permission denied.', 'generatepress_child' ) ) );
	}

	$posts = get_posts(
		array(
			'post_type'      => 'product',
			'post_status'    => array( 'publish', 'draft', 'pending' ),
			'posts_per_page' => -1,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		)
	);

	$products = array();

	foreach ( $posts as $post ) {
		$product = array(
			'post_id'          => $post->ID,
			'post_title'       => $post->post_title,
			'post_status'      => $post->post_status,
		);

		// Hero
		$hero_desc  = get_field( 'product_hero_desc', $post->ID );
		$hero_specs = get_field( 'product_hero_specs', $post->ID );
		if ( $hero_desc || $hero_specs ) {
			$product['hero'] = array();
			if ( $hero_desc ) {
				$product['hero']['short_desc'] = $hero_desc;
			}
			if ( $hero_specs && is_array( $hero_specs ) ) {
				$product['hero']['specs'] = array_map(
					function ( $s ) {
						return array(
							'value' => $s['value'] ?? '',
							'label' => $s['label'] ?? '',
						);
					},
					$hero_specs
				);
			}
		}

		// Description
		$desc_content  = get_field( 'product_desc_content', $post->ID );
		$desc_features = get_field( 'product_desc_features', $post->ID );
		if ( $desc_content || $desc_features ) {
			$product['description'] = array();
			if ( $desc_content ) {
				$product['description']['content'] = $desc_content;
			}
			if ( $desc_features && is_array( $desc_features ) ) {
				$product['description']['features'] = array_map(
					function ( $f ) {
						return $f['text'] ?? '';
					},
					$desc_features
				);
			}
		}

		// Applications
		$apps = get_field( 'product_application_list', $post->ID );
		if ( $apps && is_array( $apps ) ) {
			$product['applications'] = array_map(
				function ( $a ) {
					return array(
						'name'       => $a['application_name'] ?? '',
						'short_desc' => $a['application_shortdesc'] ?? '',
					);
				},
				$apps
			);
		}

		// Specifications
		$tables = get_field( 'product_spec_tables', $post->ID );
		if ( $tables && is_array( $tables ) ) {
			$product['specifications'] = array_map(
				function ( $t ) {
					$data = array();
					if ( isset( $t['spec_table_data'] ) && is_array( $t['spec_table_data'] ) ) {
						$data = array_map(
							function ( $row ) {
								return array(
									$row['col_1'] ?? '',
									$row['col_2'] ?? '',
									$row['col_3'] ?? '',
									$row['col_4'] ?? '',
								);
							},
							$t['spec_table_data']
						);
					}
					return array(
						'table_name' => $t['spec_table_name'] ?? '',
						'table_data' => $data,
					);
				},
				$tables
			);
		}

		// FAQ
		$faq_title = get_field( 'contact_faq_title', $post->ID );
		$faq_desc  = get_field( 'contact_faq_desc', $post->ID );
		$faq_list  = get_field( 'contact_faq_list', $post->ID );
		if ( $faq_title || $faq_desc || $faq_list ) {
			$product['faq'] = array(
				'title'       => $faq_title ?: '',
				'description' => $faq_desc ?: '',
			);
			if ( $faq_list && is_array( $faq_list ) ) {
				$product['faq']['list'] = array_map(
					function ( $f ) {
						return array(
							'question' => $f['contact_faq_question'] ?? '',
							'answer'   => $f['contact_faq_answer'] ?? '',
						);
					},
					$faq_list
				);
			}
		}

		$products[] = $product;
	}

	wp_send_json_success(
		array(
			'count'    => count( $products ),
			'products' => $products,
		)
	);
}

// ============================================================
// 5. AJAX Handler — File Upload & Import
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

	if ( ! function_exists( 'update_field' ) ) {
		wp_send_json_error( array( 'message' => __( 'ACF Pro is not active.', 'generatepress_child' ) ) );
	}

	// Handle file upload
	if ( empty( $_FILES['import_file'] ) ) {
		wp_send_json_error( array( 'message' => __( 'No file uploaded.', 'generatepress_child' ) ) );
	}

	$file = $_FILES['import_file'];

	// Check upload errors
	if ( $file['error'] !== UPLOAD_ERR_OK ) {
		$upload_errors = array(
			UPLOAD_ERR_INI_SIZE   => __( 'File exceeds upload_max_filesize.', 'generatepress_child' ),
			UPLOAD_ERR_FORM_SIZE  => __( 'File exceeds form max size.', 'generatepress_child' ),
			UPLOAD_ERR_PARTIAL    => __( 'File was only partially uploaded.', 'generatepress_child' ),
			UPLOAD_ERR_NO_FILE    => __( 'No file was uploaded.', 'generatepress_child' ),
			UPLOAD_ERR_NO_TMP_DIR => __( 'Missing temporary folder.', 'generatepress_child' ),
			UPLOAD_ERR_CANT_WRITE => __( 'Failed to write file to disk.', 'generatepress_child' ),
		);
		$msg = $upload_errors[ $file['error'] ] ?? __( 'Unknown upload error.', 'generatepress_child' );
		wp_send_json_error( array( 'message' => $msg ) );
	}

	$ext = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

	if ( ! in_array( $ext, array( 'json', 'zip' ), true ) ) {
		wp_send_json_error( array( 'message' => __( 'Only .json and .zip files are accepted.', 'generatepress_child' ) ) );
	}

	// Parse JSON data from file(s)
	$all_products = array();

	if ( 'json' === $ext ) {
		$content = file_get_contents( $file['tmp_name'] );
		if ( false === $content ) {
			wp_send_json_error( array( 'message' => __( 'Failed to read uploaded file.', 'generatepress_child' ) ) );
		}

		$data = json_decode( $content, true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			wp_send_json_error( array( 'message' => __( 'JSON parse error: ', 'generatepress_child' ) . json_last_error_msg() ) );
		}

		// Normalize: single object -> array
		if ( isset( $data['post_title'] ) ) {
			$data = array( $data );
		}

		if ( ! is_array( $data ) ) {
			wp_send_json_error( array( 'message' => __( 'JSON must be an object or array of objects.', 'generatepress_child' ) ) );
		}

		$all_products = $data;

	} elseif ( 'zip' === $ext ) {
		// Extract ZIP and read all .json files
		if ( ! class_exists( 'ZipArchive' ) ) {
			wp_send_json_error( array( 'message' => __( 'ZipArchive is not available on this server.', 'generatepress_child' ) ) );
		}

		$zip = new ZipArchive();
		$result = $zip->open( $file['tmp_name'] );

		if ( true !== $result ) {
			wp_send_json_error( array( 'message' => __( 'Failed to open ZIP file. Error code: ', 'generatepress_child' ) . $result ) );
		}

		$json_files = array();
		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
			$entry_name = $zip->getNameIndex( $i );
			// Skip directories and hidden files, only process .json
			if ( substr( $entry_name, -1 ) === '/' ) {
				continue;
			}
			if ( strpos( basename( $entry_name ), '.' ) === 0 ) {
				continue;
			}
			if ( strtolower( pathinfo( $entry_name, PATHINFO_EXTENSION ) ) !== 'json' ) {
				continue;
			}
			$json_files[] = $entry_name;
		}

		if ( empty( $json_files ) ) {
			$zip->close();
			wp_send_json_error( array( 'message' => __( 'No .json files found in the ZIP archive.', 'generatepress_child' ) ) );
		}

		foreach ( $json_files as $entry_name ) {
			$content = $zip->getFromName( $entry_name );
			if ( false === $content ) {
				continue;
			}

			$data = json_decode( $content, true );
			if ( json_last_error() !== JSON_ERROR_NONE || ! is_array( $data ) ) {
				continue;
			}

			// If the JSON file contains an array of products, add them all
			if ( isset( $data['post_title'] ) ) {
				$all_products[] = $data;
			} elseif ( isset( $data[0] ) && is_array( $data[0] ) ) {
				foreach ( $data as $item ) {
					if ( is_array( $item ) ) {
						$all_products[] = $item;
					}
				}
			}
		}

		$zip->close();

		if ( empty( $all_products ) ) {
			wp_send_json_error( array( 'message' => __( 'No valid product data found in ZIP. Each .json file must contain a product object with "post_title".', 'generatepress_child' ) ) );
		}
	}

	// ── Import All Products ──
	$update_existing = ! empty( $_POST['update_existing'] );
	$created = 0;
	$updated = 0;
	$skipped = 0;
	$failed  = 0;
	$links   = array();

	foreach ( $all_products as $product_data ) {
		if ( ! is_array( $product_data ) ) {
			++$skipped;
			continue;
		}

		// Check if this is an update to an existing product
		$post_id = null;
		if ( $update_existing && ! empty( $product_data['post_id'] ) ) {
			$existing = get_post( (int) $product_data['post_id'] );
			if ( $existing && 'product' === $existing->post_type ) {
				$post_id = $existing->ID;
			}
		}

		if ( $post_id ) {
			// Update existing product
			linsy_process_product_json_import( $post_id, $product_data );
			++$updated;
			$links[] = array(
				'title' => get_the_title( $post_id ),
				'edit'  => get_edit_post_link( $post_id, 'raw' ),
			);
		} else {
			// Create new product
			if ( empty( $product_data['post_title'] ) ) {
				++$skipped;
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

			linsy_process_product_json_import( $post_id, $product_data );

			++$created;
			$links[] = array(
				'title' => sanitize_text_field( $product_data['post_title'] ),
				'edit'  => get_edit_post_link( $post_id, 'raw' ),
			);
		}
	}

	wp_send_json_success(
		array(
			'created' => $created,
			'updated' => $updated,
			'skipped' => $skipped,
			'failed'  => $failed,
			'links'   => $links,
		)
	);
}