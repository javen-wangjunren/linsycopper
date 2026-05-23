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

$copyright_text = function_exists( 'get_field' ) ? get_field( 'footer_copyright', 'option' ) : '';

?>

	</div><!-- #content -->
	</div><!-- #page -->

<!-- 
	Site Footer 
	==========================================================================
	基于 design-preview/footer.html 重构
	采用模块化设计，将 Contact 和 Menu 分离到 template-parts/footer/ 中
-->
<footer class="bg-white border-t border-border tdp-site-footer">
	<div class="mx-auto max-w-container px-container py-section-y-small lg:py-section-y">
		
		<div class="xl:grid xl:grid-cols-3 xl:gap-8">
			
			<!-- 左侧：品牌与联系 (Branding & Contact) -->
			<?php get_template_part( 'template-parts/footer/branding' ); ?>

			<!-- 右侧：导航菜单 (Navigation Menus) -->
			<?php get_template_part( 'template-parts/footer/menus' ); ?>

		</div>

		<!-- 底部版权 (Bottom Bar) -->
		<div class="mt-16 border-t border-border pt-8 lg:mt-24">
			<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
				<p class="text-[12px] font-mono text-muted tracking-tight"> 
					<?php 
						if ( $copyright_text ) {
							// 支持 {year} 占位符
							$copyright_text = str_replace( '{year}', date( 'Y' ), $copyright_text );
							echo esc_html( $copyright_text );
						} else {
							echo '&copy; ' . date('Y') . ' ' . get_bloginfo( 'name' ) . '. ALL RIGHTS RESERVED.';
						}
					?>
				</p>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>