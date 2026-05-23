<?php
/**
 * Single Post（文章详情页）
 * ==========================================================================
 * 文件作用:
 * - 用于 WordPress 标准文章（post）的详情页渲染
 * - 负责组装：Header / Content / Sidebar / Related Blog（全局模块）
 *
 * 核心逻辑:
 * 1. 走 WP Loop 获取当前文章
 * 2. 使用 template-parts/single-blog/* 拆分渲染职责
 * 3. Related Blog 通过分类自动匹配（作为内容延展模块）
 *
 * 架构角色:
 * - 作为 GeneratePress Child 的单文章模板入口，确保页面结构统一
 * - 将复杂内容拆分为可维护的 template-parts，并复用全局区块渲染器
 *
 * 🚨 避坑指南:
 * - 不要在这里塞入长篇 HTML：优先拆到 template-parts/single-blog/
 * - Related Blog 的数据聚合在此处完成，避免在模块内部做额外查询或耦合
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="bg-white font-sans antialiased text-heading">

	<?php
	// I. WP Loop（单篇文章）
	while ( have_posts() ) :
		the_post();

		// II. Header
		get_template_part( 'template-parts/single-blog/header' );
		?>

		<main class="py-24">
			<div class="w-[90%] lg:w-[80%] mx-auto max-w-[1440px] grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
				
				<?php
				// III. Main Content
				get_template_part( 'template-parts/single-blog/content' );

				// IV. Sidebar (TOC + Author + CTA)
				get_template_part( 'template-parts/single-blog/sidebar' );
				?>

			</div>
		</main>

		<?php
		// V. Related Posts（复用全局 Related Blog 模块）
		// 自动获取当前文章分类，传递给 Related Blog 模块用于匹配
		$categories = get_the_category();
		$cat_id     = ! empty( $categories ) ? $categories[0]->term_id : '';

		_3dp_render_block( 'blocks/global/related-blog/render', array(
			'posts_mode'      => 'category',
			'select_category' => $cat_id,
			'posts_count'     => 3,
			'blog_title'      => 'Related Manufacturing',
			'blog_subtitle'   => 'Explore the latest technical guides, material breakthroughs, and industry case studies.',
			'background_color' => '#F8F9FB', // bg-panel
		) );

	endwhile;
	?>

</div>

<?php
get_footer();
