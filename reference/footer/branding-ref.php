<?php
/**
 * Template part for displaying footer branding, contact info, and social links.
 *
 * @package GeneratePress
 */

// Fetch Data
$left_info    = function_exists( 'get_field' ) ? get_field( 'footer_left_info', 'option' ) : null;
$social_links = function_exists( 'get_field' ) ? get_field( 'footer_social_links', 'option' ) : null;

$logo_id      = 0;
$contact_list = array();

if ( is_array( $left_info ) ) {
	$logo_id      = isset( $left_info['logo_image'] ) ? (int) $left_info['logo_image'] : 0;
	$contact_list = isset( $left_info['contact_list'] ) ? $left_info['contact_list'] : array();
}
?>

<div class="space-y-8">
	<!-- 1. Logo -->
	<div class="flex items-center gap-2">
		<?php if ( $logo_id ) : ?>
			<?php echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'h-8 w-auto' ) ); ?>
		<?php else : ?>
			<span class="text-heading font-bold text-xl tracking-tighter uppercase"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		<?php endif; ?>
	</div>
	
	<!-- 2. Contact List -->
	<div class="space-y-6">
		<?php if ( ! empty( $contact_list ) ) : ?>
			<?php foreach ( $contact_list as $item ) : 
				$icon    = isset( $item['icon_svg'] ) ? $item['icon_svg'] : '';
				$content = isset( $item['content'] ) ? $item['content'] : '';
				if ( ! $content ) continue;
			?>
			<div class="flex items-start gap-4">
				<?php if ( $icon ) : ?>
					<div class="flex-shrink-0 w-5 h-5 text-primary mt-1">
						<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>
				<div class="text-body text-small leading-tight">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<!-- 3. Social Links -->
	<?php if ( $social_links ) : ?>
	<div class="flex gap-x-4 mt-24">
		<?php foreach ( $social_links as $link ) : 
			$url  = isset( $link['url'] ) ? $link['url'] : '';
			$icon = isset( $link['icon_svg'] ) ? $link['icon_svg'] : '';
			$name = isset( $link['name'] ) ? $link['name'] : '';
			if ( ! $url ) continue;
		?>
		<a href="<?php echo esc_url( $url ); ?>" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 text-muted hover:text-primary hover:bg-gray-100 transition-all border border-gray-100" aria-label="<?php echo esc_attr( $name ); ?>">
			<div class="w-5 h-5 flex items-center justify-center">
				<?php 
					if ( $icon ) {
						echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					} else {
						// Default Icon Fallback
						echo '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 22c-5.523 0-10-4.477-10-10s4.477-10 10-10 10 4.477 10 10-4.477 10-10 10z"/></svg>';
					}
				?>
			</div>
		</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>