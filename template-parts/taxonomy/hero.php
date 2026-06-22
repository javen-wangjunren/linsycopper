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
$hub_page = null;

if ( $term && ! empty( $term->taxonomy ) && function_exists( 'linsy_get_product_taxonomy_hub_page' ) ) {
    $hub_page = linsy_get_product_taxonomy_hub_page( $term->taxonomy );
}

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
?>

<!-- Copper UI: Vertical Rhythm (pt-[100px] implied by header spacing) -->
<section class="relative bg-[#0B3570] overflow-hidden font-sans">
    <div class="mx-auto flex max-w-[1440px] flex-col items-stretch md:flex-row">
        <!-- Text Content -->
        <div class="z-10 flex flex-col justify-center p-8 text-left md:w-1/2 md:py-16 lg:px-24 lg:py-20">
            <!-- Breadcrumb -->
            <div class="lc-breadcrumb-scope lc-breadcrumb-on-dark mb-6">
                <nav aria-label="Breadcrumb" class="text-sm text-white sm:text-[15px]">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                        <li class="flex items-center gap-x-2">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-[#F97C30]">
                                Home
                            </a>
                            <span aria-hidden="true" class="text-white/35">/</span>
                        </li>

                        <?php if ( $hub_page && is_object( $hub_page ) ) : ?>
                            <li class="flex items-center gap-x-2">
                                <a href="<?php echo esc_url( get_permalink( $hub_page ) ); ?>" class="transition-colors hover:text-[#F97C30]">
                                    <?php echo esc_html( linsy_get_product_taxonomy_hub_label( $hub_page ) ); ?>
                                </a>
                                <span aria-hidden="true" class="text-white/35">/</span>
                            </li>
                        <?php endif; ?>

                        <li class="flex items-center gap-x-2">
                            <span class="font-medium text-white">
                                <?php echo esc_html( $term->name ); ?>
                            </span>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <!-- Copper UI: Theme Bridge (H1) -->
            <h1 class="lc-h1-page mb-6 text-white">
                <?php echo wp_kses_post( $hero_title ); ?>
            </h1>
            
            <?php if ( $hero_desc ) : ?>
            <p class="lc-body-section mb-8 max-w-xl text-blue-100/80 md:text-lg">
                <?php echo esc_html( $hero_desc ); ?>
            </p>
            <?php endif; ?>
            
            <!-- CTA Button -->
            <div>
                <a
                    href="<?php echo esc_url( $hero_cta_link ); ?>"
                    class="inline-block transform bg-[#F97C30] px-8 py-4 text-[16px] font-bold !text-white visited:!text-white hover:!text-white focus:!text-white active:!text-white shadow-lg transition hover:-translate-y-1 hover:bg-orange-600 rounded-sm uppercase tracking-wider"
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
