<?php
/**
 * Home Module: Blog List (Technical Resources)
 * Path: template-parts/pages/home/blog-list.php
 * 
 * Industrial Material Realism:
 * - 3-column grid for desktop.
 * - Horizontal swipe for mobile (using CSS snap).
 * - High-contrast typography (Geist/Geist Mono).
 * - Precision geometry (rounded-sm).
 */

// 1. Init (Data Acquisition)
$args = isset( $args ) && is_array( $args ) ? $args : [];
$title    = get_flat_field( 'blog_list_title', $args, 'Technical Resources & Insights' );
$post_ids = get_flat_field( 'blog_list_posts', $args, [] );

// 2. Preprocess (Data Processing/Fallback)
if ( empty( $post_ids ) ) {
    // Fallback: Get 3 latest posts if none selected
    $latest_posts = get_posts( [
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'fields'         => 'ids',
    ] );
    $post_ids = $latest_posts;
}

if ( empty( $post_ids ) ) {
    return; // No posts found at all
}
?>

<section class="lc-blog-list bg-[#F2F4F7] pt-[100px] pb-24 overflow-hidden">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-16 text-center">
            <h2 class="text-heading text-balance text-3xl font-bold text-[#1F2937] md:text-4xl lg:text-5xl">
                <?php echo esc_html( $title ); ?>
            </h2>
        </div>

        <!-- Blog Grid / Mobile Slider -->
        <div class="flex md:grid gap-6 md:gap-8 md:grid-cols-2 lg:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar pb-8 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0">
            <?php foreach ( $post_ids as $post_id ) : 
                $post_obj     = get_post( $post_id );
                $permalink    = get_permalink( $post_id );
                $post_title   = get_the_title( $post_id );
                $excerpt      = get_the_excerpt( $post_id );
                $date         = get_the_date( 'M j, Y', $post_id );
                $thumbnail_id = get_post_thumbnail_id( $post_id );
                $categories   = get_the_category( $post_id );
                $primary_cat  = ! empty( $categories ) ? $categories[0]->name : 'Uncategorized';
                
                // Author Data (Industrial Precision: using user meta from ACF)
                $author_id      = $post_obj->post_author;
                $author_name    = get_the_author_meta( 'display_name', $author_id );
                $author_job     = get_field( 'user_author_job', 'user_' . $author_id ) ?: 'Specialist';
                $author_img_id  = get_field( 'user_author_image', 'user_' . $author_id );
                $author_img_url = $author_img_id ? wp_get_attachment_image_url( $author_img_id, 'thumbnail' ) : get_avatar_url( $author_id );
            ?>
                <article class="group flex flex-col min-w-[85%] md:min-w-0 snap-center overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#0B3570] hover:shadow-xl">
                    
                    <!-- Featured Image (Machined Edge) -->
                    <a href="<?php echo esc_url( $permalink ); ?>" class="relative block h-56 w-full overflow-hidden bg-gray-200">
                        <?php if ( $thumbnail_id ) : ?>
                            <?php echo wp_get_attachment_image( $thumbnail_id, 'medium_large', false, [
                                'class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105'
                            ] ); ?>
                        <?php else : ?>
                            <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        <?php endif; ?>
                        <!-- Reflection Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    </a>

                    <!-- Content Body -->
                    <div class="flex flex-1 flex-col justify-between p-6">
                        <div>
                            <!-- Meta Info (font-mono) -->
                            <div class="mb-4 flex items-center gap-3 font-mono text-[13px] text-[#6B7280]">
                                <time class="font-medium">
                                    <?php echo esc_html( $date ); ?>
                                </time>
                                <span class="text-[#D1D5DB]">•</span>
                                <span class="font-medium">
                                    <?php echo esc_html( lc_get_reading_time( $post_id ) ); ?>
                                </span>
                                <span class="rounded-full bg-[#0B3570] px-3 py-0.5 text-[13px] uppercase font-bold text-white">
                                    <?php echo esc_html( $primary_cat ); ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="mb-3 text-xl font-bold leading-snug text-[#1F2937] transition-colors group-hover:text-[#0B3570]">
                                <a href="<?php echo esc_url( $permalink ); ?>" class="text-heading">
                                    <?php echo esc_html( $post_title ); ?>
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="line-clamp-3 text-sm text-[#6B7280] leading-relaxed">
                                <?php echo esc_html( wp_trim_words( $excerpt, 25 ) ); ?>
                            </p>
                        </div>

                        <!-- Author Info (Bottom) -->
                        <div class="mt-8 border-t border-[#E5E7EB] pt-5">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 overflow-hidden rounded-full border border-[#E5E7EB] bg-slate-50">
                                    <img
                                        src="<?php echo esc_url( $author_img_url ); ?>"
                                        alt="<?php echo esc_attr( $author_name ); ?>"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#1F2937] leading-none mb-1"><?php echo esc_html( $author_name ); ?></p>
                                    <p class="font-mono text-[10px] uppercase tracking-wider text-[#F97C30]"><?php echo esc_html( $author_job ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- View All CTA -->
        <div class="mt-16 text-center">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" 
               class="lc-blog-list__cta">
                VIEW ALL ARTICLES →
            </a>
        </div>
    </div>
</section>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.lc-blog-list .lc-blog-list__cta{
    display:inline-block;
    border-radius:0.5rem;
    border:2px solid #0B3570;
    padding:0.75rem 2rem;
    font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
    font-size:0.875rem;
    font-weight:600;
    color:#0B3570;
    transition:background-color .2s,color .2s,box-shadow .2s;
}
.lc-blog-list .lc-blog-list__cta:hover{
    background-color:#0B3570;
    color:#fff;
    box-shadow:0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -4px rgba(0,0,0,.1);
}
.lc-blog-list .lc-blog-list__cta:focus-visible{
    outline:2px solid #0B3570;
    outline-offset:2px;
}
</style>
