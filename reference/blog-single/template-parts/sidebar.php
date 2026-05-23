<?php
/**
 * Template Part: Single Blog Sidebar
 * Location: template-parts/single-blog/sidebar.php
 */

// Get content (supports both Standard and Builder modes) for TOC generation
$content = _3dp_get_builder_content( get_the_ID() );
// We don't need to apply 'the_content' filter here for TOC because 
// _3dp_get_post_toc parses raw H2 tags and generates IDs identically to the frontend filter.
$toc     = _3dp_get_post_toc( $content );
?>

<aside class="lg:col-span-4 space-y-10 relative">
	
	<!-- Top Author Card (Scrolls away) -->
	<div id="sidebar-author-card">
		<?php get_template_part( 'blocks/global/author-profile/render' ); ?>
	</div>

	<!-- Sticky Container: TOC + CTA -->
	<div class="lg:sticky lg:top-10 space-y-10">
		
		<!-- Table of Contents -->
		<?php if ( ! empty( $toc ) ) : ?>
			<div class="border border-border rounded-card p-6 bg-panel">
				<div class="flex items-center justify-between mb-6">
					<div class="font-mono text-[11px] tracking-wider text-body/70 uppercase">Table Of Contents</div>
					<div class="font-mono text-[11px] tracking-wider text-body/70"><?php echo count( $toc ); ?></div>
				</div>
				<nav class="space-y-2">
					<?php foreach ( $toc as $index => $item ) : ?>
						<a href="#<?php echo esc_attr( $item['id'] ); ?>" 
						   class="flex items-center justify-between gap-4 py-2 px-3 rounded-button hover:bg-white transition-colors group">
							<span class="text-[13px] font-semibold text-heading group-hover:text-primary transition-colors">
								<?php echo esc_html( $item['title'] ); ?>
							</span>
							<span class="font-mono text-[11px] text-body/70">
								<?php echo str_pad( $index + 1, 2, '0', STR_PAD_LEFT ); ?>
							</span>
						</a>
					<?php endforeach; ?>
				</nav>
			</div>
		<?php endif; ?>

		<!-- Blog CTA (Global Module) -->
		<?php get_template_part( 'blocks/global/blog-cta/render' ); ?>
		
	</div>

</aside>
