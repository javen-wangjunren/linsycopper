<?php
/**
 * Template Part: Home - Review
 * 
 * Logic:
 * Displays a horizontal carousel of customer testimonials.
 * Strictly follows the Linsy Copper "Three-Phase Architecture":
 * 1. Init: Data fetching using get_flat_field()
 * 2. Preprocess: Fallback handling and logic
 * 3. View: Clean HTML output with Tailwind v4
 * 
 * @package GeneratePress_Child
 */

// Phase 1: Init (Data Acquisition)
$title   = get_flat_field( 'review_title' ) ?: 'Trusted by Industry Leaders';
$desc    = get_flat_field( 'review_desc' ) ?: 'Real feedback from procurement and engineering professionals across industries.';
$reviews = get_flat_field( 'review_list' );

// Phase 2: Preprocess (Data Processing / Fallback)
if ( empty( $reviews ) ) {
    return;
}

// Generate a unique ID for this instance to support multiple carousels if needed
$section_uid = 'lc-review-' . substr( md5( $title ), 0, 8 );
?>

<!-- Phase 3: View (Pure Output) -->
<section id="<?php echo esc_attr( $section_uid ); ?>" class="lc-review bg-white pt-[100px] pb-24 overflow-hidden">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

        <!-- Section Header + Navigation -->
        <div class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <h2 class="lc-h2-section text-balance text-heading">
                    <?php echo esc_html( $title ); ?>
                </h2>
                
                <?php if ( $desc ) : ?>
                    <p class="lc-body-section mt-6 text-pretty">
                        <?php echo esc_html( $desc ); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Navigation Arrows (Industrial Precision) -->
            <div class="flex gap-3">
                <button class="lc-btn-reset review-prev group flex h-12 w-12 items-center justify-center p-0 rounded-sm border-2 border-[#E5E7EB] transition-all hover:border-[#0B3570] hover:bg-[#0B3570] hover:text-white active:scale-95" aria-label="Previous review">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:-translate-x-1"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="lc-btn-reset review-next group flex h-12 w-12 items-center justify-center p-0 rounded-sm border-2 border-[#E5E7EB] transition-all hover:border-[#0B3570] hover:bg-[#0B3570] hover:text-white active:scale-95" aria-label="Next review">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>

        <!-- Carousel Wrapper (Snap-swipe enabled) -->
        <div class="review-carousel flex gap-6 lg:gap-8 overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth -mx-4 px-4 md:mx-0 md:px-0">
            
            <?php foreach ( $reviews as $review ) : 
                $content = $review['review_content'] ?? '';
                $img_id  = $review['author_image'] ?? 0;
                $name    = $review['author_name'] ?? '';
                $role    = $review['author_role'] ?? '';
                ?>
                <div class="group relative flex flex-col shrink-0 w-[88%] md:w-[46%] lg:w-[31.5%] snap-center overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
                    
                    <!-- Decorative Quote Icon -->
                    <div class="mb-8">
                        <svg class="h-8 w-8 text-[#F97C30]/20 transition-colors group-hover:text-[#F97C30]/40" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H12.017V21H14.017ZM5.017 21L5.017 18C5.017 16.8954 5.91243 16 7.017 16H10.017C10.5693 16 11.017 15.5523 11.017 15V9C11.017 8.44772 10.5693 8 10.017 8H7.017C6.46472 8 6.017 8.44772 6.017 9V12C6.017 12.5523 5.56929 13 5.017 13H3.017V21H5.017Z" />
                        </svg>
                    </div>
                    
                    <blockquote class="flex-1 text-lg leading-relaxed text-[#1F2937] italic">
                        &ldquo;<?php echo esc_html( $content ); ?>&rdquo;
                    </blockquote>
                    
                    <div class="mt-10 flex items-center gap-4 border-t border-[#F3F4F6] pt-8">
                        <?php if ( $img_id ) : ?>
                            <div class="h-14 w-14 overflow-hidden rounded-full border-2 border-transparent transition-all group-hover:border-[#F97C30]/30">
                                <?php echo wp_get_attachment_image( $img_id, 'thumbnail', false, array( 
                                    'class' => 'h-full w-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500' 
                                ) ); ?>
                            </div>
                        <?php else : ?>
                            <div class="h-14 w-14 shrink-0 rounded-full bg-gray-100 flex items-center justify-center grayscale">
                                <svg class="h-8 w-8 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-lg text-[#1F2937] truncate"><?php echo esc_html( $name ); ?></div>
                            <div class="text-[13px] font-medium text-[#6B7280] truncate">
                                <?php echo esc_html( $role ); ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Color Accent Bar -->
                    <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#F97C30] transition-all duration-500 group-hover:w-full"></div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<script>
    (function() {
        const container = document.getElementById('<?php echo esc_js( $section_uid ); ?>');
        if (!container) return;

        const carousel = container.querySelector('.review-carousel');
        const nextBtn = container.querySelector('.review-next');
        const prevBtn = container.querySelector('.review-prev');

        if (!carousel || !nextBtn || !prevBtn) return;

        const getScrollAmount = () => {
            const firstCard = carousel.querySelector('div');
            return firstCard ? firstCard.offsetWidth + 32 : 300;
        };

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });
    })();
</script>
