<?php
/**
 * Taxonomy Hub: Hero Section (Text Only)
 * ==========================================================================
 * Location: template-parts/hub/hero.php
 * 
 * Logic:
 * 1. Fetches ACF fields from the current PAGE.
 * 2. Displays Title, Description, Breadcrumbs, CTA.
 * 
 * @package GeneratePress_Child
 */

// Get ACF Fields
$title    = get_field( 'hub_hero_title' );
$desc     = get_field( 'hub_hero_desc' );
$cta_text = get_field( 'hub_hero_cta_text' ) ?: 'Contact Us';
$cta_link = get_field( 'hub_hero_cta_link' ) ?: '#contact';

// Fallback Title
if ( empty( $title ) ) {
	$title = get_the_title();
}
?>

<!-- Copper UI: Vertical Rhythm (pt-[100px] implied by header spacing) -->
<section class="bg-white py-16 md:py-24 font-sans">
    <div class="mx-auto max-w-[1440px] px-4 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
            
            <!-- Left: Text Content -->
            <div class="max-w-3xl">
                <!-- Breadcrumb -->
                <div class="lc-breadcrumb-scope mb-3">
                    <nav aria-label="Breadcrumb" class="text-sm text-gray-500 sm:text-[15px]">
                        <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <li class="flex items-center gap-x-2">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-[#F97C30]">
                                    Home
                                </a>
                                <span aria-hidden="true" class="text-gray-300">/</span>
                            </li>

                            <li class="flex items-center gap-x-2">
                                <span class="font-medium text-[#0B3570]">
                                    <?php echo esc_html( $title ); ?>
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <h1 class="lc-h1-page mb-6 text-[#1F2937]">
                    <?php echo wp_kses_post( $title ); ?>
                </h1>
                
                <?php if ( $desc ) : ?>
                <p class="lc-body-section md:text-lg">
                    <?php echo wp_kses_post( $desc ); ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Right: CTA -->
            <div class="flex shrink-0 flex-col gap-4">
                <div class="mb-2 text-right hidden md:block">
                    <p class="lc-mono-kicker text-[#F97C30]">
                        Need Help?
                    </p>
                </div>
                <a
                    href="<?php echo esc_url( $cta_link ); ?>"
                    class="button lc-hub-hero-cta"
                >
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            </div>

        </div>
    </div>
</section>
