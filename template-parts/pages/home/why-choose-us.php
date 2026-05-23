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
$reasons  = get_flat_field( 'why_reasons', [], [] );

// ==========================================
// 2. Preprocess
// ==========================================
if ( empty( $reasons ) ) {
	return;
}
?>

<section class="relative overflow-hidden bg-[#F8FAFC] pt-[100px] pb-24">
    <!-- Background Technical Grid -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
         style="background-image: radial-gradient(#0B3570 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    <div class="relative mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

        <!-- Top Section: Split Layout -->
        <div class="flex flex-col gap-12 lg:flex-row lg:items-start mb-20">

            <!-- Left: Content Area -->
            <div class="flex flex-col gap-8 lg:w-1/2">
                <div class="flex flex-col gap-5">
                    <h2 class="text-heading text-balance text-4xl font-bold tracking-tight leading-[1.1] md:text-5xl lg:text-6xl">
                        <?php echo nl2br( esc_html( $title ) ); ?>
                    </h2>
                    <p class="max-w-xl text-[#6B7280] leading-relaxed text-base md:text-lg">
                        <?php echo nl2br( esc_html( $desc ) ); ?>
                    </p>
                </div>

                <?php if ( ! empty( $stats ) ) : ?>
                    <!-- Stats Dashboard Grid -->
                    <div class="grid grid-cols-2 gap-4 w-full max-w-md">
                        <?php foreach ( $stats as $stat ) : ?>
                            <div class="relative bg-white p-5 border border-[#E5E7EB] rounded-sm group hover:border-[#F97C30] transition-colors">
                                <!-- Technical Corner Accent -->
                                <div class="absolute top-0 right-0 w-2 h-2 border-t border-r border-[#E5E7EB] group-hover:border-[#F97C30]"></div>
                                
                                <div class="flex flex-col">
                                    <span class="font-mono text-3xl font-bold text-[#0B3570] tracking-tight"><?php echo esc_html( $stat['stat_value'] ); ?></span>
                                    <span class="mt-1 text-[10px] font-bold uppercase tracking-wider text-[#9CA3AF]"><?php echo esc_html( $stat['stat_label'] ); ?></span>
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
                    <div class="relative overflow-hidden rounded-sm border-[8px] border-white shadow-xl aspect-[4/3]">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'large', false, array( 'class' => 'h-full w-full object-cover grayscale-[0.3] contrast-[1.1] transition-transform duration-700 group-hover:scale-105' ) ); ?>
                        <?php else : ?>
                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2070" alt="Fallback Industrial Scene" class="h-full w-full object-cover grayscale-[0.3] contrast-[1.1]">
                        <?php endif; ?>
                        
                        <!-- Industrial Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#0B3570]/40 via-transparent to-transparent mix-blend-multiply"></div>
                    </div>
                    
                    <!-- Floating Badge (Copper Element) -->
                    <div class="absolute -bottom-6 -left-6 hidden md:block bg-[#F97C30] p-6 rounded-sm shadow-2xl text-white">
                        <div class="font-mono text-sm font-bold opacity-80 mb-1 uppercase tracking-widest">Quality Assurance</div>
                        <div class="text-2xl font-bold leading-none italic">100% Traceable</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: 3-Column Advantage Cards -->
        <div class="grid gap-6 md:grid-cols-3 border-t border-[#E5E7EB] pt-16">
            <?php foreach ( $reasons as $reason ) : ?>
                <div class="group relative flex flex-col overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-2xl">
                    <!-- Background Index Number (Etched look) -->
                    <span class="absolute -right-2 -top-4 font-mono text-8xl font-black text-[#0B3570]/[0.03] transition-colors group-hover:text-[#F97C30]/[0.05] leading-none select-none italic">
                        <?php echo esc_html( $reason['reason_icon'] ); ?>
                    </span>

                    <h3 class="text-heading relative mb-4 text-lg font-bold leading-snug text-[#1F2937] group-hover:text-[#0B3570] transition-colors">
                        <?php echo esc_html( $reason['reason_title'] ); ?>
                        <div class="absolute -left-8 top-1/2 w-4 h-[2px] bg-[#F97C30] opacity-0 group-hover:opacity-100 transition-all"></div>
                    </h3>
                    
                    <p class="relative text-[#6B7280] leading-relaxed text-sm flex-1">
                        <?php echo esc_html( $reason['reason_desc'] ); ?>
                    </p>
                    
                    <!-- Bottom Progress Indicator -->
                    <div class="mt-8 h-[2px] w-full bg-[#F3F4F6] overflow-hidden">
                        <div class="h-full w-0 bg-[#F97C30] transition-all duration-500 group-hover:w-full"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Visual Contract Verified: Industrial Material Realism -->
