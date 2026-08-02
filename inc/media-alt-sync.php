<?php
/**
 * Media Alt Text Auto-Sync
 * ==========================================================================
 * 功能:
 * 1. 上传图片时，自动将 Alt Text 同步为 Title（带关键词的文件名）
 * 2. 在媒体库编辑页面，修改 Title 时自动同步 Alt Text
 * 3. 在媒体库弹窗（Media Modal）中，修改 Title 时自动同步 Alt Text
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. PHP: 上传时自动设置 Alt Text = Title
// ==========================================
add_action( 'add_attachment', 'linsy_sync_alt_from_title_on_upload' );

/**
 * When a new attachment is uploaded, copy the title to alt text.
 *
 * @param int $attachment_id Attachment post ID.
 */
function linsy_sync_alt_from_title_on_upload( $attachment_id ) {
	$post = get_post( $attachment_id );

	if ( ! $post || 'attachment' !== $post->post_type ) {
		return;
	}

	$title = trim( $post->post_title );

	if ( '' === $title ) {
		return;
	}

	// Only set alt text if it's currently empty (don't overwrite existing)
	$existing_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

	if ( '' !== $existing_alt ) {
		return;
	}

	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $title );
}

// ==========================================
// 2. JS: 媒体库编辑页面自动同步
// ==========================================
add_action( 'admin_enqueue_scripts', 'linsy_enqueue_media_alt_sync_script' );

/**
 * Enqueue JS on attachment edit screen to sync title -> alt text.
 *
 * @param string $hook Current admin page hook.
 */
function linsy_enqueue_media_alt_sync_script( $hook ) {
	// Only on attachment edit page
	if ( 'post.php' !== $hook ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'attachment' !== $screen->post_type ) {
		return;
	}

	$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const titleInput = document.getElementById('title');
	const altInput   = document.getElementById('attachment_alt');

	if (!titleInput || !altInput) {
		return;
	}

	// Sync on blur: when user finishes editing the title, update alt text
	titleInput.addEventListener('blur', function () {
		const titleVal = this.value.trim();
		if (titleVal) {
			altInput.value = titleVal;
		}
	});
});
JS;

	wp_add_inline_script( 'wp-admin', $js );
}

// ==========================================
// 3. JS: 媒体库弹窗（Media Modal）中自动同步
// ==========================================
add_action( 'admin_footer', 'linsy_print_media_modal_alt_sync_script' );

/**
 * Print inline script that hooks into the WordPress media modal
 * to auto-sync alt text whenever the title field changes.
 */
function linsy_print_media_modal_alt_sync_script() {
	// Only on pages that may have a media modal
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->base, [ 'post', 'upload', 'media' ], true ) ) {
		return;
	}
	?>
	<script>
	(function () {
		if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
			return;
		}

		// Hook into the attachment details view in the media modal
		wp.media.view.Attachment.Details.prototype.on('ready', function () {
			const view = this;
			const titleInput = view.$el.find('[data-setting="title"]');
			const altInput   = view.$el.find('[data-setting="alt"]');

			if (!titleInput.length || !altInput.length) {
				return;
			}

			// Sync on blur
			titleInput.off('blur.altSync').on('blur.altSync', function () {
				const titleVal = this.value.trim();
				if (titleVal) {
					altInput.val(titleVal).trigger('change');
				}
			});
		});
	})();
	</script>
	<?php
}