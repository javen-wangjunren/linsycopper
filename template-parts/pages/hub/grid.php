<?php
/**
 * Taxonomy Hub: Term Grid
 * ==========================================================================
 * Location: template-parts/hub/grid.php
 * 
 * Logic:
 * 1. Fetches 'hub_target_taxonomy' from Page ACF.
 * 2. Queries all terms for that taxonomy.
 * 3. Renders a grid of cards (Image + Title + Desc + CTA).
 * 
 * @package GeneratePress_Child
 */

// 1. Get Target Taxonomy
$target_tax = get_field( 'hub_target_taxonomy' );

if ( empty( $target_tax ) ) {
    if ( current_user_can( 'manage_options' ) ) {
        echo '<p class="text-red-500">Please select a Target Taxonomy in Page Settings.</p>';
    }
    return;
}

// 2. Fetch Terms
$terms = get_terms( array(
    'taxonomy'   => $target_tax,
    'hide_empty' => false, // Show all terms even if no products assigned yet
) );

if ( empty( $terms ) || is_wp_error( $terms ) ) {
    echo '<p class="text-gray-500 text-center py-12">No items found.</p>';
    return;
}
?>

<section class="bg-[#F2F4F7] py-16 md:py-24 font-sans">
    <div class="mx-auto max-w-[1440px] px-4 lg:px-8">
        
        <!-- Grid Layout -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ( $terms as $term ) : 
                // Get Term Meta (Image from 'category-hero.php')
                $image_id = get_field( 'hero_image', $term );
                $link     = get_term_link( $term );
            ?>
            
            <div class="group flex flex-col overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-xl">
                
                <!-- Image Section (Aspect 4:3) -->
                <a href="<?php echo esc_url( $link ); ?>" class="relative block aspect-[4/3] overflow-hidden border-b border-[#E5E7EB] bg-[#F2F4F7]">
                    <?php 
                    if ( $image_id ) {
                        echo wp_get_attachment_image( $image_id, 'medium_large', false, array( 
                            'class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105' 
                        ) );
                    } else {
                        // Placeholder
                        echo '<img src="https://via.placeholder.com/600x450?text=Linsy+Copper" class="h-full w-full object-cover opacity-50 grayscale" alt="Placeholder">';
                    }
                    ?>
                    
                    <!-- Ready to Ship Badge (Mock Logic: If description exists, assume stock) -->
                    <?php if ( ! empty( $term->description ) ) : ?>
                    <div class="absolute right-0 top-0 bg-[#0B3570] px-3 py-1.5 font-mono text-[9px] font-bold uppercase tracking-widest text-white">
                        Ready to Ship
                    </div>
                    <?php endif; ?>
                </a>

                <!-- Content Section -->
                <div class="flex flex-1 flex-col p-8 text-left">
                    <h3 class="mb-4 text-xl font-bold uppercase tracking-tight text-[#0B3570] text-heading">
                        <a href="<?php echo esc_url( $link ); ?>">
                            <?php echo esc_html( $term->name ); ?>
                        </a>
                    </h3>
                    
                    <?php if ( ! empty( $term->description ) ) : ?>
                    <p class="mb-6 text-sm leading-relaxed text-[#6B7280] line-clamp-3">
                        <?php echo wp_trim_words( $term->description, 20 ); ?>
                    </p>
                    <?php else : ?>
                    <p class="mb-6 text-sm italic text-gray-400">No description available.</p>
                    <?php endif; ?>

                    <!-- CTA Button -->
                    <div class="mt-auto">
                        <a href="<?php echo esc_url( $link ); ?>" class="lc-card-btn w-full px-6 py-3 text-[10px] font-bold uppercase tracking-widest transition rounded-sm">
                            View Specifications
                        </a>
                    </div>
                </div>

            </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>
