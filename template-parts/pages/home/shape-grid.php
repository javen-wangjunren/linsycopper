<?php
/**
 * Template Part: Home Shape Grid Module
 * 
 * Logic: Init (Data) -> Preprocess (Taxonomy) -> View
 * 
 * @package GeneratePress_Child
 */

// 1. Init (Data Retrieval)
$title    = get_flat_field( 'home_shape_grid_title' ) ?: 'Find Copper Materials by Form';
$desc     = get_flat_field( 'home_shape_grid_desc' );
$items    = get_flat_field( 'home_shape_grid_items' ); // Returns array of WP_Term objects
$cta_text = get_flat_field( 'home_shape_grid_cta_text' ) ?: 'View All Shapes';
$cta_link = get_flat_field( 'home_shape_grid_cta_link' ) ?: '#';

// 2. Preprocess (Fallbacks)
if ( empty( $items ) ) {
    return;
}
?>

<section class="bg-[rgb(248,250,252)] pt-[100px] pb-16 md:pb-24">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="mb-4 flex items-end justify-between">
            <div>
                <?php if ( $title ) : ?>
                    <h2 class="lc-h2-section text-[#1F2937]">
                        <?php echo esc_html( $title ); ?>
                    </h2>
                <?php endif; ?>
            </div>
            
            <?php if ( $cta_link && $cta_text ) : ?>
                <a href="<?php echo esc_url( $cta_link ); ?>" 
                   class="lc-home-viewall-btn hidden items-center rounded-sm border-2 px-6 py-2 font-semibold transition-all md:flex">
                    <?php echo esc_html( $cta_text ); ?> →
                </a>
            <?php endif; ?>
        </div>

        <?php if ( $desc ) : ?>
            <p class="lc-body-section mb-12 max-w-2xl md:text-base">
                <?php echo esc_html( $desc ); ?>
            </p>
        <?php endif; ?>

        <!-- Shape Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php 
            foreach ( $items as $term ) : 
                if ( ! is_object( $term ) || empty( $term->term_id ) ) continue;
                
                // Get image from Term meta (following Visual-First SOP: 'hero_image' on taxonomy)
                $img_id = get_field( 'hero_image', $term );
                $link   = get_term_link( $term );
            ?>
                <a href="<?php echo esc_url( $link ); ?>" 
                   class="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg flex flex-col">
                    
                    <!-- Image Section - Top Half -->
                    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'medium_large', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
                        <?php else : ?>
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.5-1.5a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Content - Bottom Half -->
                    <div class="flex flex-col flex-grow p-6 text-center">
                        <h3 class="lc-h3-section mb-6 text-[#1F2937]">
                            <?php echo esc_html( $term->name ); ?>
                        </h3>

                        <div class="lc-card-cta">
                            View Details
                        </div>
                    </div>

                    <!-- Accent Bar -->
                    <div class="h-1 w-full bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] opacity-0 transition-opacity group-hover:opacity-100"></div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Mobile CTA -->
        <?php if ( $cta_link && $cta_text ) : ?>
            <div class="mt-8 flex justify-center md:hidden">
                <a href="<?php echo esc_url( $cta_link ); ?>" 
                   class="lc-home-viewall-btn rounded-sm border-2 px-8 py-3 font-semibold transition-all">
                    <?php echo esc_html( $cta_text ); ?> →
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
