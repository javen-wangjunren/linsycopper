<?php
/**
 * Single Blog Sidebar
 * Path: template-parts/single-blog/sidebar.php
 * 
 * Logic:
 * - Dynamic TOC generation (H2 anchors).
 * - Author Card inclusion.
 */

$cta_title       = function_exists( 'get_field' ) ? get_field( 'blog_single_cta_title', 'option' ) : '';
$cta_desc        = function_exists( 'get_field' ) ? get_field( 'blog_single_cta_desc', 'option' ) : '';
$cta_button_text = function_exists( 'get_field' ) ? get_field( 'blog_single_cta_button_text', 'option' ) : '';
$cta_button_link = function_exists( 'get_field' ) ? get_field( 'blog_single_cta_button_link', 'option' ) : '';

$cta_title       = $cta_title ? $cta_title : 'Ready for a Technical Quote?';
$cta_desc        = $cta_desc ? $cta_desc : 'Connect with our material specialists for specific alloy data or high-volume pricing.';
$cta_button_text = $cta_button_text ? $cta_button_text : 'Get Expert Consultation';
$cta_button_link = $cta_button_link ? $cta_button_link : home_url( '/contact/' );
?>

<div class="lc-blog-sidebar-scope space-y-12">

    <!-- 1. Table of Contents (Desktop) -->
    <div class="hidden lg:block">
        <?php get_template_part( 'template-parts/single-blog/toc' ); ?>
    </div>

    <!-- 2. Sidebar CTA (Industrial Material Quote) -->
    <div class="bg-[#0B3570] rounded-sm p-8 text-white relative overflow-hidden group">
        <!-- Abstract Industrial Background Pattern -->
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none" 
             style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
        
        <div class="relative z-10">
            <h4 class="text-white text-2xl font-bold leading-tight mb-4">
                <?php echo esc_html( $cta_title ); ?>
            </h4>
            <div class="text-blue-100 text-sm mb-6 leading-relaxed">
                <?php echo wp_kses_post( $cta_desc ); ?>
            </div>
            <a href="<?php echo esc_url( $cta_button_link ); ?>" class="lc-btn-reset lc-blog-sidebar-cta inline-flex items-center justify-center gap-2 w-full py-3 px-5 rounded-sm bg-[#F97C30] text-white font-bold text-sm transition-all duration-300 hover:bg-white hover:text-[#0B3570] shadow-lg hover:shadow-xl">
                <?php echo esc_html( $cta_button_text ); ?>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </div>

</div>
