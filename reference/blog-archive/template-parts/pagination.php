<?php
/**
 * Template part for displaying the blog archive pagination.
 */

if ( have_posts() ) : ?>
	<div class="flex justify-center border-t border-border pt-12">
		<div class="flex gap-2">
			<?php
			// Custom Pagination to match Tailwind styles
			echo paginate_links( array(
				'prev_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>',
				'next_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>',
				'before_page_number' => '<span class="flex items-center justify-center w-10 h-10 rounded-lg border border-border text-body font-mono text-sm hover:border-primary hover:text-primary transition-colors bg-white">',
				'after_page_number'  => '</span>',
			) );
			?>
		</div>
	</div>
<?php endif; ?>
