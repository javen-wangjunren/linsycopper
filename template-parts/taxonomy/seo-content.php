<?php
/**
 * Taxonomy Archive: SEO Content / Technical Guide
 * ==========================================================================
 * Location: template-parts/taxonomy/seo-content.php
 * 
 * Logic:
 * 1. Fetches ACF fields from the current term.
 * 2. Renders only if 'tech_guide_title' is populated.
 * 3. Displays Intro, Key Properties (Repeater), Applications (Repeater).
 * 
 * @package GeneratePress_Child
 */

// Get current term context
$term = get_queried_object();

$tech_guide_title       = get_field( 'tech_guide_title', $term );
$tech_guide_desc        = get_field( 'tech_guide_desc', $term );
$tech_guide_image       = get_field( 'tech_guide_image', $term );
$tech_guide_badge_title = get_field( 'tech_guide_badge_title', $term );
$tech_guide_benefits    = get_field( 'tech_guide_benefits', $term );
$tech_guide_apps        = get_field( 'tech_guide_apps', $term );

if ( ! empty( $tech_guide_title ) ) :
?>
<!-- Copper UI: Technical Guide Section -->
<section class="bg-white border-t border-gray-200 py-20 font-sans technical-guide">
    <div class="max-w-[1280px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Text Column -->
        <div>
            <!-- Heading -->
            <h2 class="mb-6 text-3xl font-bold text-heading text-[#0B3570]">
                <?php 
                // Split title for color accent if colon exists
                if ( strpos( $tech_guide_title, ':' ) !== false ) {
                    $parts = explode( ':', $tech_guide_title, 2 );
                    echo esc_html( $parts[0] ) . ': <span class="text-[#F97C30]">' . esc_html( $parts[1] ) . '</span>';
                } else {
                    echo esc_html( $tech_guide_title );
                }
                ?>
            </h2>

            <!-- Intro -->
            <?php if ( $tech_guide_desc ) : ?>
            <p class="mb-8 text-lg text-gray-600 leading-relaxed">
                <?php echo wp_kses_post( $tech_guide_desc ); ?>
            </p>
            <?php endif; ?>

            <!-- Key Properties Repeater -->
            <?php if ( ! empty( $tech_guide_benefits ) ) : ?>
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-[#0B3570]">Key Properties and Benefits</h3>
            <ul class="space-y-4 text-gray-600 mb-8 font-sans">
                <?php foreach ( $tech_guide_benefits as $benefit ) : ?>
                <li class="flex items-start">
                    <span class="text-[#F97C30] mr-2">▶</span> 
                    <span>
                        <?php if ( ! empty( $benefit['benefit_title'] ) ) : ?>
                        <strong class="text-[#0B3570]"><?php echo esc_html( $benefit['benefit_title'] ); ?>:</strong>
                        <?php endif; ?>
                        <?php echo esc_html( $benefit['benefit_desc'] ); ?>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            
            <!-- Applications Repeater -->
            <?php if ( ! empty( $tech_guide_apps ) ) : ?>
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-[#0B3570]">Application</h3>
            <div class="grid grid-cols-2 gap-4">
                <?php foreach ( $tech_guide_apps as $app ) : ?>
                <div class="bg-[#F2F4F7] p-4 font-bold text-[#0B3570] text-[11px] uppercase tracking-widest text-center rounded-sm">
                    <?php echo esc_html( $app['app_name'] ); ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Image Column -->
        <div class="relative h-[450px]">
            <?php if ( $tech_guide_image ) : ?>
                <?php echo wp_get_attachment_image( $tech_guide_image, 'large', false, array( 'class' => 'w-full h-full object-cover rounded-sm shadow-md' ) ); ?>
            <?php else : ?>
                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
            <?php endif; ?>

            <!-- Badge (Optional) -->
            <?php if ( $tech_guide_badge_title ) : ?>
            <div class="absolute -bottom-4 -right-4 bg-[#0B3570] p-6 text-white w-48 text-center shadow-xl rounded-sm">
                <div class="text-2xl font-bold font-mono text-[#F4BD5D]">
                    <?php echo esc_html( $tech_guide_badge_title ); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; // End tech_guide check ?>
