<?php
/**
 * Template part for displaying the blog archive grid.
 */

// Check if we have posts
if ( have_posts() ) : ?>
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
		<?php
		while ( have_posts() ) :
			the_post();
			
			// Data Preparation
			$post_id    = get_the_ID();
			$categories = get_the_category();
			$cat_name   = ! empty( $categories ) ? $categories[0]->name : 'Article';
			$read_time  = '5 min read'; // Placeholder or calculate dynamically
			$img_url    = get_the_post_thumbnail_url( $post_id, 'medium_large' ); // Use featured image
			
			// Fallback Image
			if ( ! $img_url ) {
				$img_url = 'https://via.placeholder.com/800x600?text=No+Image';
			}
			?>
			
			<!-- Card Component -->
			<article class="group bg-white rounded-card border border-border overflow-hidden hover:border-primary transition-all duration-300 flex flex-col h-full hover:shadow-xl hover:shadow-primary/5 cursor-pointer transform hover:-translate-y-1">
				<a href="<?php the_permalink(); ?>" class="flex flex-col h-full">
					
					<!-- Image -->
					<div class="aspect-[16/10] overflow-hidden bg-bg-section relative">
						<img loading="lazy" src="<?php echo esc_url( $img_url ); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="<?php the_title_attribute(); ?>" sizes="(min-width: 1024px) 800px, 100vw">						<!-- Category Badge Overlay -->
						<div class="absolute top-4 left-4">
							<span class="bg-white/95 backdrop-blur shadow-sm text-heading px-3 py-1 rounded text-[10px] font-mono font-bold uppercase tracking-wide border border-border/50">
								<?php echo esc_html( $cat_name ); ?>
							</span>
						</div>
					</div>

					<!-- Content Body -->
					<div class="p-6 lg:p-8 flex flex-col flex-1">
						
						<!-- Meta Row -->
						<div class="flex items-center gap-3 mb-3 text-[11px] font-mono text-body border-b border-border/40 pb-3">
							<span><?php echo get_the_date( 'M j, Y' ); ?></span>
							<span class="w-1 h-1 rounded-full bg-border"></span>
							<span><?php echo esc_html( $read_time ); ?></span>
						</div>

						<!-- Title -->
						<h3 class="text-[20px] font-bold text-heading leading-tight mb-3 group-hover:text-primary transition-colors tracking-tight">
							<?php the_title(); ?>
						</h3>

						<!-- Excerpt -->
						<div class="text-sm text-body leading-relaxed mb-6 line-clamp-3">
							<?php the_excerpt(); ?>
						</div>
						
						<!-- Footer -->
						<div class="mt-auto flex items-center justify-between pt-4">
							<div class="flex items-center gap-2">
								<div class="w-6 h-6 rounded bg-bg-section flex items-center justify-center text-primary font-bold text-[10px] border border-border">FL</div>
								<span class="text-[11px] font-semibold text-body">Forge Labs</span>
							</div>
							
							<div class="w-8 h-8 rounded-full border border-border flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all duration-300">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
							</div>
						</div>
					</div>
				</a>
			</article>

		<?php endwhile; ?>
	</div>

<?php else : ?>
	<div class="text-center py-20">
		<h3 class="text-xl font-bold text-heading">No posts found</h3>
		<p class="text-body mt-2">Try adjusting your search or filter.</p>
	</div>
<?php endif; ?>
