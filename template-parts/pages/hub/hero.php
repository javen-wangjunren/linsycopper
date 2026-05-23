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
                <nav class="mb-4 font-mono text-[16px] font-semibold uppercase tracking-wider text-[#6B7280]">
                    <a href="<?php echo esc_url( home_url() ); ?>" class="hover:text-[#F97C30] transition-colors">Home</a>
                    <span class="mx-2">/</span>
                    <a href="<?php echo esc_url( home_url('/products') ); ?>" class="hover:text-[#F97C30] transition-colors">Catalog</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#0B3570]"><?php echo get_the_title(); ?></span>
                </nav>

                <p class="mb-4 font-mono text-sm font-semibold uppercase tracking-wider text-[#F97C30]">
                    PRODUCT CATALOG
                </p>
                
                <h1 class="mb-6 text-4xl font-bold leading-tight text-[#1F2937] md:text-5xl text-heading">
                    <?php echo wp_kses_post( $title ); ?>
                </h1>
                
                <?php if ( $desc ) : ?>
                <p class="text-lg leading-relaxed text-[#6B7280]">
                    <?php echo wp_kses_post( $desc ); ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Right: CTA -->
            <div class="flex shrink-0 flex-col gap-4">
                <div class="mb-2 text-right hidden md:block">
                    <p class="font-mono text-xs font-semibold uppercase tracking-wider text-[#F97C30]">
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
