<?php
/**
 * Template Part: About - Company Timeline
 * 
 * Logic:
 * Displays a vertical alternating timeline of company milestones.
 * Strictly follows Linsy Copper "Visual First" SOP and Three-Phase Architecture.
 * 
 * @package GeneratePress_Child
 */

// Phase 1: Init
$title     = get_flat_field( 'timeline_title' ) ?: '25+ Years of Excellence';
$desc      = get_flat_field( 'timeline_desc' ) ?: 'From a small trading company to a global copper solutions provider.';
$milestones = get_flat_field( 'timeline_list' );

// Phase 2: Preprocess
if ( empty( $milestones ) ) {
    return;
}
?>

<!-- Phase 3: View -->
<section class="lc-timeline bg-[#F8F9FA] pt-[100px] pb-24">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

        <!-- Section Header: Centered for Timeline focus -->
        <div class="lc-section-header mb-20 text-center">
            <h2 class="lc-h2-display mx-auto max-w-3xl text-balance text-heading">
                <?php echo esc_html( $title ); ?>
            </h2>
            
            <?php if ( $desc ) : ?>
                <p class="lc-body-section mx-auto mt-6 max-w-2xl text-pretty">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Timeline Container -->
        <div class="relative">
            <!-- Central Vertical Line (Industrial Gray) -->
            <div class="absolute left-4 top-0 h-full w-px bg-[#E5E7EB] md:left-1/2 md:-translate-x-1/2" aria-hidden="true"></div>

            <div class="space-y-16 md:space-y-24">
                <?php foreach ( $milestones as $index => $item ) : 
                    $is_even       = ( $index % 2 === 0 );
                    $year          = $item['year'] ?? '';
                    $m_title       = $item['title'] ?? '';
                    $m_desc        = $item['description'] ?? '';
                    $img_id        = $item['image'] ?? 0;
                    $mobile_img_id = $item['mobile_image'] ?? 0;
                    ?>
                    <div class="relative flex flex-col md:flex-row <?php echo $is_even ? '' : 'md:flex-row-reverse'; ?> items-center">
                        
                        <!-- Content Side (Text) -->
                        <div class="w-full md:w-1/2 <?php echo $is_even ? 'md:pr-16 md:text-left pl-12 md:pl-0' : 'md:pl-16 md:text-left pl-12 md:pr-0'; ?>">
                            <div class="max-w-xl">
                                <h3 class="lc-h3-display text-heading mb-4">
                                    <span class="lc-mono-meta mr-2 text-[#0B3570]"><?php echo esc_html( $year ); ?></span>
                                    <?php echo esc_html( $m_title ); ?>
                                </h3>
                                
                                <p class="lc-body-card text-base">
                                    <?php echo esc_html( $m_desc ); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Center Dot: Action Orange -->
                        <div class="absolute left-4 top-8 h-4 w-4 -translate-x-1/2 rounded-full border-4 border-white bg-[#F97C30] shadow-sm md:left-1/2 md:top-1/2 md:-translate-y-1/2" aria-hidden="true"></div>

                        <!-- Image Side -->
                        <div class="w-full md:w-1/2 mt-8 md:mt-0 <?php echo $is_even ? 'md:pl-16 pl-12 md:pr-0' : 'md:pr-16 pl-12 md:pl-0'; ?>">
                            <?php if ( $img_id || $mobile_img_id ) : ?>
                                <div class="relative aspect-[4/3] w-full overflow-hidden rounded-sm bg-gray-100 shadow-md transition-all duration-500 hover:shadow-xl">
                                    <picture class="h-full w-full">
                                        <?php if ( $mobile_img_id ) : ?>
                                            <source media="(max-width: 767px)" srcset="<?php echo esc_url( wp_get_attachment_image_url( $mobile_img_id, 'large' ) ); ?>">
                                        <?php endif; ?>
                                        <?php echo wp_get_attachment_image( $img_id ?: $mobile_img_id, 'large', false, [
                                            'class' => 'h-full w-full object-cover transition-transform duration-700 hover:scale-105'
                                        ] ); ?>
                                    </picture>
                                </div>
                            <?php else : ?>
                                <!-- Empty space if no image is provided -->
                                <div class="hidden md:block h-20"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>
