<?php
/**
 * Single Blog Sidebar
 * Path: template-parts/single-blog/sidebar.php
 * 
 * Logic:
 * - Dynamic TOC generation (H2 anchors).
 * - Author Card inclusion.
 */

// Get TOC from post content
$content = get_the_content();
$toc     = lc_get_post_toc( $content );
?>

<div class="space-y-12">

    <!-- 1. Table of Contents (TOC) -->
    <?php if ( ! empty( $toc ) ) : ?>
        <nav class="toc-container p-6 md:p-8 bg-[#F8F9FA] rounded-sm border border-[#E5E7EB] shadow-sm sticky top-24" x-data="{ activeId: '' }">
            <h5 class="text-xs font-mono font-bold uppercase tracking-widest text-[#9CA3AF] mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#F97C30]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                Document Structure
            </h5>
            <ul class="space-y-4 border-l border-[#E5E7EB]">
                <?php foreach ( $toc as $item ) : ?>
                    <li class="pl-4 -ml-[1px] border-l border-transparent hover:border-[#F97C30] transition-all">
                        <a href="#<?php echo esc_attr( $item['id'] ); ?>" 
                           class="text-sm font-medium text-[#4B5563] hover:text-[#0B3570] transition-colors duration-300 leading-tight block">
                            <?php echo esc_html( $item['title'] ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <!-- 2. Author Profile Card -->
    <?php get_template_part( 'template-parts/single-blog/author-card' ); ?>

    <!-- 3. Sidebar CTA (Industrial Material Quote) -->
    <div class="bg-[#0B3570] rounded-sm p-8 text-white relative overflow-hidden group">
        <!-- Abstract Industrial Background Pattern -->
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none" 
             style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
        
        <div class="relative z-10">
            <h4 class="text-heading text-2xl font-bold leading-tight mb-4">
                Ready for a Technical Quote?
            </h4>
            <p class="text-blue-100 text-sm mb-8 leading-relaxed">
                Connect with our material specialists for specific alloy data or high-volume pricing.
            </p>
            <a href="/contact/" class="inline-flex items-center justify-center gap-2 w-full py-4 px-6 rounded-sm bg-[#F97C30] text-white font-bold text-base transition-all duration-300 hover:bg-white hover:text-[#0B3570] shadow-lg hover:shadow-xl">
                Get Expert Consultation
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </div>

</div>
