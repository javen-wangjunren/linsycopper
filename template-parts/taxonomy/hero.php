<?php
/**
 * Taxonomy Archive: Hero Banner
 * ==========================================================================
 * Location: template-parts/taxonomy/hero.php
 * 
 * Logic:
 * 1. Fetches ACF fields from the current term.
 * 2. Displays Title, Description, Breadcrumbs, CTA.
 * 3. Handles fallback for missing data.
 * 
 * @package GeneratePress_Child
 */

// Get current term context
$term = get_queried_object();

// Get ACF Fields
$hero_image_id = get_field( 'hero_image', $term );
$hero_title    = get_field( 'hero_title', $term );
$hero_desc     = get_field( 'hero_description', $term );
$hero_cta_text = get_field( 'hero_cta_text', $term ) ?: 'Request a Quote';
$hero_cta_link = get_field( 'hero_cta_link', $term ) ?: '#contact-form';

// Fallback Title
if ( empty( $hero_title ) ) {
	$hero_title = single_term_title( '', false );
}

$breadcrumb_items = function_exists( 'linsy_get_taxonomy_breadcrumb_items' )
	? linsy_get_taxonomy_breadcrumb_items( $term )
	: array();
?>

<!-- Copper UI: Vertical Rhythm (pt-[100px] implied by header spacing) -->
<section class="lc-taxonomy-hero-scope relative bg-[#0B3570] overflow-hidden font-sans">
    <div class="mx-auto flex max-w-[1440px] flex-col items-stretch md:flex-row">
        <!-- Text Content -->
        <div class="z-10 flex flex-col justify-center p-8 text-left md:w-1/2 md:py-16 lg:px-24 lg:py-20">
            <!-- Breadcrumb -->
            <?php if ( ! empty( $breadcrumb_items ) ) : ?>
            <div class="lc-breadcrumb-scope lc-breadcrumb-on-dark mb-3">
                <nav aria-label="Breadcrumb" class="text-sm text-white/80 sm:text-[15px]">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                        <?php foreach ( $breadcrumb_items as $index => $item ) : ?>
                            <?php $is_last = $index === array_key_last( $breadcrumb_items ); ?>
                            <li class="flex items-center gap-x-2">
                                <?php if ( ! empty( $item['url'] ) && ! $is_last ) : ?>
                                    <a href="<?php echo esc_url( $item['url'] ); ?>" class="transition-colors">
                                        <?php echo esc_html( $item['label'] ); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="<?php echo $is_last ? 'font-medium text-white' : ''; ?>">
                                        <?php echo esc_html( $item['label'] ); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ( ! $is_last ) : ?>
                                    <span aria-hidden="true" class="text-white/35">/</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
            <?php endif; ?>
            
            <!-- Copper UI: Theme Bridge (H1) -->
            <h1 class="lc-h1-page mb-6 text-white">
                <?php echo wp_kses_post( $hero_title ); ?>
            </h1>
            
            <?php if ( $hero_desc ) : ?>
            <p class="lc-taxonomy-hero-desc lc-body-section mb-8 max-w-xl md:text-lg">
                <?php echo esc_html( $hero_desc ); ?>
            </p>
            <?php endif; ?>
            
            <!-- CTA Button -->
            <div>
                <a
                    href="<?php echo esc_url( $hero_cta_link ); ?>"
                    class="lc-btn-action inline-flex items-center justify-center rounded-sm px-6 py-3.5 text-[15px] font-semibold transition-colors"
                >
                    <?php echo esc_html( $hero_cta_text ); ?>
                </a>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="relative w-full md:w-1/2 flex items-center justify-center">
             <!-- Wrapper to force aspect ratio -->
             <div class="relative w-full aspect-[4/3]">
                <?php 
                if ( $hero_image_id ) {
                    echo wp_get_attachment_image( $hero_image_id, 'full', false, array( 
                        'class' => 'absolute inset-0 h-full w-full object-cover',
                        'alt'   => $term->name . ' Hero Image'
                    ) );
                } else {
                    // Fallback Placeholder
                    echo '<img src="https://via.placeholder.com/800x600?text=Linsy+Copper" class="absolute inset-0 h-full w-full object-cover" alt="Placeholder">';
                }
                ?>
             </div>
        </div>
    </div>
</section>
