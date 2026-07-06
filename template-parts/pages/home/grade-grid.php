<?php
/**
 * Template Part: Grade Grid (Popular Materials)
 * Context: Home Page
 * 
 * Logic:
 * 1. Init: Data retrieval using get_flat_field().
 * 2. Preprocess: Data validation and fallback handling.
 * 3. View: Pure HTML output with Industrial Material Realism styling.
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Init (Data Retrieval)
// ==========================================
$title    = get_flat_field( 'grade_grid_title', [], 'Best-Selling Copper Grades' );
$subtitle = get_flat_field( 'grade_grid_subtitle', [], 'Fast shipping on our most requested alloys' );
$items    = get_flat_field( 'grade_grid_items', [], [] );

// ==========================================
// 2. Preprocess (Data Handling)
// ==========================================
if ( empty( $items ) ) {
	return;
}

// ==========================================
// 3. View (Pure Output)
// ==========================================
?>

<section class="bg-white pt-[100px] pb-24">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="mb-12 flex flex-col items-center justify-between gap-4 md:flex-row">
            <div>
                <h2 class="lc-h2-section text-balance text-heading">
                    <?php echo esc_html( $title ); ?>
                </h2>
                <p class="lc-body-section mt-2 text-pretty md:text-base">
                    <?php echo esc_html( $subtitle ); ?>
                </p>
            </div>
            
            <a href="https://www.linsycopper.com/copper-grade/" class="lc-home-viewall-btn group flex items-center justify-center rounded-sm border-2 px-6 py-2.5 font-bold transition-all">
                View All Grades
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 transition-transform group-hover:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Grades Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ( $items as $item ) : 
                $code         = isset( $item['grade_code'] ) ? $item['grade_code'] : '';
                $name         = isset( $item['grade_name'] ) ? $item['grade_name'] : '';
                $stock        = isset( $item['stock_status'] ) ? $item['stock_status'] : 'In Stock';
                $equivalents  = isset( $item['equivalents'] ) ? $item['equivalents'] : [];
                $link         = isset( $item['link'] ) ? $item['link'] : null;
                
                $target_url   = $link ? $link['url'] : '#';
                $target_title = $link ? $link['title'] : 'View Technical Specs';
                $target_attr  = ( $link && ! empty( $link['target'] ) ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '';
            ?>
                <a href="<?php echo esc_url( $target_url ); ?>" <?php echo $target_attr; ?> class="group relative block overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg">
                    
                    <!-- Stock Badge -->
                    <div class="lc-mono-chip absolute right-4 top-4 rounded-sm bg-[#10B981] px-2 py-1 text-white uppercase">
                        <?php echo esc_html( $stock ); ?>
                    </div>

                    <div class="p-6">
                        <!-- Grade Code -->
                        <div class="mb-6">
                            <div class="font-sans mb-1 text-3xl font-bold tracking-tight text-[#0B3570]">
                                <?php echo esc_html( $code ); ?>
                            </div>
                            <div class="font-sans text-sm font-medium text-[#6B7280]">
                                <?php echo esc_html( $name ); ?>
                            </div>
                        </div>

                        <!-- International Equivalents -->
                        <div class="mb-6 space-y-3">
                            <div class="lc-mono-kicker mb-3 flex items-center gap-2 text-[#9CA3AF]">
                                <span class="flex-none">International Equivalents</span>
                                <div class="h-px flex-1 bg-[#E5E7EB]"></div>
                            </div>
                            
                            <div class="space-y-2">
                                <?php if ( ! empty( $equivalents ) ) : foreach ( $equivalents as $equiv ) : ?>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="lc-mono-chip min-w-[40px] rounded-sm bg-[#F3F4F6] px-1.5 py-0.5 text-center text-[#6B7280]">
                                            <?php echo esc_html( $equiv['standard'] ); ?>
                                        </span>
                                        <div class="mx-3 flex-1 border-b border-dashed border-[#E5E7EB]"></div>
                                        <span class="lc-mono-meta font-bold text-[#1F2937]">
                                            <?php echo esc_html( $equiv['code'] ); ?>
                                        </span>
                                    </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>

                        <!-- View More CTA -->
                        <div class="border-t border-[#F3F4F6] pt-4">
                            <div class="lc-card-cta">
                                <?php echo esc_html( $target_title ); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Accent Bar -->
                    <div class="h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full"></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Visual Contract Verified: Industrial Material Realism -->
