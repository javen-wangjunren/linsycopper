<?php
/**
 * Template Part: Home Material Grid
 * 
 * Logic:
 * 1. Fetches ACF data (Title, Description, Selected Taxonomies).
 * 2. Loops through selected material categories.
 * 3. Pulls the "Hero Image" from each category's custom field.
 * 4. Renders a grid of cards linking to category archives.
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Init (Data Fetching)
// ==========================================
$headline    = get_flat_field( 'home_mat_title', [], 'Browse by Material Type' );
$terms       = get_flat_field( 'home_mat_items', [], [] );

// Fallback Data (if no terms selected, show nothing or placeholder?)
// For production, we usually hide if empty. For dev, maybe show placeholder.
if ( empty( $terms ) && current_user_can( 'manage_options' ) ) {
	// Debug mode: Show message if empty
	// echo '<!-- No materials selected in Home Material Grid -->';
}

?>

<!-- 
	View: Material Grid
	==========================================================================
-->
<section class="bg-white py-16 md:py-24">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		
		<!-- Section Header -->
		<div class="mb-12 text-center">
			<h2 class="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl text-heading">
				<?php echo esc_html( $headline ); ?>
			</h2>
		</div>

		<!-- Grid: Material Cards -->
		<?php if ( ! empty( $terms ) ) : ?>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<?php foreach ( $terms as $term ) : 
					// Data Preparation
					$term_link = get_term_link( $term );
					$term_name = $term->name;
					$image_id  = get_field( 'hero_image', $term ); // Taxonomy Field
					
					// Image Logic
					$img_url = 'https://via.placeholder.com/800x600?text=' . urlencode($term_name); // Fallback
					if ( $image_id ) {
						$src = wp_get_attachment_image_url( $image_id, 'medium_large' ); // Use reasonably sized image
						if ( $src ) $img_url = $src;
					}
				?>
					<a
						href="<?php echo esc_url( $term_link ); ?>"
						class="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg flex flex-col h-full"
					>
						<!-- Material Image -->
						<div class="relative w-full aspect-[4/3] overflow-hidden bg-[#F2F4F7]">
							<img
								src="<?php echo esc_url( $img_url ); ?>"
								alt="<?php echo esc_attr( $term_name ); ?>"
								class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
							/>
						</div>

						<!-- Material Info -->
						<div class="p-6 flex flex-col flex-grow text-center items-center">
							<p class="text-lg font-bold text-[#0B3570] mb-4 text-center">
								<?php echo esc_html( $term_name ); ?>
							</p>

							<!-- CTA Button -->
							<div class="mt-auto w-full bg-[#F2F4F7] text-[#0B3570] font-semibold py-2 px-4 rounded-sm transition-colors hover:bg-[#0B3570] hover:text-white group-hover:bg-[#0B3570] group-hover:text-white flex items-center justify-center gap-2">
								View Details
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
							</div>
						</div>

						<!-- Bottom Accent Bar -->
						<div class="h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full"></div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<!-- Empty State (Optional) -->
			<?php if ( current_user_can( 'edit_pages' ) ) : ?>
				<div class="text-center p-12 border-2 border-dashed border-gray-300 rounded-lg">
					<p class="text-gray-500">No materials selected. Please configure the "Home Material Grid" module in the page editor.</p>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>
</section>
