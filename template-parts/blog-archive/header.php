<?php
/**
 * Blog Archive: Header Section (Hero)
 * Path: template-parts/blog-archive/header.php
 * 
 * Logic:
 * - Fetches ACF content from the designated 'Posts Page'.
 * - Renders a banner with title, description, and category tabs.
 * - Adheres to industrial branding with dot patterns and monospaced accents.
 */

// 1. Data Fetching (Using get_queried_object_id() for the posts page)
$posts_page_id = get_queried_object_id();
$subtitle = get_field( 'archive_subtitle', $posts_page_id ) ?: 'Insights & News';
$title    = get_field( 'archive_title', $posts_page_id ) ?: 'Material Science & Industry Updates';
$desc     = get_field( 'archive_description', $posts_page_id );
$bg_id    = get_field( 'archive_bg_image', $posts_page_id );

// 2. Prepare Category Tabs
$categories = get_categories( array( 'hide_empty' => true ) );
$current_cat_id = is_category() ? get_queried_object_id() : 0;
?>

<header class="relative bg-[#F8F9FA] pt-16 pb-12 md:pt-24 md:pb-16 border-b border-[#E5E7EB] overflow-hidden">
    <!-- Copper UI: Industrial Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
         style="background-image: radial-gradient(#0B3570 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        
        <!-- Subtitle & Breadcrumb -->
        <div class="mb-6 flex items-center gap-2 font-mono text-xs font-semibold uppercase tracking-wider text-[#F97C30]">
            <span>Blog</span>
            <span class="text-[#9CA3AF]">/</span>
            <span class="text-[#4B5563]"><?php echo esc_html( $subtitle ); ?></span>
        </div>

        <!-- Title & Description -->
        <div class="max-w-4xl mb-12">
            <h1 class="text-heading text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-[#1F2937] mb-6">
                <?php echo esc_html( $title ); ?>
            </h1>
            <?php if ( $desc ) : ?>
                <p class="text-lg md:text-xl text-[#6B7280] leading-relaxed max-w-3xl">
                    <?php echo nl2br( esc_html( $desc ) ); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Category Tabs (Filter) -->
        <nav class="flex flex-wrap items-center gap-2 md:gap-4 mt-8 md:mt-12">
            <!-- "All" Tab -->
            <a href="<?php echo esc_url( get_permalink( $posts_page_id ) ); ?>" 
               class="relative px-5 py-2.5 rounded-sm font-mono text-xs font-bold uppercase tracking-widest transition-all duration-300 border <?php echo ! $current_cat_id ? 'bg-[#0B3570] text-white border-[#0B3570] shadow-md' : 'bg-white text-[#6B7280] border-[#E5E7EB] hover:border-[#F97C30] hover:text-[#0B3570] shadow-sm'; ?>">
                <?php if ( ! $current_cat_id ) : ?>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-[#F97C30] rounded-full ring-2 ring-white"></span>
                <?php endif; ?>
                All Articles
            </a>

            <?php foreach ( $categories as $cat ) : ?>
                <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" 
                   class="relative px-5 py-2.5 rounded-sm font-mono text-xs font-bold uppercase tracking-widest transition-all duration-300 border <?php echo $current_cat_id === $cat->term_id ? 'bg-[#0B3570] text-white border-[#0B3570] shadow-md' : 'bg-white text-[#6B7280] border-[#E5E7EB] hover:border-[#F97C30] hover:text-[#0B3570] shadow-sm'; ?>">
                    <?php if ( $current_cat_id === $cat->term_id ) : ?>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-[#F97C30] rounded-full ring-2 ring-white"></span>
                    <?php endif; ?>
                    <?php echo esc_html( $cat->name ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

    </div>
</header>
