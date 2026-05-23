<?php
/**
 * Footer Branding Part
 * 
 * Displays:
 * - Logo (ACF or Site Customizer fallback)
 * - Description (ACF)
 * - Social Links (LinkedIn only)
 */

$brand_info = get_field( 'footer_brand_info', 'option' );
$logo_image = isset( $brand_info['logo_image'] ) ? $brand_info['logo_image'] : '';
$brand_desc = isset( $brand_info['description'] ) ? $brand_info['description'] : '';
$social_linkedin = isset( $brand_info['social_linkedin'] ) ? $brand_info['social_linkedin'] : '';

// Default fallback for description
if ( ! $brand_desc ) {
	$brand_desc = 'Leading supplier of copper, brass, and bronze alloys. Serving aerospace, marine, and industrial markets globally since 1998.';
}
?>
<div>
	<div class="flex items-center gap-2 mb-6">
		<?php if ( $logo_image ) : ?>
			<?php echo wp_get_attachment_image( $logo_image, 'medium', false, array( 'class' => 'w-[200px] h-[40px] object-contain', 'style' => 'width:200px;height:40px;' ) ); ?>
		<?php elseif ( has_custom_logo() ) : 
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			if ( $logo ) : ?>
				<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="w-[200px] h-[40px] object-contain" style="width:200px;height:40px;">
			<?php endif; ?>
		<?php else : ?>
			<div class="w-10 h-10 bg-action-copper rounded-sm flex items-center justify-center font-bold text-lg text-white select-none">
				<?php echo strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ); ?>
			</div>
			<span class="text-xl font-bold text-white">
				<?php bloginfo( 'name' ); ?>
			</span>
		<?php endif; ?>
	</div>
	
	<p class="text-sm leading-relaxed text-white opacity-80 mb-6">
		<?php echo esc_html( $brand_desc ); ?>
	</p>
	
	<div class="flex space-x-4">
		<?php if ( $social_linkedin ) : ?>
		<!-- LinkedIn -->
		<a href="<?php echo esc_url( $social_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-white/10 rounded-sm flex items-center justify-center hover:bg-action-copper transition-colors text-white" aria-label="LinkedIn">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
		</a>
		<?php endif; ?>
	</div>
</div>
