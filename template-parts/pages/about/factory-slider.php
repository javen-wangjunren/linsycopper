<?php
/**
 * Template Part: About - Factory Slider
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = get_flat_field( 'factory_slider_title', [], 'Factory and workshop environment' );
$gallery_ids = get_flat_field( 'factory_slider_images', [], [] );

$slides = array();

if ( is_array( $gallery_ids ) ) {
	foreach ( $gallery_ids as $image_id ) {
		$image_id = (int) $image_id;
		if ( ! $image_id ) {
			continue;
		}

		$image_url = wp_get_attachment_image_url( $image_id, 'large' );
		if ( ! $image_url ) {
			continue;
		}

		$slides[] = array(
			'url' => $image_url,
		);
	}
}

if ( empty( $slides ) ) {
	$slides = array(
		array(
			'url' => 'https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=industrial%20copper%20coil%20slitting%20line%2C%20large%20metal%20processing%20equipment%2C%20clean%20factory%20interior%2C%20organized%20production%20floor%2C%20cool%20steel%20and%20copper%20tones%2C%20realistic%20photography%2C%20wide%20composition&image_size=landscape_4_3',
		),
		array(
			'url' => 'https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=precision%20copper%20sheet%20processing%20equipment%2C%20bright%20industrial%20workshop%2C%20flatness%20control%20line%2C%20modern%20manufacturing%20machines%2C%20clean%20technical%20environment%2C%20realistic%20photography&image_size=landscape_4_3',
		),
		array(
			'url' => 'https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=large%20copper%20processing%20factory%20interior%2C%20multiple%20industrial%20machines%2C%20organized%20aisles%2C%20high%20ceiling%20production%20hall%2C%20copper%20metal%20materials%2C%20realistic%20industrial%20photography&image_size=landscape_4_3',
		),
		array(
			'url' => 'https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=industrial%20quality%20inspection%20station%20for%20copper%20materials%2C%20precision%20measurement%20equipment%2C%20clean%20factory%20inspection%20area%2C%20technical%20manufacturing%20photography&image_size=landscape_4_3',
		),
		array(
			'url' => 'https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=industrial%20copper%20material%20packing%20and%20warehouse%20area%2C%20organized%20export%20preparation%2C%20metal%20coils%20and%20sheets%2C%20realistic%20factory%20logistics%20photography&image_size=landscape_4_3',
		),
	);
}

$slides_hash_source = function_exists( 'wp_json_encode' ) ? wp_json_encode( $slides ) : json_encode( $slides );
$section_uid = 'lc-about-factory-slider-' . substr( md5( is_string( $slides_hash_source ) ? $slides_hash_source : '' ), 0, 8 );
$section_root_id = $section_uid . '-section';
$slide_count = count( $slides );
?>

<section id="<?php echo esc_attr( $section_root_id ); ?>" class="lc-about-factory-slider relative overflow-hidden border-t border-[#0B3570]/6 bg-[#FCFDFE] pt-[84px] pb-20">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="mb-9 text-center">
			<div class="mx-auto max-w-[760px]">
				<h2 class="text-3xl font-bold leading-tight tracking-tight text-heading md:text-4xl lg:text-[42px]">
					<?php echo esc_html( $title ); ?>
				</h2>
			</div>
		</div>

		<div class="lc-about-factory-slider__nav mb-4 flex items-center justify-end gap-3">
			<button type="button" class="lc-btn-reset lc-about-factory-prev lc-about-factory-slider__nav-btn flex h-11 w-11 items-center justify-center rounded-sm border border-[#0B3570]/14 bg-white text-[#0B3570] transition-colors hover:border-[#F97C30]/50 hover:text-[#F97C30]" aria-label="Previous slide">
				<svg xmlns="http://www.w3.org/2000/svg" class="lc-about-factory-slider__nav-icon h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M15 18l-6-6 6-6"></path>
				</svg>
			</button>
			<button type="button" class="lc-btn-reset lc-about-factory-next lc-about-factory-slider__nav-btn flex h-11 w-11 items-center justify-center rounded-sm border border-[#0B3570]/14 bg-white text-[#0B3570] transition-colors hover:border-[#F97C30]/50 hover:text-[#F97C30]" aria-label="Next slide">
				<svg xmlns="http://www.w3.org/2000/svg" class="lc-about-factory-slider__nav-icon h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M9 18l6-6-6-6"></path>
				</svg>
			</button>
		</div>
	</div>

	<div class="relative left-1/2 w-screen -translate-x-1/2 overflow-hidden">
		<div id="<?php echo esc_attr( $section_uid ); ?>" class="swiper lc-factory-swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide ) : ?>
					<article class="swiper-slide">
						<figure class="overflow-hidden">
							<div class="relative aspect-4/3 overflow-hidden">
								<img src="<?php echo esc_url( $slide['url'] ); ?>" alt="" class="h-full w-full object-cover" loading="lazy" />
							</div>
						</figure>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<script>
	(function() {
		const rootId = '<?php echo esc_attr( $section_uid ); ?>';
		const slideCount = <?php echo (int) $slide_count; ?>;

		const init = () => {
			const root = document.getElementById(rootId);
			if (!root || !window.Swiper) return false;
			if (root.dataset.swiperInit === '1') return true;

			root.dataset.swiperInit = '1';

			const section = document.getElementById('<?php echo esc_attr( $section_root_id ); ?>');

			new Swiper(root, {
				loop: false,
				rewind: true,
				centeredSlides: false,
				watchSlidesProgress: true,
				speed: 720,
				spaceBetween: 20,
				slidesPerView: 1.08,
				autoplay: slideCount > 1 ? {
					delay: 4200,
					disableOnInteraction: false,
					pauseOnMouseEnter: true,
				} : false,
				navigation: {
					nextEl: section ? section.querySelector('.lc-about-factory-next') : null,
					prevEl: section ? section.querySelector('.lc-about-factory-prev') : null,
				},
				breakpoints: {
					640: {
						slidesPerView: 1.6,
						spaceBetween: 22,
					},
					1024: {
						slidesPerView: 3.1,
						spaceBetween: 24,
					},
					1280: {
						slidesPerView: 4.1,
						spaceBetween: 14,
					},
				},
			});

			return true;
		};

		if (init()) return;

		window.addEventListener('load', () => {
			if (init()) return;

			let tries = 0;
			const timer = setInterval(() => {
				tries += 1;
				if (init() || tries >= 20) {
					clearInterval(timer);
				}
			}, 250);
		});
	})();
</script>
