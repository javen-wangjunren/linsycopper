<?php
/**
 * Universal Taxonomy Archive Template
 * ==========================================================================
 * Targets: product_shape, product_material, product_grade
 * Route: /shape/..., /material/..., /grade/...
 * 
 * Logic:
 * 1. Automatically detects current taxonomy.
 * 2. Assembles the page using modular template parts.
 * 
 * Architecture:
 * - Header
 * - Hero Banner (template-parts/taxonomy/hero)
 * - Main Content (Sidebar + Grid)
 * - SEO Content (template-parts/taxonomy/seo-content)
 * - Global Contact (template-parts/global/consult-section)
 * - Footer
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

echo '<div class="lc-taxonomy-scope">';

/**
 * I. Hero Banner
 */
get_template_part( 'template-parts/taxonomy/hero' );
?>

<!-- II. Main Content Layout (Sidebar + Grid) -->
<div class="mx-auto max-w-[1440px] px-4 py-12 lg:py-20 lg:px-8">
    <div class="flex flex-col lg:flex-row lg:gap-12">
        
        <!-- Sidebar Navigation -->
        <?php get_template_part( 'template-parts/taxonomy/sidebar' ); ?>

        <!-- Product Grid -->
        <?php get_template_part( 'template-parts/taxonomy/grid' ); ?>

    </div>
</div>

<?php
/**
 * III. SEO Content / Technical Guide
 */
get_template_part( 'template-parts/taxonomy/seo-content' );

/**
 * IV. Global Contact Section
 */
get_template_part( 'template-parts/global/global-contact' );

echo '</div>';

get_footer();
