<?php
/**
 * Product Applications Block Template
 * ==========================================================================
 * 文件作用:
 * 展示产品应用案例 (Slider)
 * 
 * 核心逻辑:
 * 1. 数据源: ACF Repeater (Applications List)
 * 2. 分组逻辑: 将应用案例每 3 个一组 (Desktop) 或堆叠 (Mobile)
 * 3. 交互逻辑: Alpine.js 实现轮播 + 移动端手势滑动 (Touch Swipe)
 * 
 * 架构角色:
 * Product CPT 的标准模块之一，通常位于产品详情页中部。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

// 1. Get Fields
$title    = get_flat_field( 'product_application_title', [], 'Applications & Use Cases' );
$subtitle = get_flat_field( 'product_application_subtitle', [], 'Proven solutions across diverse industries.' );
$app_list = get_flat_field( 'product_application_list', [], [] );

if ( empty( $app_list ) || ! is_array( $app_list ) ) {
	return; 
}

$apps_data = [];
foreach ( $app_list as $item ) {
	$img_id = isset( $item['application_image'] ) ? (int) $item['application_image'] : 0;
	$name_raw = isset( $item['application_name'] ) ? (string) $item['application_name'] : '';
	$desc_raw = isset( $item['application_shortdesc'] ) ? (string) $item['application_shortdesc'] : '';

	$name = trim( function_exists( 'wp_specialchars_decode' ) ? wp_specialchars_decode( $name_raw, ENT_QUOTES ) : html_entity_decode( $name_raw, ENT_QUOTES, 'UTF-8' ) );
	$desc = trim( function_exists( 'wp_strip_all_tags' ) ? wp_strip_all_tags( html_entity_decode( $desc_raw, ENT_QUOTES, 'UTF-8' ) ) : strip_tags( html_entity_decode( $desc_raw, ENT_QUOTES, 'UTF-8' ) ) );

	if ( $name === '' ) {
		continue;
	}

	$image_url = '';
	if ( $img_id && function_exists( 'wp_get_attachment_image_url' ) ) {
		$url = wp_get_attachment_image_url( $img_id, 'large' );
		if ( $url ) {
			$image_url = $url;
		}
	}

	$apps_data[] = [
		'title' => $name,
		'description' => $desc,
		'image' => $image_url ? esc_url( $image_url ) : '',
	];
}

if ( empty( $apps_data ) ) {
	return;
}

$apps_json = function_exists( 'wp_json_encode' )
	? wp_json_encode( $apps_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP )
	: json_encode( $apps_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );

if ( ! is_string( $apps_json ) || $apps_json === '' ) {
	$apps_json = '[]';
}

$apps_var = 'LC_PRODUCT_APPS_' . (int) get_the_ID();
?>

<script>
window.<?php echo esc_attr( $apps_var ); ?> = <?php echo $apps_json; ?>;
</script>

<section id="applications" class="lc-product-applications bg-[#F8FAFC] pt-[100px] pb-16">
	<style>
	.lc-product-applications .lc-app-nav-btn{
		background:#fff;
		border:2px solid #0B3570;
		color:#0B3570;
		padding:8px;
		border-radius:9999px;
		box-shadow:0 10px 15px -3px rgba(0,0,0,.10),0 4px 6px -4px rgba(0,0,0,.10);
		transition:background-color .15s ease,color .15s ease,border-color .15s ease;
	}
	.lc-product-applications .lc-app-nav-btn:hover{
		background:#0B3570;
		color:#fff;
	}
	.lc-product-applications .lc-app-nav-btn:focus{
		outline:0;
	}
	.lc-product-applications .lc-app-nav-btn:focus-visible{
		box-shadow:0 0 0 2px rgba(11,53,112,.30),0 10px 15px -3px rgba(0,0,0,.10),0 4px 6px -4px rgba(0,0,0,.10);
	}
	.lc-product-applications .lc-app-dot{
		height:8px;
		width:8px;
		border-radius:9999px;
		background:#D1D5DB;
		padding:0;
		border:0;
		box-shadow:none;
		cursor:pointer;
		transition:width .15s ease,background-color .15s ease,border-radius .15s ease;
	}
	.lc-product-applications .lc-app-dot:hover{
		background:rgba(249,124,48,.30);
	}
	.lc-product-applications .lc-app-dot[data-active="true"]{
		width:32px;
		border-radius:2px;
		background:#F97C30;
	}
	.lc-product-applications .lc-app-dot[data-active="true"]:hover{
		background:#F97C30;
	}
	.lc-product-applications .lc-app-dot:focus{
		outline:0;
	}
	.lc-product-applications .lc-app-dot:focus-visible{
		box-shadow:0 0 0 2px rgba(11,53,112,.20);
	}
	</style>
	<div class="mx-auto max-w-[1280px] px-4">
		<div class="mb-12 text-center">
			<h2 class="text-heading text-3xl font-bold md:text-4xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<?php if ( $subtitle ) : ?>
				<p class="mt-3 max-w-2xl text-body !mx-auto !text-center">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="relative px-12" x-data="productApplicationsCarousel(window.<?php echo esc_attr( $apps_var ); ?>)" x-init="init()">
			<button
				type="button"
				class="lc-app-nav-btn absolute left-0 top-1/2 z-10 -translate-y-1/2"
				aria-label="Previous applications"
				@click="prevSlide(); if ($event.detail) $event.currentTarget.blur()"
				x-show="maxSlides > 1"
				x-cloak
			>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m15 18-6-6 6-6"/></svg>
			</button>
			<button
				type="button"
				class="lc-app-nav-btn absolute right-0 top-1/2 z-10 -translate-y-1/2"
				aria-label="Next applications"
				@click="nextSlide(); if ($event.detail) $event.currentTarget.blur()"
				x-show="maxSlides > 1"
				x-cloak
			>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m9 18 6-6-6-6"/></svg>
			</button>

			<div class="overflow-hidden">
				<div class="flex transition-transform duration-500 ease-out" :style="`transform: translateX(-${currentSlide * 100}%);`">
					<template x-for="(slide, slideIndex) in slides" :key="slideIndex">
						<div class="w-full flex-shrink-0">
							<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
								<template x-for="(app, idx) in slide" :key="idx">
									<div class="overflow-hidden rounded-sm border border-border bg-white transition-shadow hover:shadow-lg">
										<div class="relative aspect-[4/3] overflow-hidden">
											<template x-if="app.image">
												<img class="absolute inset-0 h-full w-full object-cover" :src="app.image" :alt="app.title || ''" />
											</template>
											<template x-if="!app.image">
												<div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-[#C87533]/20 to-[#B87333]/40">
													<span class="font-mono text-3xl font-bold text-white/30" x-text="(app.title || '').split(' ')[0]"></span>
												</div>
											</template>
											<div class="absolute inset-0 bg-gradient-to-b from-black/0 via-black/0 to-black/15" x-show="app.image" x-cloak></div>
										</div>
										<div class="p-6">
											<h3 class="text-lg font-bold text-[#111827] mb-2" x-text="app.title"></h3>
											<p class="text-sm leading-relaxed text-body" x-text="app.description"></p>
										</div>
									</div>
								</template>
							</div>
						</div>
					</template>
				</div>
			</div>

			<div class="mt-8 flex justify-center gap-2" x-show="maxSlides > 1" x-cloak>
				<template x-for="(slide, idx) in slides" :key="idx">
					<button
						type="button"
						class="lc-app-dot"
						:data-active="currentSlide === idx ? 'true' : 'false'"
						@click="goToSlide(idx); if ($event.detail) $event.currentTarget.blur()"
						:aria-label="`Go to slide ${idx + 1}`"
					></button>
				</template>
			</div>
		</div>
	</div>
</section>

<script>
function productApplicationsCarousel(apps) {
	return {
		apps: Array.isArray(apps) ? apps : [],
		slides: [],
		itemsPerSlide: 3,
		currentSlide: 0,
		mediaQuery: null,

		get maxSlides() {
			return Array.isArray(this.slides) ? this.slides.length : 0;
		},

		init() {
			if (!this.apps.length) return;

			if (!window.matchMedia) {
				this.itemsPerSlide = 3;
				this.buildSlides();
				return;
			}

			const mq = window.matchMedia('(min-width: 768px)');
			this.mediaQuery = mq;

			const apply = () => {
				this.itemsPerSlide = mq.matches ? 3 : 1;
				this.buildSlides();
				const max = this.maxSlides;
				if (this.currentSlide > max - 1) {
					this.currentSlide = Math.max(0, max - 1);
				}
			};

			apply();

			if (mq.addEventListener) {
				mq.addEventListener('change', apply);
			} else if (mq.addListener) {
				mq.addListener(apply);
			}
		},

		buildSlides() {
			const per = Math.max(1, Number(this.itemsPerSlide) || 1);
			const out = [];
			for (let i = 0; i < this.apps.length; i += per) {
				out.push(this.apps.slice(i, i + per));
			}
			this.slides = out;
		},

		goToSlide(index) {
			const max = this.maxSlides;
			if (max <= 1) return;
			let idx = Number(index || 0);
			if (idx < 0) idx = 0;
			if (idx > max - 1) idx = max - 1;
			this.currentSlide = idx;
		},

		nextSlide() {
			const max = this.maxSlides;
			if (max <= 1) return;
			this.currentSlide = (this.currentSlide + 1) % max;
		},

		prevSlide() {
			const max = this.maxSlides;
			if (max <= 1) return;
			this.currentSlide = (this.currentSlide - 1 + max) % max;
		},
	};
}
</script>
