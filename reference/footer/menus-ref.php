<?php
/**
 * Template part for displaying footer navigation menus.
 *
 * @package GeneratePress
 */

// Fetch Extra Links (e.g. View All Materials)
$materials_view_all = function_exists( 'get_field' ) ? get_field( 'materials_view_all', 'option' ) : null;

/**
 * Helper function to render a footer menu column.
 * Encapsulates the wp_nav_menu logic to avoid repetition.
 *
 * @param string $title    Column title.
 * @param string $location Menu location slug.
 * @param string $class    Additional wrapper classes.
 */
if ( ! function_exists( 'tdp_render_footer_column' ) ) {
	function tdp_render_footer_column( $title, $location, $class = '' ) {
		// Only render if location is assigned or fallback behavior is handled
		// But wp_nav_menu handles empty locations gracefully usually.
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<h3 class="text-[15px] font-bold text-heading uppercase mb-6"><?php echo esc_html( $title ); ?></h3>
			<?php
			wp_nav_menu( array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'space-y-4 text-small footer-link-list',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
				'fallback_cb'    => false,
			) );
			?>
		</div>
		<?php
	}
}
?>

<div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
	
	<!-- Group 1: Capabilities & Materials -->
	<div class="md:grid md:grid-cols-2 md:gap-8">
		
		<!-- Capabilities Menu -->
		<?php tdp_render_footer_column( 'Capabilities', 'footer_capabilities' ); ?>

		<!-- Materials Menu -->
		<div>
			<?php tdp_render_footer_column( 'Materials', 'footer_materials', 'mb-0' ); ?>
			
			<!-- View All Link -->
			<?php if ( $materials_view_all ) : 
				$link_url    = isset( $materials_view_all['url'] ) ? $materials_view_all['url'] : '';
				$link_title  = isset( $materials_view_all['title'] ) ? $materials_view_all['title'] : '';
				$link_target = isset( $materials_view_all['target'] ) && $materials_view_all['target'] ? $materials_view_all['target'] : '_self';
				
				if ( $link_url ) :
			?>
			<div class="mt-6">
				<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="group flex flex-col gap-2 text-primary font-bold text-[15px] hover:text-primary-hover transition-colors">
					<span><?php echo esc_html( $link_title ); ?></span>
					<svg class="w-4 h-4 transform transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
					</svg>
				</a>
			</div>
			<?php endif; endif; ?>
		</div>
	</div>

	<!-- Group 2: Resources & Company -->
	<div class="md:grid md:grid-cols-2 md:gap-8">
		
		<!-- Resources Menu (Hidden Temporarily) -->
		<?php if ( false ) : ?>
			<?php tdp_render_footer_column( 'Resources', 'footer_resources' ); ?>
		<?php endif; ?>

		<!-- Company Menu -->
		<?php tdp_render_footer_column( 'Company', 'footer_company', 'mt-10 md:mt-0' ); ?>
		
	</div>

</div>