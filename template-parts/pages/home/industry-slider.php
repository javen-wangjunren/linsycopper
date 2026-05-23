<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slides  = get_flat_field( 'industry_slides', [], [] );

if ( empty( $slides ) || ! is_array( $slides ) ) {
	return;
}

$normalized_slides = [];
foreach ( $slides as $slide ) {
	if ( ! is_array( $slide ) ) {
		continue;
	}

	$bg_image_id = isset( $slide['industry_slide_bg_image'] ) ? (int) $slide['industry_slide_bg_image'] : 0;
	$bg_image_url = '';
	if ( $bg_image_id ) {
		$url = wp_get_attachment_image_url( $bg_image_id, 'full' );
		if ( $url ) {
			$bg_image_url = $url;
		}
	}

	$kicker = isset( $slide['industry_slide_kicker'] ) ? (string) $slide['industry_slide_kicker'] : '';
	$title_raw = isset( $slide['industry_slide_title'] ) ? (string) $slide['industry_slide_title'] : '';
	$desc_raw  = isset( $slide['industry_description'] ) ? (string) $slide['industry_description'] : '';

	$title = trim( function_exists( 'wp_specialchars_decode' ) ? wp_specialchars_decode( $title_raw, ENT_QUOTES ) : html_entity_decode( $title_raw, ENT_QUOTES, 'UTF-8' ) );
	$desc  = trim( function_exists( 'wp_strip_all_tags' ) ? wp_strip_all_tags( html_entity_decode( $desc_raw, ENT_QUOTES, 'UTF-8' ) ) : strip_tags( html_entity_decode( $desc_raw, ENT_QUOTES, 'UTF-8' ) ) );

	$metrics_in = isset( $slide['industry_slide_metrics'] ) && is_array( $slide['industry_slide_metrics'] ) ? $slide['industry_slide_metrics'] : [];
	$metrics = [];
	foreach ( $metrics_in as $m ) {
		if ( ! is_array( $m ) ) {
			continue;
		}
		$label = isset( $m['industry_slide_metric_label'] ) ? trim( (string) $m['industry_slide_metric_label'] ) : '';
		$value_raw = isset( $m['industry_slide_metric_value'] ) ? (string) $m['industry_slide_metric_value'] : '';
		$value = trim( function_exists( 'wp_specialchars_decode' ) ? wp_specialchars_decode( $value_raw, ENT_QUOTES ) : html_entity_decode( $value_raw, ENT_QUOTES, 'UTF-8' ) );
		if ( $label === '' && $value === '' ) {
			continue;
		}
		$metrics[] = [
			'label' => $label,
			'value' => $value,
		];
	}

	$cta_label = isset( $slide['industry_slide_cta_label'] ) ? trim( (string) $slide['industry_slide_cta_label'] ) : '';
	$cta_link  = isset( $slide['industry_slide_cta_link'] ) && is_array( $slide['industry_slide_cta_link'] ) ? $slide['industry_slide_cta_link'] : null;
	$cta_url   = $cta_link && ! empty( $cta_link['url'] ) ? (string) $cta_link['url'] : '';
	$cta_target = $cta_link && ! empty( $cta_link['target'] ) ? (string) $cta_link['target'] : '_self';

	$normalized_slides[] = [
		'bg' => $bg_image_url,
		'kicker' => $kicker,
		'title' => $title,
		'desc' => $desc,
		'metrics' => $metrics,
		'cta_label' => $cta_label !== '' ? $cta_label : 'Get a Specific Quote',
		'cta_url' => $cta_url,
		'cta_target' => $cta_target,
	];
}

if ( empty( $normalized_slides ) ) {
	return;
}

$slides_json = function_exists( 'wp_json_encode' )
	? wp_json_encode( $normalized_slides, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP )
	: json_encode( $normalized_slides, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );

if ( ! is_string( $slides_json ) || $slides_json === '' ) {
	$slides_json = '[]';
}

$instance_var = 'LC_HOME_INDUSTRY_IMMERSIVE_' . uniqid();
?>

<script>
window.<?php echo esc_attr( $instance_var ); ?> = <?php echo $slides_json; ?>;
</script>

<section class="lc-home-industry-immersive relative flex w-full items-center overflow-hidden bg-[#0B3570] pt-[100px] pb-[100px] min-h-[850px] md:min-h-[750px]" x-data="lcHomeIndustryImmersive(window.<?php echo esc_attr( $instance_var ); ?>)" x-init="init()">
	<div class="absolute inset-0 overflow-hidden">
		<template x-for="(slide, idx) in slides" :key="idx">
			<div class="lc-home-industry-bg absolute inset-0" :style="slide.bg ? { backgroundImage: 'url(' + slide.bg + ')' } : {}" x-show="idx === currentIndex" x-transition.opacity.duration.700ms></div>
		</template>
	</div>
	<div class="absolute inset-0 bg-gradient-to-r from-[#0B3570] via-[#0B3570]/60 to-transparent pointer-events-none"></div>

	<div class="relative z-10 mx-auto w-full max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="max-w-2xl text-white" x-show="slides && slides.length">
			<div class="flex items-center gap-2 mb-6">
				<span class="lc-home-industry-kicker" x-text="slides[currentIndex] ? slides[currentIndex].kicker : ''"></span>
				<div class="h-px w-12 bg-white/30"></div>
			</div>

			<h3 class="text-heading lc-home-industry-title mb-6" x-text="slides[currentIndex] ? slides[currentIndex].title : ''"></h3>

			<p class="text-lg md:text-xl text-white/80 mb-10 leading-relaxed" x-text="slides[currentIndex] ? slides[currentIndex].desc : ''"></p>

			<div class="grid grid-cols-2 gap-8 mb-12 py-6 border-y border-white/10" x-show="slides[currentIndex] && slides[currentIndex].metrics && slides[currentIndex].metrics.length">
				<template x-for="(m, mi) in ((slides[currentIndex] && slides[currentIndex].metrics) ? slides[currentIndex].metrics.slice(0, 2) : [])" :key="mi">
					<div class="flex flex-col">
						<span class="font-mono text-[11px] text-white/55 mb-1" x-text="m.label"></span>
						<span class="font-mono text-2xl font-semibold text-[#F97C30]" x-text="m.value"></span>
					</div>
				</template>
			</div>

			<div class="flex flex-col sm:flex-row gap-4">
				<a class="lc-home-industry-btn group" :href="(slides[currentIndex] && slides[currentIndex].cta_url) ? slides[currentIndex].cta_url : '#'" :target="(slides[currentIndex] && slides[currentIndex].cta_target) ? slides[currentIndex].cta_target : '_self'">
					<span x-text="(slides[currentIndex] && slides[currentIndex].cta_label) ? slides[currentIndex].cta_label : 'Get a Specific Quote'"></span>
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
					</svg>
				</a>
			</div>
		</div>
	</div>

	<button type="button" class="lc-home-industry-nav lc-home-industry-nav--next hidden md:flex" @click="next()" aria-label="Next slide"></button>
	<button type="button" class="lc-home-industry-nav lc-home-industry-nav--prev hidden md:flex" @click="prev()" aria-label="Previous slide"></button>

	<div class="lc-home-industry-pagination">
		<template x-for="(slide, idx) in slides" :key="idx">
			<button type="button" class="lc-home-industry-bullet" :data-active="currentIndex === idx" @click="goTo(idx)" :aria-label="`Go to slide ${idx + 1}`"></button>
		</template>
	</div>
</section>

<script>
function lcHomeIndustryImmersive(slides) {
	return {
		slides: Array.isArray(slides) ? slides : [],
		currentIndex: 0,
		timer: null,

		init() {
			if (!this.slides.length) return;
			this.start();
			this.$el.addEventListener('mouseenter', () => this.stop());
			this.$el.addEventListener('mouseleave', () => this.start());
		},

		start() {
			this.stop();
			this.timer = setInterval(() => this.next(), 6000);
		},

		stop() {
			if (this.timer) clearInterval(this.timer);
			this.timer = null;
		},

		goTo(idx) {
			if (!this.slides.length) return;
			const max = this.slides.length - 1;
			let nextIdx = Number(idx || 0);
			if (nextIdx < 0) nextIdx = 0;
			if (nextIdx > max) nextIdx = max;
			this.currentIndex = nextIdx;
		},

		next() {
			if (!this.slides.length) return;
			this.currentIndex = (this.currentIndex + 1) % this.slides.length;
		},

		prev() {
			if (!this.slides.length) return;
			this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
		},
	};
}
</script>
