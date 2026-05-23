<?php
/**
 * Single Blog Header
 * Path: template-parts/single-blog/header.php
 */

$categories = get_the_category();
$primary_cat = ! empty( $categories ) ? $categories[0]->name : 'Uncategorized';
?>

<header class="relative bg-[#F8F9FA] pt-16 pb-12 md:pt-24 md:pb-16 border-b border-[#E5E7EB] overflow-hidden">
    <!-- Copper UI: Industrial Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
         style="background-image: radial-gradient(#0B3570 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        
        <!-- Category & Breadcrumb -->
        <div class="mb-6 flex items-center gap-2 font-mono text-xs font-semibold uppercase tracking-wider text-[#F97C30]">
            <a href="/blog/" class="hover:underline transition-all">Blog</a>
            <span class="text-[#9CA3AF]">/</span>
            <span class="text-[#4B5563]"><?php echo esc_html( $primary_cat ); ?></span>
        </div>

        <!-- Title & Meta -->
        <div class="max-w-4xl">
            <h1 class="text-heading text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-[#1F2937] mb-8">
                <?php the_title(); ?>
            </h1>
            
            <div class="flex flex-wrap items-center gap-6 text-sm text-[#6B7280]">
                <!-- Date -->
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#F97C30]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                </div>
                <!-- Author -->
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#F97C30]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span class="font-medium text-[#1F2937]">By <?php the_author(); ?></span>
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="mt-12 md:mt-16 aspect-[21/9] w-full overflow-hidden rounded-sm shadow-xl border border-[#E5E7EB] bg-white p-2">
                <div class="h-full w-full overflow-hidden rounded-sm">
                    <?php the_post_thumbnail( 'full', array( 'class' => 'h-full w-full object-cover transition-transform duration-700 hover:scale-105' ) ); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</header>
