<?php
/**
 * Blog Archive: Post Grid
 * Path: template-parts/blog-archive/grid.php
 * 
 * Logic:
 * - Iterates through the main WordPress loop.
 * - Renders post cards in a 3-column responsive grid.
 * - Adheres to industrial branding: 2px micro-radius (rounded-sm), font-mono for meta.
 */

if ( have_posts() ) : ?>
    <div class="lc-blog-archive-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
        <?php
        while ( have_posts() ) :
            the_post();
            
            // 1. Prepare Data
            $post_id    = get_the_ID();
            $img_id     = get_post_thumbnail_id( $post_id );
            ?>
            
            <article class="group flex flex-col bg-white rounded-sm border border-[#E5E7EB] overflow-hidden transition-all duration-300 hover:border-[#F97C30] hover:shadow-xl hover:-translate-y-1">
                <a href="<?php the_permalink(); ?>" class="lc-link-reset flex flex-col h-full">
                    <div class="relative aspect-[16/10] overflow-hidden bg-[#F8F9FA] border-b border-[#E5E7EB]">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'large', false, array(
                                'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-105'
                            ) ); ?>
                        <?php else : ?>
                            <div class="h-full w-full flex items-center justify-center opacity-10">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-5 md:p-6 flex flex-col flex-1">
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="mb-3 text-sm font-medium text-[#6B7280]">
                            <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
                        </time>
                        <h3 class="text-heading text-xl font-bold text-[#1F2937] leading-tight tracking-tight transition-colors group-hover:text-[#0B3570]">
                            <?php the_title(); ?>
                        </h3>
                    </div>
                </a>
            </article>

        <?php endwhile; ?>
    </div>

<?php else : ?>
    <!-- Empty State: Maintain Grid Rhythm -->
    <div class="text-center py-24 bg-[#F8F9FA] rounded-sm border border-dashed border-[#E5E7EB]">
        <h3 class="text-heading text-2xl font-bold text-[#1F2937]">Technical Updates Pending</h3>
        <p class="text-[#6B7280] mt-3">Our engineers are currently documenting new material data. Check back soon.</p>
    </div>
<?php endif; ?>
