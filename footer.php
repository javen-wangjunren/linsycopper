<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$current_year = date( 'Y' );

// Fetch ACF Data
$menu_products_title = get_field( 'footer_menu_products_title', 'option' );
$menu_company_title  = get_field( 'footer_menu_company_title', 'option' );
$copyright_text      = get_field( 'footer_copyright_text', 'option' );

// Defaults
if ( ! $menu_products_title ) $menu_products_title = 'Products';
if ( ! $menu_company_title ) $menu_company_title = 'Company';
if ( ! $copyright_text ) $copyright_text = '© {year} CopperCorp Inc. All rights reserved.';

// Process Copyright
$copyright_text = str_replace( '{year}', $current_year, $copyright_text );
?>

	</div><!-- #content -->
	</div><!-- #page -->

<!-- 
	Site Footer 
	==========================================================================
	Converted from React Footer Component
	Context: /design-preview/react/footer.tsx
-->
<footer class="bg-primary-blue text-gray-300 border-t border-white/10">
	<!-- Main Footer Content -->
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
			
			<!-- 1. Brand & About -->
			<?php get_template_part( 'template-parts/global/footer/branding' ); ?>

			<!-- 2. Products Menu -->
			<div>
				<h4 class="text-white font-bold mb-6 uppercase text-sm tracking-wider">
					<?php echo esc_html( $menu_products_title ); ?>
				</h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_products',
					'container'      => false,
					'menu_class'     => 'lc-footer-menu-list text-sm',
					'fallback_cb'    => false,
					'depth'          => 1,
					'link_before'    => '',
					'link_after'     => '',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				) );
				?>
			</div>

			<!-- 3. Company Menu -->
			<div>
				<h4 class="text-white font-bold mb-6 uppercase text-sm tracking-wider">
					<?php echo esc_html( $menu_company_title ); ?>
				</h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_company',
					'container'      => false,
					'menu_class'     => 'lc-footer-menu-list text-sm',
					'fallback_cb'    => false,
					'depth'          => 1,
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				) );
				?>
			</div>

			<!-- 4. Contact Sales -->
			<div>
				<h4 class="text-white font-bold mb-6 uppercase text-sm tracking-wider">Contact Sales</h4>
				<?php get_template_part( 'template-parts/global/footer/contact-info' ); ?>
			</div>

		</div>
	</div>

	<!-- Bottom Bar -->
	<div class="border-t border-white/10">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
			<div class="text-center text-sm text-gray-400">
				<?php echo esc_html( $copyright_text ); ?>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
