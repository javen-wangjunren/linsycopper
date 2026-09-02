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
	$bg_image_sm_url = '';
	$bg_image_lg_url = '';
	if ( $bg_image_id ) {
		$url_sm = wp_get_attachment_image_url( $bg_image_id, 'medium_large' );
		$url_lg = wp_get_attachment_image_url( $bg_image_id, 'full' );
		if ( $url_sm ) {
			$bg_image_sm_url = $url_sm;
		}
		$url = $url_lg ? $url_lg : $url_sm;
		if ( $url ) {
			$bg_image_lg_url = $url;
		}
	}

	$title_raw = isset( $slide['industry_slide_title'] ) ? (string) $slide['industry_slide_title'] : '';
	$desc_raw  = isset( $slide['industry_description'] ) ? (string) $slide['industry_description'] : '';

	$title = trim( function_exists( 'wp_specialchars_decode' ) ? wp_specialchars_decode( $title_raw, ENT_QUOTES ) : html_entity_decode( $title_raw, ENT_QUOTES, 'UTF-8' ) );
	$desc  = trim( function_exists( 'wp_strip_all_tags' ) ? wp_strip_all_tags( html_entity_decode( $desc_raw, ENT_QUOTES, 'UTF-8' ) ) : strip_tags( html_entity_decode( $desc_raw, ENT_QUOTES, 'UTF-8' ) ) );

	$cta_label = isset( $slide['industry_slide_cta_label'] ) ? trim( (string) $slide['industry_slide_cta_label'] ) : '';
	$cta_link  = isset( $slide['industry_slide_cta_link'] ) && is_array( $slide['industry_slide_cta_link'] ) ? $slide['industry_slide_cta_link'] : null;
	$cta_url   = $cta_link && ! empty( $cta_link['url'] ) ? (string) $cta_link['url'] : '';
	$cta_target = $cta_link && ! empty( $cta_link['target'] ) ? (string) $cta_link['target'] : '_self';

	$normalized_slides[] = [
		'bg_sm' => $bg_image_sm_url,
		'bg_lg' => $bg_image_lg_url,
		'title' => $title,
		'desc' => $desc,
		'cta_label' => $cta_label !== '' ? $cta_label : 'Get a Specific Quote',
		'cta_url' => $cta_url,
		'cta_target' => $cta_target,
	];
}

if ( empty( $normalized_slides ) ) {
	return;
}

// JSON 仅保留背景图数据（供 Alpine.js 懒加载使用），文本内容已在 HTML 中服务端渲染
$bg_slides_json_data = [];
foreach ( $normalized_slides as $slide ) {
	$bg_slides_json_data[] = [
		'bg_sm' => $slide['bg_sm'],
		'bg_lg' => $slide['bg_lg'],
	];
}

$slides_json = function_exists( 'wp_json_encode' )
	? wp_json_encode( $bg_slides_json_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP )
	: json_encode( $bg_slides_json_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );

if ( ! is_string( $slides_json ) || $slides_json === '' ) {
	$slides_json = '[]';
}

$instance_var = 'LC_HOME_INDUSTRY_IMMERSIVE_' . uniqid();
?>

<script>
window.<?php echo esc_attr( $instance_var ); ?> = <?php echo $slides_json; ?>;
</script>

<section class="lc-home-industry-immersive relative flex w-full items-center overflow-hidden bg-[#0B3570]" x-data="lcHomeIndustryImmersive(window.<?php echo esc_attr( $instance_var ); ?>)" x-init="init()">
	<div class="absolute inset-0 overflow-hidden">
		<template x-for="(slide, idx) in slides" :key="idx">
			<div class="lc-home-industry-bg absolute inset-0" :style="(isVisible && idx === currentIndex && slide.bg_lg) ? { backgroundImage: 'url(' + ((isMobile && slide.bg_sm) ? slide.bg_sm : slide.bg_lg) + ')' } : {}" x-show="idx === currentIndex" x-transition.opacity.duration.700ms></div>
		</template>
	</div>
	<div class="lc-home-industry-overlay absolute inset-0 pointer-events-none"></div>

	<div class="relative z-10 mx-auto w-full max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="lc-home-industry-copy text-white" x-show="slides && slides.length">
			<?php foreach ( $normalized_slides as $idx => $slide ) : ?>
				<div class="lc-home-industry-slide" x-show="currentIndex === <?php echo (int) $idx; ?>" x-transition.opacity.duration.700ms<?php echo $idx > 0 ? ' style="display:none;"' : ''; ?>>
					<h3 class="text-heading lc-home-industry-title"><?php echo esc_html( $slide['title'] ); ?></h3>

					<p class="lc-body-section lc-home-industry-desc"><?php echo esc_html( $slide['desc'] ); ?></p>

					<div class="lc-home-industry-actions flex flex-col sm:flex-row gap-4">
						<a class="lc-home-industry-btn" href="<?php echo $slide['cta_url'] ? esc_url( $slide['cta_url'] ) : '#'; ?>"<?php echo $slide['cta_target'] && $slide['cta_target'] !== '_self' ? ' target="' . esc_attr( $slide['cta_target'] ) . '"' : ''; ?>>
							<span><?php echo esc_html( $slide['cta_label'] ); ?></span>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
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
		isMobile: false,
		isVisible: false,
		mediaQuery: null,
		observer: null,

		init() {
			if (!this.slides.length) return;
			if (window.matchMedia) {
				const mq = window.matchMedia('(max-width: 767px)');
				this.mediaQuery = mq;
				const apply = () => {
					this.isMobile = mq.matches;
				};
				apply();
				if (mq.addEventListener) {
					mq.addEventListener('change', apply);
				} else if (mq.addListener) {
					mq.addListener(apply);
				}
			}

			const activate = () => {
				if (this.isVisible) return;
				this.isVisible = true;
				this.start();
			};

			if ('IntersectionObserver' in window) {
				this.observer = new IntersectionObserver((entries) => {
					entries.forEach((entry) => {
						if (!entry.isIntersecting) return;
						activate();
						if (this.observer) {
							this.observer.disconnect();
							this.observer = null;
						}
					});
				}, { rootMargin: '240px 0px' });

				this.observer.observe(this.$el);
			} else {
				activate();
			}

			this.$el.addEventListener('mouseenter', () => this.stop());
			this.$el.addEventListener('mouseleave', () => {
				if (this.isVisible) this.start();
			});
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
