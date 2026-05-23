<?php
/**
 * Template Part: About - Our Team
 * 
 * Logic:
 * Displays a 4-column grid of team members with hover effects.
 * Strictly follows Linsy Copper "Visual First" SOP and Three-Phase Architecture.
 * 
 * @package GeneratePress_Child
 */

// Phase 1: Init
$eyebrow = get_flat_field( 'team_eyebrow' ) ?: 'Leadership';
$title   = get_flat_field( 'team_title' ) ?: 'Meet Our Team';
$desc    = get_flat_field( 'team_desc' ) ?: 'Industry experts dedicated to delivering exceptional copper solutions.';
$members = get_flat_field( 'team_list' );

// Phase 2: Preprocess
if ( empty( $members ) ) {
    return;
}
?>

<!-- Phase 3: View -->
<section class="lc-team bg-white pt-[100px] pb-24">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="lc-section-header mb-16 text-center">
            <?php if ( $eyebrow ) : ?>
                <div class="mb-4 inline-flex items-center gap-2 rounded-sm bg-[#0B3570]/5 px-3 py-1 font-mono text-[11px] font-bold uppercase tracking-[0.1em] text-[#0B3570]">
                    <span class="h-1.5 w-1.5 bg-[#F97C30]"></span>
                    <?php echo esc_html( $eyebrow ); ?>
                </div>
            <?php endif; ?>
            
            <h2 class="text-heading mx-auto max-w-3xl text-balance text-3xl font-bold leading-tight md:text-4xl lg:text-5xl">
                <?php echo esc_html( $title ); ?>
            </h2>
            
            <?php if ( $desc ) : ?>
                <p class="mx-auto mt-6 max-w-2xl text-pretty text-lg leading-relaxed text-[#6B7280]">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Team Grid -->
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <?php foreach ( $members as $member ) : 
                $img_id   = $member['member_avatar'] ?? 0;
                $name     = $member['member_name'] ?? '';
                $position = $member['member_position'] ?? '';
                $bio      = $member['member_bio'] ?? '';
                $linkedin = $member['member_linkedin'] ?? '';
                $email    = $member['member_email'] ?? '';
                ?>
                <div class="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
                    
                    <!-- Avatar Section -->
                    <div class="lc-team-avatar relative aspect-square overflow-hidden bg-[#F2F4F7]">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'large', false, [
                                'class' => 'absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105'
                            ] ); ?>
                        <?php else : ?>
                            <div class="flex h-full w-full items-center justify-center bg-[#0B3570]/5">
                                <svg class="h-20 w-20 text-[#0B3570]/10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        <?php endif; ?>

                        <!-- Social Overlay (Industrial Blue Gradient) -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0B3570]/80 via-[#0B3570]/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                        
                        <!-- Social Icons -->
                        <div class="absolute bottom-6 left-6 flex gap-3 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                            <?php if ( $linkedin ) : ?>
                                <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" class="flex h-10 w-10 items-center justify-center rounded-sm bg-white/90 text-[#0B3570] transition-colors hover:bg-[#F97C30] hover:text-white shadow-sm" aria-label="LinkedIn Profile">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            <?php endif; ?>
                            <?php if ( $email ) : ?>
                                <a href="mailto:<?php echo esc_attr( function_exists( 'antispambot' ) ? call_user_func( 'antispambot', $email ) : $email ); ?>" class="flex h-10 w-10 items-center justify-center rounded-sm bg-white/90 text-[#0B3570] transition-colors hover:bg-[#F97C30] hover:text-white shadow-sm" aria-label="Send Email">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Member Info -->
                    <div class="p-6">
                        <h3 class="text-heading text-lg font-bold">
                            <?php echo esc_html( $name ); ?>
                        </h3>
                        <p class="mb-4 font-mono text-[11px] font-bold uppercase tracking-wider text-[#F97C30]">
                            <?php echo esc_html( $position ); ?>
                        </p>
                        <?php if ( $bio ) : ?>
                            <p class="text-sm leading-relaxed text-[#6B7280]">
                                <?php echo esc_html( $bio ); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Action Color Accent Bar -->
                    <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#F97C30] transition-all duration-500 group-hover:w-full"></div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
