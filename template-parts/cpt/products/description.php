<?php
/**
 * Product Description Block Template
 * 
 * Logic:
 * 1. Overview: Title & WYSIWYG content.
 * 2. Features: 2-column grid list with check icons.
 * 3. Size Matrix: Responsive table where Row 1 is THEAD.
 * 
 * @package GeneratePress_Child
 */

// 1. Data Retrieval
$overview_title = get_flat_field( 'product_desc_title' ) ?: 'Product Overview';
$overview_content = get_flat_field( 'product_desc_content' );

$features_title = get_flat_field( 'product_desc_features_title' ) ?: 'Key Features';
$features = get_flat_field( 'product_desc_features' ); // Repeater

$size_title = get_flat_field( 'product_desc_size_title' ) ?: 'Available Sizes';
$size_matrix = get_flat_field( 'product_desc_size_matrix' ); // Repeater (Row 1 = Header)

?>

<!-- ID used for Sticky Nav Scroll Spy -->
<section id="description" class="bg-white py-16 border-b border-gray-200">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		
		<!-- 1. Product Overview -->
		<div class="mb-12">
			<h2 class="lc-h2-section text-heading mb-6">
				<?php echo esc_html( $overview_title ); ?>
			</h2>
			<?php if ( $overview_content ) : ?>
			<div class="prose prose-lg max-w-none text-gray-600">
				<?php echo wp_kses_post( $overview_content ); ?>
			</div>
			<?php endif; ?>
		</div>

		<!-- 2. Key Features -->
		<?php if ( ! empty( $features ) ) : ?>
		<div class="mb-12 rounded-sm border border-gray-200 bg-gray-50/50 p-8">
			<h3 class="lc-h3-feature mb-6 text-primary-blue">
				<?php echo esc_html( $features_title ); ?>
			</h3>
			<div class="grid gap-4 sm:grid-cols-2">
				<?php foreach ( $features as $feature ) : ?>
					<?php if ( ! empty( $feature['text'] ) ) : ?>
					<div class="flex items-start gap-3">
						<!-- Icon: CheckCircle2 -->
						<svg class="w-5 h-5 text-action-copper flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
						<span class="lc-body-card text-gray-700 font-medium">
							<?php echo esc_html( $feature['text'] ); ?>
						</span>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- 3. Available Sizes Matrix -->
		<?php if ( ! empty( $size_matrix ) ) : ?>
		<div>
			<h3 class="lc-h3-feature mb-6 text-primary-blue">
				<?php echo esc_html( $size_title ); ?>
			</h3>
			<div class="overflow-x-auto rounded-sm border border-gray-200 shadow-sm">
				<table class="w-full text-left border-collapse !m-0">
					<!-- Logic: Row 1 is Header, Row 2+ is Body -->
					<?php 
					$header_row = array_shift( $size_matrix ); // Extract first row
					?>
					
					<!-- Table Header -->
					<?php if ( $header_row ) : ?>
					<thead class="bg-primary-blue text-white">
						<tr>
							<?php for( $i = 1; $i <= 5; $i++ ) : 
								$col_val = $header_row['col_' . $i];
								if ( ! empty( $col_val ) ) : 
							?>
								<th class="px-6 py-4 text-sm font-semibold whitespace-nowrap border-b border-primary-blue/20">
									<?php echo esc_html( $col_val ); ?>
								</th>
							<?php endif; endfor; ?>
						</tr>
					</thead>
					<?php endif; ?>

					<!-- Table Body -->
					<tbody class="divide-y divide-gray-200 bg-white">
						<?php foreach ( $size_matrix as $index => $row ) : ?>
						<tr class="<?php echo $index % 2 === 0 ? 'bg-white' : 'bg-gray-50'; ?> hover:bg-blue-50/30 transition-colors">
							<?php for( $i = 1; $i <= 5; $i++ ) : 
								// Check if corresponding header existed to keep alignment
								$header_val = $header_row['col_' . $i];
								if ( ! empty( $header_val ) ) :
									$cell_val = $row['col_' . $i];
							?>
								<td class="lc-mono-meta px-6 py-4 text-gray-700">
									<?php echo esc_html( $cell_val ); ?>
								</td>
							<?php endif; endfor; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="lc-body-card mt-4 italic text-gray-500">
				* Custom sizes available upon request. Contact our sales team for special requirements.
			</p>
		</div>
		<?php endif; ?>

	</div>
</section>
