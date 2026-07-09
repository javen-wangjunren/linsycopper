<?php
/**
 * Product Hero Block Template
 * 
 * Logic:
 * 1. Data Retrieval: Uses get_flat_field() with full field names.
 * 2. Fallbacks: Smart defaults for title (Post Title) and gallery (Featured Image).
 * 3. Layout: Two-column responsive grid (Image Gallery | Product Info).
 * 4. Interactivity: Alpine.js for Image Slider and Zoom.
 * 
 * @package GeneratePress_Child
 */

// 1. Init (Data Retrieval)
$post_id = get_the_ID();

// Basic Info
$title = get_the_title(); // Product title always comes from WP core
$desc  = get_flat_field( 'product_hero_desc' );

// Gallery Logic
$gallery_ids = get_flat_field( 'product_hero_gallery' );
if ( empty( $gallery_ids ) && has_post_thumbnail() ) {
	$gallery_ids = array( get_post_thumbnail_id() );
}

// Specs & Business Data
$specs    = get_flat_field( 'product_hero_specs' ); // Repeater
$biz_data = get_flat_field( 'product_hero_business_data' ); // Repeater

// Actions
$quote_text     = get_flat_field( 'product_hero_quote_text' ) ?: 'Get A Quote';
$quote_link     = get_flat_field( 'product_hero_quote_link' ) ?: '/contact';
$datasheet_text = get_flat_field( 'product_hero_datasheet_text' ) ?: 'Download Datasheet';
$datasheet_file = get_flat_field( 'product_hero_datasheet_file' );

// 2. Preprocess (Data Handling)
// Prepare images for Alpine.js
$js_images = array();
if ( ! empty( $gallery_ids ) ) {
	foreach ( $gallery_ids as $img_id ) {
		$full_src = wp_get_attachment_image_src( $img_id, 'full' );
		$thumb_src = wp_get_attachment_image_src( $img_id, 'thumbnail' );
		if ( $full_src ) {
			$js_images[] = array(
				'full' => $full_src[0],
				'thumb' => $thumb_src ? $thumb_src[0] : $full_src[0],
			);
		}
	}
}

// Fallback if no images found
if ( empty( $js_images ) ) {
	// Use a transparent pixel or a placeholder service if local file is missing
	// Data URI for a light gray placeholder 1x1 pixel to prevent broken image icon
	$placeholder_data_uri = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAwIiBoZWlnaHQ9IjgwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWlkWU1pZCBzbGljZSI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2YzZjRZjYiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9InNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMjQiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM5YzlzOTQiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==';
	
	$js_images[] = array(
		'full' => $placeholder_data_uri,
		'thumb' => $placeholder_data_uri,
	);
}
?>

<!-- 
	Copper UI: Vertical Rhythm 
	Rule: pt-[100px] enforced on main section
-->
<section class="lc-product-hero-scope bg-white border-b border-gray-200 pt-[100px] pb-16">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		
		<div class="grid gap-8 md:grid-cols-2 lg:gap-12" x-data="{ 
			selectedImage: 0, 
			images: <?php echo htmlspecialchars( json_encode( $js_images ), ENT_QUOTES, 'UTF-8' ); ?> 
		}">
			
			<!-- Left: Image Gallery -->
			<div class="flex flex-col gap-4 md:flex-row">
				<!-- Main Image -->
				<div class="order-1 relative flex-1 aspect-square overflow-hidden rounded-sm bg-gray-100 group md:order-2">
					<img 
						:src="images[selectedImage].full" 
						class="absolute inset-0 !h-full !w-full !object-cover !block transition-transform duration-500 group-hover:scale-110" 
						alt="<?php echo esc_attr( $title ); ?>"
					>
					<!-- Zoom Hint (Optional) -->
					<div class="absolute top-4 right-4 p-2 rounded-sm bg-white/90 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
						<svg class="w-5 h-5 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
					</div>
				</div>

				<!-- Thumbnail Column -->
				<div class="order-2 flex gap-2 overflow-x-auto pb-1 md:order-1 md:flex-col md:overflow-visible md:pb-0">
					<template x-for="(img, index) in images" :key="index">
						<button
							@click="selectedImage = index"
							class="h-16 w-16 !p-0 rounded-sm overflow-hidden border transition-all flex-shrink-0 bg-white md:h-20 md:w-20"
							:class="selectedImage === index ? 'border-action-copper ring-1 ring-action-copper/20' : 'border-gray-200 hover:border-action-copper/50'"
						>
							<img :src="img.thumb" class="!w-full !h-full !object-cover !block" alt="Thumbnail">
						</button>
					</template>
				</div>
			</div>

			<!-- Right: Product Info -->
			<div class="flex flex-col space-y-8">
				
				<!-- 1. Title -->
				<div>
					<?php if ( function_exists( 'linsy_render_product_breadcrumbs' ) ) : ?>
						<?php linsy_render_product_breadcrumbs( $post_id ); ?>
					<?php endif; ?>

					<h1 class="lc-h1-product">
						<?php echo esc_html( $title ); ?>
					</h1>
				</div>

				<!-- 2. Key Specs (The 3 Boxes) -->
				<?php if ( ! empty( $specs ) ) : ?>
				<div class="lc-product-hero-specs grid grid-cols-3 gap-0 border border-gray-200 rounded-sm bg-gray-50/50 divide-x divide-gray-200">
					<?php foreach ( $specs as $spec ) : ?>
						<div class="lc-product-hero-spec-item min-w-0 p-4 text-center">
							<!-- Copper UI: Font Logic - Technical Data uses font-mono -->
							<div class="lc-mono-value lc-product-hero-spec-value text-xl text-primary-blue">
								<?php echo esc_html( $spec['value'] ); ?>
							</div>
							<div class="lc-product-hero-spec-label mt-1">
								<?php echo esc_html( $spec['label'] ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<!-- 3. Short Description -->
				<?php if ( $desc ) : ?>
				<div class="lc-product-hero-desc">
					<?php echo nl2br( esc_html( $desc ) ); ?>
				</div>
				<?php endif; ?>

				<!-- 4. CTA Buttons -->
				<div class="flex flex-col gap-3 sm:flex-row">
					<!-- Primary Action: Get Quote -->
					<a 
						href="<?php echo esc_url( $quote_link ); ?>" 
						class="lc-product-hero-cta-primary flex-1 inline-flex justify-center items-center px-6 py-3.5 rounded-sm"
					>
						<?php echo esc_html( $quote_text ); ?>
					</a>

					<!-- Secondary Action: Download Datasheet -->
					<?php if ( $datasheet_file ) : ?>
					<a 
						href="<?php echo esc_url( $datasheet_file ); ?>" 
						class="lc-product-hero-cta-secondary flex-1 inline-flex justify-center items-center px-6 py-3.5 rounded-sm group"
					>
						<svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
						<?php echo esc_html( $datasheet_text ); ?>
					</a>
					<?php endif; ?>
				</div>

				<!-- 5. Business Data (Bottom Table) -->
				<?php if ( ! empty( $biz_data ) ) : ?>
				<div class="pt-6 border-t border-gray-200 space-y-3 text-sm font-sans">
					<?php foreach ( $biz_data as $item ) : ?>
						<div class="flex justify-between items-center">
							<span class="text-gray-500"><?php echo esc_html( $item['label'] ); ?>:</span>
							<span class="<?php echo $item['is_highlight'] ? 'font-bold text-action-copper' : 'font-semibold text-gray-900'; ?>">
								<?php echo esc_html( $item['value'] ); ?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
