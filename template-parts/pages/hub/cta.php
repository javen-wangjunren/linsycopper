<?php
/**
 * Taxonomy Hub: Bottom CTA
 * ==========================================================================
 * Location: template-parts/hub/cta.php
 * 
 * Logic:
 * 1. Fetches ACF fields from Page.
 * 2. Displays a gradient CTA box.
 * 
 * @package GeneratePress_Child
 */

$cta_title    = get_field( 'hub_bottom_cta_title' ) ?: "Can't Find the Shape You Need?";
$cta_desc     = get_field( 'hub_bottom_cta_desc' );
$btn_text     = get_field( 'hub_bottom_cta_btn_text' ) ?: 'Contact Sales Team';
$btn_link     = get_field( 'hub_bottom_cta_btn_link' ) ?: '/contact';
?>

<section class="bg-white py-16 md:py-24 font-sans">
    <div class="mx-auto max-w-[1440px] px-4 lg:px-8">
        
        <!-- Gradient Box -->
        <div class="lc-hub-cta rounded-sm border-2 border-[#0B3570] bg-gradient-to-br from-[#0B3570] to-[#0B3570]/90 p-8 text-center md:p-12 shadow-lg">
            
            <h3 class="mb-4 text-balance text-2xl font-bold text-white md:text-3xl text-heading">
                <?php echo esc_html( $cta_title ); ?>
            </h3>
            
            <?php if ( $cta_desc ) : ?>
            <p class="mb-8 text-pretty text-white/90 max-w-2xl mx-auto leading-relaxed" style="text-align:center !important;">
                <?php echo wp_kses_post( $cta_desc ); ?>
            </p>
            <?php endif; ?>
            
            <div class="flex justify-center">
                <a
                    href="<?php echo esc_url( $btn_link ); ?>"
                    class="lc-hub-cta-btn rounded-sm bg-[#F97C30] px-8 py-4 font-mono font-bold uppercase tracking-widest text-white shadow-md transition-all hover:bg-[#F4BD5D] hover:text-[#0B3570] hover:shadow-lg active:scale-95"
                >
                    <?php echo esc_html( $btn_text ); ?>
                </a>
            </div>
            
        </div>
        
    </div>
</section>
