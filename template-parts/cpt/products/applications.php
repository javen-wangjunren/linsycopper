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

$first_app = isset( $apps_data[0] ) && is_array( $apps_data[0] ) ? $apps_data[0] : null;
$first_title = $first_app['title'] ?? '';
$first_desc = $first_app['description'] ?? '';
$first_image = $first_app['image'] ?? '';
$fallback_image = $first_image ?: 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
$apps_var = 'LC_PRODUCT_APPS_' . (int) get_the_ID();
?>

<script>
window.<?php echo esc_attr( $apps_var ); ?> = <?php echo $apps_json; ?>;
</script>

<section id="applications" class="relative overflow-hidden bg-[#F8FAFC] pt-[96px] pb-[96px]">
	<div class="pointer-events-none absolute inset-0 opacity-[0.035] [background-image:radial-gradient(#0B3570_1px,transparent_1px)] [background-size:26px_26px]"></div>
	<div class="pointer-events-none absolute inset-0 opacity-[0.025] [background-image:repeating-linear-gradient(135deg,rgba(11,53,112,0.40)_0px,rgba(11,53,112,0.40)_1px,transparent_1px,transparent_52px)]"></div>
	<div class="mx-auto max-w-[1280px] px-4">
		
		<!-- Header -->
		<div class="mb-12 text-center">
			<h2 class="text-heading text-3xl font-bold md:text-4xl">
				<?php echo esc_html( $title ); ?>
			</h2>
			<?php if ( $subtitle ) : ?>
				<p class="mt-3 text-[#6B7280] max-w-2xl !mx-auto !text-center">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="relative" x-data="productApplicationsRail(window.<?php echo esc_attr( $apps_var ); ?>)" x-init="init()">
			<div class="relative">
				<div class="absolute left-0 right-0 top-[18px] h-px bg-[#0B3570]/15"></div>
				<div class="relative flex items-start gap-6 overflow-x-auto no-scrollbar pb-2 pt-1" x-ref="rail">
					<template x-for="(app, idx) in apps" :key="idx">
						<button type="button" class="lc-app-station" @click="goTo(idx)" :data-active="currentIndex === idx">
							<span class="lc-app-station-dot" aria-hidden="true"></span>
							<span class="font-mono text-[11px] text-[#0B3570]/70" x-text="String(idx + 1).padStart(2,'0')"></span>
							<span class="text-sm font-semibold text-[#111827]" x-text="app.title"></span>
						</button>
					</template>
				</div>
				<div class="mt-4 flex items-center justify-center gap-3">
					<button type="button" class="lc-app-nav-btn" @click="prev()" aria-label="Previous application">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
					</button>
					<div class="flex items-center gap-2">
						<template x-for="(app, idx) in apps" :key="idx">
							<button type="button" class="lc-app-dot" @click="goTo(idx)" :data-active="currentIndex === idx" :aria-label="`Go to application ${idx + 1}`"></button>
						</template>
					</div>
					<button type="button" class="lc-app-nav-btn" @click="next()" aria-label="Next application">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
					</button>
				</div>
			</div>

			<div class="mt-10 grid gap-8 lg:grid-cols-12 lg:items-start">
				<div class="lg:col-span-7">
					<div class="relative overflow-hidden rounded-sm border border-black/10 bg-[#0B3570] shadow-[0_22px_60px_rgba(16,24,40,0.14)] aspect-[4/3]">
						<img
							class="absolute inset-0 h-full w-full object-cover"
							src="<?php echo esc_url( $fallback_image ); ?>"
							alt="<?php echo esc_attr( $first_title ); ?>"
							:src="apps[currentIndex] && apps[currentIndex].image ? apps[currentIndex].image : <?php echo function_exists( 'wp_json_encode' ) ? wp_json_encode( $fallback_image ) : json_encode( $fallback_image ); ?>"
							:alt="apps[currentIndex] && apps[currentIndex].title ? apps[currentIndex].title : <?php echo function_exists( 'wp_json_encode' ) ? wp_json_encode( $first_title ) : json_encode( $first_title ); ?>"
						/>
						<div class="absolute inset-0 bg-gradient-to-tr from-black/35 via-black/5 to-transparent"></div>
					</div>
				</div>
				<div class="lg:col-span-5">
					<div class="border-l-2 border-[#F97C30] pl-6">
						<h3 class="text-heading text-2xl font-semibold tracking-tight text-[#111827] md:text-3xl" x-text="apps[currentIndex] ? apps[currentIndex].title : ''"><?php echo esc_html( $first_title ); ?></h3>
						<p class="mt-3 text-[15px] leading-relaxed text-[#4B5563]" x-text="apps[currentIndex] ? apps[currentIndex].description : ''"><?php echo esc_html( $first_desc ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
function productApplicationsRail(apps) {
	return {
		apps: apps || [],
		currentIndex: 0,

		init() {
			if (!this.apps || this.apps.length === 0) return;
			this.$nextTick(() => {
				this.goTo(0);
			});
		},

		goTo(index) {
			if (!this.apps || this.apps.length === 0) return;
			const max = this.apps.length - 1;
			let idx = Number(index || 0);
			if (idx < 0) idx = 0;
			if (idx > max) idx = max;
			this.currentIndex = idx;
			const rail = this.$refs.rail;
			if (rail) {
				const items = rail.querySelectorAll('.lc-app-station');
				const el = items && items[idx] ? items[idx] : null;
				if (el && el.scrollIntoView) {
					el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
				}
			}
		},

		next() {
			if (!this.apps || this.apps.length === 0) return;
			const nextIndex = this.currentIndex + 1 > (this.apps.length - 1) ? 0 : this.currentIndex + 1;
			this.goTo(nextIndex);
		},
		prev() {
			if (!this.apps || this.apps.length === 0) return;
			const prevIndex = this.currentIndex - 1 < 0 ? (this.apps.length - 1) : this.currentIndex - 1;
			this.goTo(prevIndex);
		},
	};
}
</script>
