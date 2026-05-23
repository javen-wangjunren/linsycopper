<?php
/**
 * Component: Author Card (Small / Vertical)
 * Path: template-parts/single-blog/author-card.php
 * 
 * Logic:
 * - Fetches user meta (Job title, Photo, LinkedIn, Bio).
 */

$author_id = get_the_author_meta( 'ID' );

// Get ACF fields for author (using get_flat_field for consistency)
$photo_id = get_flat_field( 'user_author_image', null, 'user_' . $author_id );
$job      = get_flat_field( 'user_author_job', null, 'user_' . $author_id );
$linkedin = get_flat_field( 'user_author_linkedin', null, 'user_' . $author_id );
$bio      = get_flat_field( 'user_author_bio', null, 'user_' . $author_id );

// Fallback: If no custom photo, use Gravatar
$photo_html = '';
if ( $photo_id ) {
    $photo_html = wp_get_attachment_image( $photo_id, 'thumbnail', false, array(
        'class' => 'h-16 w-16 md:h-20 md:w-20 rounded-sm object-cover border border-[#E5E7EB] p-1 bg-white shadow-sm',
    ) );
} else {
    $photo_html = get_avatar( $author_id, 80, '', '', array(
        'class' => 'h-16 w-16 md:h-20 md:w-20 rounded-sm object-cover border border-[#E5E7EB] p-1 bg-white shadow-sm',
    ) );
}
?>

<div class="bg-[#F8F9FA] border border-[#E5E7EB] rounded-sm p-6 md:p-8 relative overflow-hidden group">
    <!-- Subtle accent line -->
    <div class="absolute top-0 left-0 w-full h-[3px] bg-[#E5E7EB] group-hover:bg-[#F97C30] transition-colors duration-500"></div>

    <div class="flex items-start gap-6 mb-6">
        <!-- Photo -->
        <div class="flex-shrink-0">
            <?php echo $photo_html; ?>
        </div>
        
        <!-- Identity -->
        <div>
            <span class="block font-mono text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1">Author / Expert</span>
            <h4 class="text-heading text-lg font-bold text-[#1F2937] leading-tight mb-1">
                <?php the_author(); ?>
            </h4>
            <?php if ( $job ) : ?>
                <p class="text-xs font-mono font-semibold text-[#F97C30] uppercase tracking-wider">
                    <?php echo esc_html( $job ); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bio -->
    <?php if ( $bio ) : ?>
        <div class="text-sm leading-relaxed text-[#6B7280] mb-8 border-l-2 border-[#E5E7EB] pl-4 italic">
            <?php echo wp_kses_post( $bio ); ?>
        </div>
    <?php endif; ?>

    <!-- Social / Link -->
    <?php if ( $linkedin ) : ?>
        <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" 
           class="flex items-center justify-center gap-3 w-full py-3 px-4 rounded-sm border border-[#0B3570] text-[#0B3570] font-bold text-xs uppercase tracking-widest transition-all duration-300 hover:bg-[#0B3570] hover:text-white group">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            Professional Profile
        </a>
    <?php endif; ?>
</div>
