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
?>

<!-- Copper UI: Vertical Rhythm (pt-[100px] implied by header spacing) -->
<section class="relative bg-[#0B3570] overflow-hidden font-sans">
    <div class="mx-auto flex max-w-[1440px] flex-col items-stretch md:flex-row">
        <!-- Text Content -->
        <div class="z-10 flex flex-col justify-center p-8 text-left md:w-1/2 md:py-16 lg:px-24 lg:py-20">
            <!-- Breadcrumb -->
            <nav class="mb-6 font-mono text-[16px] font-semibold text-white uppercase tracking-wider">
                <a href="<?php echo home_url(); ?>" class="!text-white visited:!text-white transition hover:!text-[#F97C30] focus:!text-[#F97C30] active:!text-[#F97C30]">Home</a>
                <span class="mx-2">/</span>
                <a href="<?php echo home_url('/products'); ?>" class="!text-white visited:!text-white transition hover:!text-[#F97C30] focus:!text-[#F97C30] active:!text-[#F97C30]">Catalog</a>
                <span class="mx-2">/</span>
                <span class="text-white"><?php echo esc_html( $term->name ); ?></span>
            </nav>
            
            <!-- Copper UI: Theme Bridge (H1) -->
            <h1 class="mb-6 text-4xl font-bold leading-tight tracking-tight text-white md:text-5xl lg:text-6xl text-heading">
                <?php echo wp_kses_post( $hero_title ); ?>
            </h1>
            
            <?php if ( $hero_desc ) : ?>
            <p class="mb-8 max-w-xl text-lg leading-relaxed text-blue-100/80">
                <?php echo esc_html( $hero_desc ); ?>
            </p>
            <?php endif; ?>
            
            <!-- CTA Button -->
            <div>
                <a
                    href="<?php echo esc_url( $hero_cta_link ); ?>"
                    class="inline-block transform bg-[#F97C30] px-8 py-4 font-mono text-[16px] font-bold !text-white visited:!text-white hover:!text-white focus:!text-white active:!text-white shadow-lg transition hover:-translate-y-1 hover:bg-orange-600 rounded-sm uppercase tracking-wider"
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
