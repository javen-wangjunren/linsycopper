<?php
/**
 * Template Part: Why Choose Us (Industrial Dashboard)
 * Context: Home Page
 * 
 * Logic:
 * 1. Init: Data retrieval using get_flat_field().
 * 2. Preprocess: Validation and default handling.
 * 3. View: Render technical split layout with stats dashboard and advantage cards.
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Init (Data Retrieval)
// ==========================================
$title    = get_flat_field( 'why_title', [], 'Why Choose Linsy Copper?' );
$desc     = get_flat_field( 'why_desc', [], 'With over two decades of expertise in copper and alloy distribution, we deliver precision-cut materials with full traceability.' );
$stats    = get_flat_field( 'why_stats', [], [] );
$img_id   = get_flat_field( 'why_main_image' );
$badge_enabled = get_flat_field( 'why_badge_enabled', [], true );
$badge_kicker  = get_flat_field( 'why_badge_kicker', [], 'Quality Assurance' );
$badge_title   = get_flat_field( 'why_badge_title', [], '100% Traceable' );
?>

<section class="relative overflow-hidden bg-[#F8FAFC] pt-[100px] pb-24">
    <!-- Background Technical Grid -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none" 
         style="background-image: radial-gradient(#0B3570 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    <div class="relative mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

        <!-- Top Section: Split Layout -->
        <div class="flex flex-col gap-12 lg:flex-row lg:items-start mb-20">

            <!-- Left: Content Area -->
            <div class="flex flex-col gap-8 lg:w-1/2">
                <div class="flex flex-col gap-5">
                    <h2 class="lc-h2-display text-balance text-heading">
                        <?php echo nl2br( esc_html( $title ) ); ?>
                    </h2>
                    <p class="lc-body-section max-w-xl">
                        <?php echo nl2br( esc_html( $desc ) ); ?>
                    </p>
                </div>

                <?php if ( ! empty( $stats ) ) : ?>
                    <!-- Stats Dashboard Grid -->
                    <div class="grid grid-cols-2 gap-4 w-full max-w-md">
                        <?php foreach ( $stats as $stat ) : ?>
                            <div class="relative bg-white p-5 rounded-lg border border-slate-200/70 shadow-[0_10px_30px_-24px_rgba(15,23,42,0.35)] group hover:border-[#F97C30] transition-colors">
                                <!-- Technical Corner Accent -->
                                <div class="absolute top-0 right-0 w-2 h-2 border-t border-r border-slate-200/70 group-hover:border-[#F97C30]"></div>
                                
                                <div class="flex flex-col">
                                    <span class="font-sans tabular-nums text-3xl font-bold tracking-tight text-[#0B3570]"><?php echo esc_html( $stat['stat_value'] ); ?></span>
                                    <span class="mt-1 font-sans text-[12px] font-medium text-[#64748B]"><?php echo esc_html( $stat['stat_label'] ); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Technical Visual -->
            <div class="lg:w-1/2">
                <div class="relative group">
                    <!-- Image Container with "Machined" Border -->
                    <div class="relative overflow-hidden rounded-lg shadow-xl aspect-square ring-1 ring-black/5">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'large', false, array( 'class' => 'h-full w-full object-cover grayscale-[0.3] contrast-[1.1] transition-transform duration-700 group-hover:scale-105' ) ); ?>
                        <?php else : ?>
                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2070" alt="Fallback Industrial Scene" class="h-full w-full object-cover grayscale-[0.3] contrast-[1.1]">
                        <?php endif; ?>
                        
                        <!-- Industrial Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#0B3570]/40 via-transparent to-transparent mix-blend-multiply"></div>
                    </div>
                    
                    <?php if ( $badge_enabled ) : ?>
                        <div class="absolute -bottom-6 -left-6 hidden md:block bg-[#F97C30] p-6 rounded-sm shadow-2xl text-white">
                            <div class="lc-mono-kicker mb-1 opacity-80"><?php echo esc_html( $badge_kicker ); ?></div>
                            <div class="text-2xl font-bold leading-none italic"><?php echo esc_html( $badge_title ); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Visual Contract Verified: Industrial Material Realism -->
