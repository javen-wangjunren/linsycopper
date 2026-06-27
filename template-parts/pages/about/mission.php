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

if ( ! function_exists( 'linsy_render_about_principle_icon' ) ) {
    /**
     * Render static icons for Mission / Vision / Values.
     *
     * @param string $icon_key Icon key.
     * @return void
     */
    function linsy_render_about_principle_icon( $icon_key ) {
        switch ( $icon_key ) {
            case 'mission':
                ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" aria-hidden="true">
                    <circle cx="12" cy="12" r="7"></circle>
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 2v3"></path>
                    <path d="M12 19v3"></path>
                    <path d="M2 12h3"></path>
                    <path d="M19 12h3"></path>
                </svg>
                <?php
                break;

            case 'vision':
                ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" aria-hidden="true">
                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path>
                    <circle cx="12" cy="12" r="2.5"></circle>
                </svg>
                <?php
                break;

            case 'values':
            default:
                ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" aria-hidden="true">
                    <path d="M12 3l7 3v5c0 5-3.5 8-7 10-3.5-2-7-5-7-10V6l7-3z"></path>
                    <path d="M9.5 12.5l1.8 1.8 3.7-4"></path>
                </svg>
                <?php
                break;
        }
    }
}
?>

<!-- Phase 3: View -->
<section class="lc-mission-values bg-white pt-[100px] pb-24">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ( $mission_list as $index => $item ) :
                $title   = $item['item_title'] ?? '';
                $desc    = $item['item_description'] ?? '';
                $title_lc = function_exists( 'mb_strtolower' ) ? mb_strtolower( $title, 'UTF-8' ) : strtolower( $title );
                $icon_key = 'values';

                if ( strpos( $title_lc, 'mission' ) !== false ) {
                    $icon_key = 'mission';
                } elseif ( strpos( $title_lc, 'vision' ) !== false ) {
                    $icon_key = 'vision';
                } elseif ( strpos( $title_lc, 'value' ) !== false ) {
                    $icon_key = 'values';
                } elseif ( $index === 0 ) {
                    $icon_key = 'mission';
                } elseif ( $index === 1 ) {
                    $icon_key = 'vision';
                }
                ?>
                <div class="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-lg">
                    
                    <!-- Icon: Industrial Blue background with Action Orange hover -->
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-sm bg-[#0B3570]/10 text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
                        <?php linsy_render_about_principle_icon( $icon_key ); ?>
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
