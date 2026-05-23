<?php
/**
 * Block: Author Profile (Single Blog Sidebar)
 * Location: blocks/global/author-profile/render.php
 * 
 * Logic:
 * 1. Get current post author ID.
 * 2. Fetch User Meta (Avatar, Name, Job Title, LinkedIn, Bio).
 * 3. Render industrial style card.
 */

// 1. Get Context (Current Post Author)
$block = ( isset( $block ) && is_array( $block ) ) ? $block : array();
$variant = isset( $block['variant'] ) ? (string) $block['variant'] : 'sidebar';

$author_id = get_the_author_meta( 'ID' );
if ( ! $author_id ) {
	return; // No author found
}

// 2. Fetch Data
$avatar_id  = get_field( 'user_profile_picture', 'user_' . $author_id );
$avatar_url = $avatar_id ? wp_get_attachment_image_url( $avatar_id, 'medium' ) : '';
$avatar_url = $avatar_url ?: get_avatar_url( $author_id, array( 'size' => 200 ) );
$name       = get_the_author_meta( 'display_name', $author_id );
$bio        = get_field( 'user_bio', 'user_' . $author_id );
$bio        = $bio ?: get_the_author_meta( 'description', $author_id );
$job_title  = get_field( 'user_job_title', 'user_' . $author_id ) ?: 'Contributor'; // Fallback
$linkedin   = get_field( 'user_linkedin', 'user_' . $author_id );

?>

<?php if ( $variant === 'footer' ) : ?>
<div class="border border-border rounded-card p-6 lg:p-8 bg-white">
	<div class="flex flex-col sm:flex-row gap-5 sm:items-start">
		<div class="w-14 h-14 rounded-full overflow-hidden border border-border bg-bg-section shrink-0">
			<img loading="lazy" src="<?php echo esc_url( $avatar_url ); ?>" class="w-full h-full object-cover" alt="<?php echo esc_attr( $name ); ?>" sizes="(min-width: 1024px) 800px, 100vw">		</div>
		<div class="min-w-0 flex-1">
			<div class="flex items-center justify-between gap-4">
				<div>
					<div class="text-[16px] font-bold tracking-tight text-heading"><?php echo esc_html( $name ); ?></div>
					<?php if ( $job_title ) : ?>
						<div class="font-mono text-[11px] tracking-wider text-primary uppercase mt-0.5"><?php echo esc_html( $job_title ); ?></div>
					<?php endif; ?>
				</div>
				<?php if ( $linkedin ) : ?>
					<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-2 rounded-button border border-border hover:border-primary text-[12px] font-mono font-bold tracking-wider text-heading hover:text-primary transition-colors" aria-label="<?php echo esc_attr( $name ); ?> LinkedIn">
						<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
						LinkedIn
					</a>
				<?php endif; ?>
			</div>
			<?php if ( $bio ) : ?>
				<p class="mt-4 text-body leading-relaxed text-[14px]"><?php echo wp_kses_post( $bio ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php return; endif; ?>

<div class="border border-border rounded-card p-6 bg-white">
	<div class="flex items-center justify-between gap-4 mb-6">
		<div class="font-mono text-[11px] tracking-wider text-body/70 uppercase">Author</div>
		
		<?php if ( $linkedin ) : ?>
			<div class="flex items-center gap-2">
				<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" 
				   class="w-9 h-9 rounded-button border border-border hover:border-primary flex items-center justify-center text-body hover:text-primary transition-colors" 
				   aria-label="<?php echo esc_attr( $name ); ?> LinkedIn">
					<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
				</a>
			</div>
		<?php endif; ?>
	</div>

	<div class="flex items-start gap-4">
		<div class="w-14 h-14 rounded-full overflow-hidden border border-border bg-bg-section shrink-0">
			<img loading="lazy" src="<?php echo esc_url( $avatar_url ); ?>" class="w-full h-full object-cover" alt="<?php echo esc_attr( $name ); ?>" sizes="(min-width: 1024px) 800px, 100vw">		</div>
		<div class="min-w-0">
			<div class="text-[16px] font-bold tracking-tight text-heading">
				<?php echo esc_html( $name ); ?>
			</div>
			<?php if ( $job_title ) : ?>
				<div class="font-mono text-[11px] tracking-wider text-primary uppercase mt-0.5">
					<?php echo esc_html( $job_title ); ?>
				</div>
			<?php endif; ?>
			
			<?php if ( $bio ) : ?>
				<p class="mt-3 text-[13px] text-body leading-relaxed line-clamp-4">
					<?php echo wp_kses_post( $bio ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
