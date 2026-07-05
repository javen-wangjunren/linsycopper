<?php
/**
 * Single Post Template (文章详情页)
 * Path: single.php
 * 
 * Logic:
 * - 8+4 Grid Layout (Content + Sidebar).
 * - Reuses modular template parts for Header, Content, and Sidebar.
 * - Author info pulled from custom user meta.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="lc-blog-single-scope bg-white font-sans antialiased text-[#1F2937]">

    <?php
    while ( have_posts() ) :
        the_post();

        // 1. Article Header (Title, Meta, Featured Image)
        get_template_part( 'template-parts/single-blog/header' );
        ?>

        <!-- Main Content Area: 8+4 Grid -->
        <main class="pt-[100px] pb-[100px]">
            <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                    <!-- Mobile: Table of Contents above article body -->
                    <div class="lg:hidden">
                        <?php get_template_part( 'template-parts/single-blog/toc' ); ?>
                    </div>
                    
                    <!-- Left: Main Article Content (8 columns) -->
                    <div class="lg:col-span-8">
                        <?php get_template_part( 'template-parts/single-blog/content' ); ?>
                    </div>

                    <!-- Right: Sticky Sidebar (4 columns) -->
                    <aside class="lg:col-span-4 lg:sticky lg:top-24">
                        <?php get_template_part( 'template-parts/single-blog/sidebar' ); ?>
                    </aside>

                </div>
            </div>
        </main>

        <?php
        // 2. Related Posts Section (Optional: can be added later as a global module)
    endwhile;
    ?>

</div>

<?php
get_footer();
