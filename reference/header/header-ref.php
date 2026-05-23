<?php
/**
 * 头部模板 (Header Template)
 * REFERENCE FILE - 仅供 AI 参考，不可执行
 * 真实路径映射：
 * header-ref.php      → header.php
 * logo-ref.php        → template-parts/header/logo.php
 * nav-desktop-ref.php → template-parts/header/nav-desktop.php
 * nav-mobile-ref.php  → template-parts/header/nav-mobile.php
 * ==========================================================================
 * 文件作用:
 * 负责渲染网站的 HTML 头部结构，包括 DOCTYPE, <head> 元数据, 
 * 以及顶部的导航栏 (Navigation Bar)。
 *
 * 核心逻辑:
 * 1. 初始化: 加载 wp_head(), 设置 charset 和 viewport。
 * 2. 动态样式: 处理 Logo 宽度等动态 CSS。
 * 3. 导航渲染: 
 *    - 通过 get_template_part 加载子模块 (Logo, Desktop Nav, Mobile Nav)。
 *    - 实现了关注点分离 (Separation of Concerns)。
 *
 * 架构角色:
 * 它是页面的"门面"。在 GeneratePress + Tailwind 架构中，我们完全重写了
 * 默认的 GP Header。
 *
 * 🚨 避坑指南:
 * - 必须保留 `wp_head()` 和 `wp_body_open()`。
 * - 子模块路径: `template-parts/header/`
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Preconnect & Preload -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	/**
	 * wp_body_open hook.
	 * 
	 * @since 0.1
	 */
	do_action( 'wp_body_open' );

	// ==========================================================================
	// I. 数据获取 (Data Fetching) - 仅获取用于 Header 容器的样式数据
	// ==========================================================================
	$header_brand = function_exists( 'get_field' ) ? get_field( 'header_brand_global', 'option' ) : null;
	$header_logo_width = is_array( $header_brand ) && isset( $header_brand['logo_width'] ) ? (int) $header_brand['logo_width'] : 0;
	$header_logo_width_mobile = is_array( $header_brand ) && isset( $header_brand['logo_width_mobile'] ) ? (int) $header_brand['logo_width_mobile'] : 0;
	?>

	<!-- ==========================================================================
	     II. 动态样式注入 (Dynamic Styles)
	     ========================================================================== -->
	<?php if ( $header_logo_width > 0 || $header_logo_width_mobile > 0 ) : ?>
		<style>
			.site-logo-img {
				width: <?php echo $header_logo_width_mobile > 0 ? $header_logo_width_mobile : 'auto'; ?>px;
				height: auto;
				max-width: 100%;
			}
			@media (min-width: 1024px) {
				.site-logo-img {
					width: <?php echo $header_logo_width > 0 ? $header_logo_width : 'auto'; ?>px;
				}
			}
		</style>
	<?php endif; ?>

	<!-- ==========================================================================
	     III. 导航栏结构 (Navigation Bar)
	     ========================================================================== -->
	<header x-data="{ openMenu: null, mobileOpen: false }" @mouseleave="openMenu = null" class="relative z-40 bg-white border-b border-border">
		<div class="mx-auto max-w-container px-container">
			<div class="flex h-20 items-center justify-between">
				
				<!-- 1. Logo Section -->
				<?php get_template_part( 'template-parts/header/logo' ); ?>

				<!-- 2. Desktop Navigation (lg:flex) -->
				<?php get_template_part( 'template-parts/header/nav-desktop' ); ?>

				<!-- 3. Mobile Navigation (Drawer & Toggle) -->
				<?php get_template_part( 'template-parts/header/nav-mobile' ); ?>

			</div>
		</div>
	</header>

	<div <?php generate_do_attr( 'page' ); ?>>
		<?php
		/**
		 * generate_inside_site_container hook.
		 *
		 * @since 2.4
		 */
		do_action( 'generate_inside_site_container' );
		?>
		<div id="content" class="site-content">
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );