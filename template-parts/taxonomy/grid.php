<?php
/**
 * Taxonomy Archive: Product Grid
 * ==========================================================================
 * Location: template-parts/taxonomy/grid.php
 * 
 * Logic:
 * 1. Iterates through the Main Query (controlled by inc/query-filters.php).
 * 2. Collects current page's products for rendering.
 * 3. Renders Product Cards.
 * 4. Displays Pagination.
 * 
 * @package GeneratePress_Child
 */

// Prepare product array for rendering.
$products = array();

// Iterate Main Query
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		$pid = get_the_ID();
		
		// Clone the product data for rendering after the loop.
		$p_data = array(
			'id'        => $pid,
			'title'     => get_the_title(),
			'permalink' => get_permalink(),
			'thumb_id'  => linsy_get_product_primary_image_id( $pid ),
		);

		$products[] = $p_data;
	}
	// Do not wp_reset_postdata() here as we are in the main loop
}

/**
 * Helper to render a product card (Closure)
 */
$render_card_html = function( $product ) {
	?>
	<article class="group flex flex-col bg-white border border-gray-100 shadow-sm transition hover:shadow-md hover:border-gray-200">
		<!-- Image Aspect Ratio 1:1 (Square) -->
		<a href="<?php echo esc_url( $product['permalink'] ); ?>" class="relative block w-full aspect-square overflow-hidden bg-gray-50">
			<?php if ( $product['thumb_id'] ) : ?>
				<?php echo wp_get_attachment_image( $product['thumb_id'], 'medium_large', false, array( 'class' => 'absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105' ) ); ?>
			<?php else : ?>
				<div class="flex h-full items-center justify-center text-gray-300">
					<span class="text-xs">No Image</span>
				</div>
			<?php endif; ?>
			
			<!-- Hover Overlay -->
			<div class="absolute inset-0 bg-black/0 transition group-hover:bg-black/5"></div>
		</a>

		<!-- Content -->
		<div class="lc-taxonomy-card-body flex flex-1 flex-col px-4 py-3 text-center sm:p-6">
			<h3 class="lc-taxonomy-card-title mb-0 font-semibold uppercase tracking-wide text-[#0B3570] text-heading sm:mb-4 sm:text-base">
				<a href="<?php echo esc_url( $product['permalink'] ); ?>">
					<?php echo esc_html( $product['title'] ); ?>
				</a>
			</h3>
			
			<div class="mt-auto hidden sm:block">
				<!-- Copper UI: Micro-Radius (rounded-sm) -->
				<a href="<?php echo esc_url( $product['permalink'] ); ?>" class="lc-btn-primary px-6 py-3 text-[10px] font-bold uppercase tracking-wider transition rounded-sm">
					View Specs
				</a>
			</div>
		</div>
	</article>
	<?php
};

// If no posts found
if ( empty( $products ) ) :
	?>
	<div class="py-12 text-center text-gray-500">
		<p>No products found in this category.</p>
	</div>
	<?php
else :
?>
<div class="flex-1">
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 sm:gap-8 lg:grid-cols-3">
        <?php foreach ( $products as $product ) { $render_card_html( $product ); } ?>
    </div>

    <!-- Pagination -->
    <div class="mt-16 border-t border-gray-100 pt-12 flex justify-center">
        <?php
        echo paginate_links( array(
            'prev_text' => '<span class="text-xs font-bold uppercase tracking-wider">Previous</span>',
            'next_text' => '<span class="text-xs font-bold uppercase tracking-wider">Next</span>',
            'before_page_number' => '<span class="sr-only">Page </span>',
            'class'     => 'flex gap-2',
        ) );
        ?>
    </div>
    
    <!-- Pagination Styling Injection (Tailwind Support) -->
    <style>
        .page-numbers {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            min-width: 40px;
            padding: 0 1rem;
            border: 1px solid #E5E7EB;
            color: #374151;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 2px; /* rounded-sm */
        }
        .page-numbers:hover {
            border-color: #0B3570;
            color: #0B3570;
            background-color: #F9FAFB;
        }
        .page-numbers.current {
            background-color: #0B3570;
            border-color: #0B3570;
            color: #ffffff;
            font-weight: bold;
        }
        .page-numbers.dots {
            border: none;
            background: transparent;
        }
    </style>

</div>

<?php endif; ?>
