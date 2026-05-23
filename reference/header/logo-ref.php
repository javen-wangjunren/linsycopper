<?php
/**
 * Template part for displaying the logo.
 *
 * @package GeneratePress
 */

// Fetch ACF Data
$header_brand = function_exists( 'get_field' ) ? get_field( 'header_brand_global', 'option' ) : null;
$header_logo_id = is_array( $header_brand ) && isset( $header_brand['logo_image'] ) ? (int) $header_brand['logo_image'] : 0;

?>

<div class="flex items-center gap-4">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
		<span class="inline-flex items-center">
			<?php if ( $header_logo_id ) : ?>
				<?php
					// 优化 Logo 加载：添加 lazy=eager 确保 LCP 性能
					$logo_attrs = array(
						'class' => 'block site-logo-img',
						'loading' => 'eager', // 关键优化：首屏资源禁止懒加载
					);
					echo wp_get_attachment_image( $header_logo_id, 'full', false, $logo_attrs );
				?>
			<?php else : ?>
				<!-- Fallback Text Logo -->
				<span class="inline-flex items-center justify-center rounded-lg bg-primary px-2 py-1 text-xs font-mono font-semibold text-white">LOGO</span>
			<?php endif; ?>
		</span>
	</a>
</div>