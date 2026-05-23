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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
        <?php
        while ( have_posts() ) :
            the_post();
            
            // 1. Prepare Data
            $post_id    = get_the_ID();
            $categories = get_the_category();
            $cat_name   = ! empty( $categories ) ? $categories[0]->name : 'Insights';
            $img_id     = get_post_thumbnail_id( $post_id );
            $excerpt    = get_the_excerpt();
            $read_time  = lc_get_reading_time( $post_id );
            
            // Industrial Branding Logic: Fetch Author info
            $author_id  = get_the_author_meta( 'ID' );
            $job_title  = get_flat_field( 'user_author_job', null, 'user_' . $author_id ) ?: 'Linsy Specialist';
            ?>
            
            <!-- Article Card: Industrial Precision -->
            <article class="group flex flex-col bg-white rounded-sm border border-[#E5E7EB] overflow-hidden transition-all duration-500 hover:border-[#F97C30] hover:shadow-2xl hover:-translate-y-1.5">
                <a href="<?php the_permalink(); ?>" class="flex flex-col h-full">
                    
                    <!-- Featured Image: 16:10 Ratio, Machined Edge -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-[#F8F9FA] border-b border-[#E5E7EB]">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'large', false, array(
                                'class' => 'h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110'
                            ) ); ?>
                        <?php else : ?>
                            <div class="h-full w-full flex items-center justify-center opacity-10">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                            </div>
                        <?php endif; ?>

                        <!-- Glass Reflection Effect -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-white/10 via-transparent to-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                        
                        <!-- Category Badge Overlay: font-mono uppercase -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#0B3570] text-white px-3 py-1 rounded-sm text-[10px] font-mono font-bold uppercase tracking-widest border border-white/20 shadow-lg">
                                <?php echo esc_html( $cat_name ); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Content Body: Balanced Padding -->
                    <div class="p-6 md:p-8 flex flex-col flex-1 relative">
                        <!-- Technical accent line -->
                        <div class="absolute top-0 left-8 w-px h-4 bg-[#F97C30] opacity-0 group-hover:opacity-100 transition-all duration-500 -translate-y-full group-hover:translate-y-0"></div>

                        <!-- Meta Row: Technical font-mono -->
                        <div class="flex items-center gap-4 mb-4 font-mono text-[10px] uppercase tracking-wider text-[#9CA3AF] border-b border-[#F2F4F7] pb-4">
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                            <span class="w-1.5 h-px bg-[#E5E7EB]"></span>
                            <span class="text-[#F97C30] font-bold"><?php echo esc_html( $read_time ); ?></span>
                        </div>

                        <!-- Title: text-heading class for primary weight -->
                        <h3 class="text-heading text-xl font-bold text-[#1F2937] leading-tight mb-4 transition-colors group-hover:text-[#0B3570]">
                            <?php the_title(); ?>
                        </h3>

                        <!-- Excerpt: Line-clamp for neatness -->
                        <div class="text-sm text-[#6B7280] leading-relaxed mb-8 line-clamp-3">
                            <?php echo esc_html( $excerpt ); ?>
                        </div>
                        
                        <!-- Footer: Author & Interaction -->
                        <div class="mt-auto flex items-center justify-between pt-6 border-t border-[#F2F4F7]">
                            <div class="flex items-center gap-3">
                                <!-- Minimalist Author Icon -->
                                <div class="w-9 h-9 rounded-sm bg-[#F8F9FA] flex items-center justify-center text-[#0B3570] font-bold text-[10px] border border-[#E5E7EB] transition-colors group-hover:border-[#F97C30] group-hover:bg-white">
                                    LC
                                </div>
                                <div>
                                    <span class="block text-[11px] font-bold text-[#1F2937] leading-none mb-1"><?php the_author(); ?></span>
                                    <span class="block text-[9px] font-mono text-[#9CA3AF] uppercase tracking-wider"><?php echo esc_html( $job_title ); ?></span>
                                </div>
                            </div>
                            
                            <!-- Action Arrow -->
                            <div class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#F97C30] transition-all duration-500 group-hover:bg-[#F97C30] group-hover:text-white group-hover:border-[#F97C30] group-hover:rotate-45">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
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
