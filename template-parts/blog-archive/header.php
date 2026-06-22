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
$title         = get_field( 'archive_title', $posts_page_id ) ?: 'Material Science & Industry Updates';
$desc          = get_field( 'archive_description', $posts_page_id );

// 2. Prepare Category Tabs
$categories       = get_categories(
    array(
        'hide_empty' => true,
        'orderby'    => 'count',
        'order'      => 'DESC',
    )
);
$current_cat_slug = get_query_var( 'category_name' );

if ( empty( $current_cat_slug ) && isset( $_GET['category'] ) ) {
    $current_cat_slug = sanitize_title( wp_unslash( $_GET['category'] ) );
}
?>

<header class="bg-white pt-14 pb-10 md:pt-16 md:pb-12">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        <div class="lc-blog-archive-header mx-auto max-w-4xl text-center">
            <h1 class="text-heading text-3xl md:text-4xl lg:text-[44px] font-bold leading-tight tracking-tight text-[#1F2937]">
                <?php echo esc_html( $title ); ?>
            </h1>
            <?php if ( $desc ) : ?>
                <div class="lc-blog-archive-header-desc mt-5">
                    <p class="max-w-2xl text-base md:text-lg text-[#6B7280] leading-relaxed text-center">
                        <?php echo nl2br( esc_html( $desc ) ); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-10 flex justify-center">
            <nav class="lc-taxonomy-scope inline-flex flex-wrap justify-center gap-2 bg-[#F8F9FA] p-1.5 rounded-xl border border-[#E5E7EB] shadow-sm" aria-label="Blog category filters">
                <a href="<?php echo esc_url( get_permalink( $posts_page_id ) ); ?>" class="lc-link-reset px-4 py-2 rounded-lg text-[13px] md:text-sm font-semibold tracking-normal whitespace-nowrap transition-all duration-200 <?php echo empty( $current_cat_slug ) ? 'bg-white text-[#0B3570] shadow-sm ring-1 ring-[#E5E7EB]' : 'text-[#6B7280] hover:text-[#1F2937] hover:bg-white/70'; ?>">
                    All
                </a>

                <?php foreach ( $categories as $cat ) : ?>
                    <?php $is_active = $current_cat_slug === $cat->slug; ?>
                    <a href="<?php echo esc_url( add_query_arg( 'category', $cat->slug, get_permalink( $posts_page_id ) ) ); ?>" class="lc-link-reset px-4 py-2 rounded-lg text-[13px] md:text-sm font-semibold tracking-normal whitespace-nowrap transition-all duration-200 <?php echo $is_active ? 'bg-white text-[#0B3570] shadow-sm ring-1 ring-[#E5E7EB]' : 'text-[#6B7280] hover:text-[#1F2937] hover:bg-white/70'; ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>
</header>
