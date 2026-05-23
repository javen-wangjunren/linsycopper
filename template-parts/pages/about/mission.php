<?php
/**
 * Template Part: About - Mission & Values
 * 
 * Logic:
 * Displays a 3-column grid of company principles (Mission, Vision, Values).
 * Strictly follows Linsy Copper "Visual First" SOP and Three-Phase Architecture.
 * 
 * @package GeneratePress_Child
 */

// Phase 1: Init
$mission_list = get_flat_field( 'mission_list' );

// Phase 2: Preprocess
if ( empty( $mission_list ) ) {
    return;
}
?>

<!-- Phase 3: View -->
<section class="lc-mission-values bg-white pt-[100px] pb-24">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ( $mission_list as $item ) : 
                $icon_id = $item['item_icon'] ?? 0;
                $title   = $item['item_title'] ?? '';
                $desc    = $item['item_description'] ?? '';
                ?>
                <div class="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-lg">
                    
                    <!-- Icon: Industrial Blue background with Action Orange hover -->
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-sm bg-[#0B3570]/10 text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
                        <?php if ( $icon_id ) : ?>
                            <?php echo wp_get_attachment_image( $icon_id, 'thumbnail', true, [
                                'class' => 'h-6 w-6 object-contain filter group-hover:brightness-0 group-hover:invert'
                            ] ); ?>
                        <?php else : ?>
                            <!-- Fallback Circle for Industrial look -->
                            <span class="h-2 w-2 rounded-full bg-current"></span>
                        <?php endif; ?>
                    </div>

                    <!-- Content: Heading class + Sans Geist -->
                    <h3 class="text-heading mb-3 text-lg font-bold">
                        <?php echo esc_html( $title ); ?>
                    </h3>
                    
                    <p class="text-sm leading-relaxed text-[#6B7280]">
                        <?php echo esc_html( $desc ); ?>
                    </p>

                    <!-- Precision Bottom Accent Bar -->
                    <div class="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full"></div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
