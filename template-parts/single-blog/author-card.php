<?php
/**
 * Component: Author Card (Small / Vertical)
 * Path: template-parts/single-blog/author-card.php
 * 
 * Logic:
 * - Fetches user meta (Job title, Photo, LinkedIn, Bio).
 */

$variant   = isset( $args['variant'] ) ? (string) $args['variant'] : 'sidebar';
$author_id = get_the_author_meta( 'ID' );
$profile   = function_exists( 'linsy_get_blog_author_profile' ) ? linsy_get_blog_author_profile( $author_id ) : array();

$name     = ! empty( $profile['name'] ) ? $profile['name'] : get_the_author();
$job      = ! empty( $profile['job'] ) ? $profile['job'] : '';
$linkedin = ! empty( $profile['linkedin'] ) ? $profile['linkedin'] : '';
$bio      = ! empty( $profile['bio'] ) ? $profile['bio'] : '';

$sidebar_photo = function_exists( 'linsy_get_blog_author_avatar_html' )
    ? linsy_get_blog_author_avatar_html( $author_id, 80, 'w-14 h-14 rounded-full object-cover' )
    : get_avatar( $author_id, 80, '', $name, array( 'class' => 'w-14 h-14 rounded-full object-cover' ) );

$footer_photo = function_exists( 'linsy_get_blog_author_avatar_html' )
    ? linsy_get_blog_author_avatar_html( $author_id, 80, 'w-full h-full object-cover' )
    : get_avatar( $author_id, 80, '', $name, array( 'class' => 'w-full h-full object-cover' ) );
?>

<?php if ( 'footer' === $variant ) : ?>
    <div class="border border-[#E5E7EB] rounded-sm p-6 lg:p-8 bg-white">
        <div class="flex flex-col sm:flex-row gap-5 sm:items-start">
            <div class="w-14 h-14 rounded-full overflow-hidden border border-[#E5E7EB] bg-[#F8F9FA] shrink-0">
                <?php echo $footer_photo; ?>
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-[16px] font-bold tracking-tight text-[#1F2937]">
                            <?php echo esc_html( $name ); ?>
                        </div>
                        <?php if ( $job ) : ?>
                            <div class="font-mono text-[11px] tracking-wider text-[#F97C30] uppercase mt-0.5">
                                <?php echo esc_html( $job ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ( $linkedin ) : ?>
                        <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="lc-btn-reset lc-blog-author-footer-link inline-flex items-center gap-2 px-3 py-2 rounded-sm border border-[#E5E7EB] hover:border-[#F97C30] text-[12px] font-mono font-bold tracking-wider text-[#1F2937] hover:text-[#F97C30] no-underline transition-colors" aria-label="<?php echo esc_attr( $name ); ?> LinkedIn">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            LinkedIn
                        </a>
                    <?php endif; ?>
                </div>
                <?php if ( $bio ) : ?>
                    <div class="mt-4 text-[#4B5563] leading-relaxed text-[14px]">
                        <?php echo wp_kses_post( $bio ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="border border-[#E5E7EB] rounded-sm p-6 bg-white">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="font-mono text-[11px] tracking-wider text-[#6B7280] uppercase">Author</div>
            <?php if ( $linkedin ) : ?>
                <div class="flex items-center gap-2">
                    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="lc-btn-reset lc-blog-author-link w-9 h-9 rounded-sm border border-[#E5E7EB] hover:border-[#F97C30] flex items-center justify-center text-[#6B7280] hover:text-[#F97C30] no-underline transition-colors" aria-label="<?php echo esc_attr( $name ); ?> LinkedIn">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-full overflow-hidden border border-[#E5E7EB] bg-[#F8F9FA] shrink-0">
                <?php echo $sidebar_photo; ?>
            </div>
            <div class="min-w-0">
                <div class="text-[16px] font-bold tracking-tight text-[#1F2937]">
                    <?php echo esc_html( $name ); ?>
                </div>
                <?php if ( $job ) : ?>
                    <div class="font-mono text-[11px] tracking-wider text-[#F97C30] uppercase mt-0.5">
                        <?php echo esc_html( $job ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( $bio ) : ?>
                    <div class="mt-3 text-[13px] text-[#4B5563] leading-relaxed">
                        <?php echo wp_kses_post( $bio ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
