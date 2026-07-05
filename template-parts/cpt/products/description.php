<?php
/**
 * Product Description Block Template
 * 
 * Logic:
 * 1. Overview: Title & WYSIWYG content.
 * 2. Features: 2-column grid list with check icons.
 * 
 * @package GeneratePress_Child
 */

// 1. Data Retrieval
$overview_title = get_flat_field( 'product_desc_title' ) ?: 'Product Overview';
$overview_content = get_flat_field( 'product_desc_content' );

$features_title = get_flat_field( 'product_desc_features_title' ) ?: 'Key Features';
$features = get_flat_field( 'product_desc_features' ); // Repeater

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

	</div>
</section>
