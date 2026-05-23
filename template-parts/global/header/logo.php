<?php
/**
 * Template part for displaying the header logo.
 * 
 * Logic:
 * 1. Checks for Custom Logo (from Site Identity).
 * 2. Fallback to Text Logo if no image is set.
 * 3. Enforces strict height constraints (h-8 / 32px) to prevent layout shifts.
 *
 * @package GeneratePress_Child
 */

// Get Custom Logo ID
$custom_logo_id = get_theme_mod( 'custom_logo' );
?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 flex-shrink-0 hover:opacity-85 transition-opacity" aria-label="<?php bloginfo( 'name' ); ?> — home">
	<?php if ( $custom_logo_id ) : ?>
		<?php
			// Get logo attributes
			$logo_src = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			
			if ( $logo_src ) : 
				// Output Image with strict classes
				?>
				<img 
					src="<?php echo esc_url( $logo_src[0] ); ?>" 
					alt="<?php bloginfo( 'name' ); ?>" 
					class="h-8 w-auto object-contain" 
					width="<?php echo esc_attr( $logo_src[1] ); ?>"
					height="<?php echo esc_attr( $logo_src[2] ); ?>"
					style="height: 32px; width: auto;"
				>
			<?php endif; ?>
	<?php else : ?>
		<!-- Fallback: Text Logo -->
		<div class="w-8 h-8 bg-action-copper rounded-sm flex items-center justify-center font-bold text-white text-base leading-none select-none">
			<?php echo strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ); ?>
		</div>
		<span class="font-bold text-[17px] text-white tracking-tight hidden sm:inline">
			<?php bloginfo( 'name' ); ?>
		</span>
	<?php endif; ?>
</a>
