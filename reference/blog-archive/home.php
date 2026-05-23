<?php
/**
 * Blog Index（文章列表页 / Posts Page）
 * ==========================================================================
 * 文件作用:
 * - 用于 WordPress 的「文章索引页」（通常是“设置 → 阅读 → 文章页”对应页面）
 * - 负责组装 Blog Archive 的三个模板模块：Header / Grid / Pagination
 *
 * 核心逻辑:
 * 1. 输出页面骨架（容器/间距/背景）
 * 2. 通过 get_template_part 组合模块，保持主模板足够“薄”
 *
 * 架构角色:
 * - 作为 Theme Router（WP 模板层）的一部分，将复杂渲染拆分到 template-parts/blog-archive/
 * - 保证 GeneratePress + Tailwind 的布局稳定性，避免散落的 HTML 结构
 *
 * 🚨 避坑指南:
 * - 不要在此文件写 WP_Query / 过滤逻辑：归档筛选与循环应在对应 template-part 内实现
 * - 若要支持更多筛选条件，优先扩展 header/grid 的模块，而不是改动此文件
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="bg-white font-sans antialiased text-heading">
	<section class="py-24 bg-white">
		<div class="w-[90%] lg:w-[80%] mx-auto max-w-[1440px]">

			<?php
			// I. Header & Filter
			get_template_part( 'template-parts/blog-archive/header' );

			// II. Grid
			get_template_part( 'template-parts/blog-archive/grid' );

			// III. Pagination
			get_template_part( 'template-parts/blog-archive/pagination' );
			?>

		</div>
	</section>
</div>

<?php
get_footer();
