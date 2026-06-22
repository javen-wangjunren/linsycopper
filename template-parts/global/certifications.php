<?php
/**
 * Module: Certifications
 */

$title = linsy_get_option_field_compat(
    'cert_title',
    'global_certifications',
    'Quality Certifications'
);
$desc = linsy_get_option_field_compat(
    'cert_desc',
    'global_certifications',
    'Verified international standards for copper manufacturing and supply.'
);
$certs = linsy_get_option_field_compat(
    'cert_list',
    'global_certifications',
    []
);

if ( empty( $certs ) ) {
    return; // Don't render if no data
}

$certs_hash_source = function_exists( 'wp_json_encode' ) ? wp_json_encode( $certs ) : json_encode( $certs );
$section_uid = 'lc-certifications-' . substr( md5( is_string( $certs_hash_source ) ? $certs_hash_source : '' ), 0, 8 );
?>

<section class="lc-certifications w-full overflow-hidden pt-[100px] pb-[100px]">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8 mb-12">
		<div class="border-l-4 border-[#F97C30] pl-6">
			<h2 class="lc-h2-section text-[#0B3570]"><?php echo esc_html( $title ); ?></h2>
			<?php if ( $desc ) : ?>
				<p class="mt-3 max-w-2xl text-base leading-relaxed text-[#0B3570]/70"><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<div class="w-full px-4 sm:px-6 lg:px-12 xl:px-16 2xl:px-20">
		<div id="<?php echo esc_attr( $section_uid ); ?>" class="swiper lc-cert-swiper w-full overflow-visible">
			<div class="swiper-wrapper">
				<?php foreach ( $certs as $cert ) : ?>
					<?php
					$image_id = isset( $cert['cert_image'] ) ? (int) $cert['cert_image'] : 0;
					if ( ! $image_id ) {
						continue;
					}
					?>
					<div class="swiper-slide">
						<div class="lc-cert-card aspect-[3/4] rounded-sm bg-white border border-black/10 shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-[#F97C30]">
							<div class="flex w-full h-full p-0 items-center justify-center">
								<?php
								$img_attrs = array(
									'class' => 'w-full h-full object-contain',
									'loading' => 'lazy',
								);
								echo wp_get_attachment_image( $image_id, 'large', false, $img_attrs );
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-pagination"></div>
		</div>
	</div>
</section>

<script>
	(function() {
		const rootId = '<?php echo esc_attr( $section_uid ); ?>';

		const init = () => {
			const root = document.getElementById(rootId);
			if (!root || !window.Swiper) return false;
			if (root.dataset.swiperInit === '1') return true;

			root.dataset.swiperInit = '1';

			new Swiper(root, {
				slidesPerView: 1,
				spaceBetween: 20,
				loop: true,
				autoplay: { delay: 5000 },
				pagination: { el: root.querySelector('.swiper-pagination'), clickable: true },
				navigation: { nextEl: root.querySelector('.swiper-button-next'), prevEl: root.querySelector('.swiper-button-prev') },
				watchOverflow: true,
				grabCursor: true,
				breakpoints: {
					640: { slidesPerView: 2, spaceBetween: 24 },
					1024: { slidesPerView: 3, spaceBetween: 28 },
					1280: { slidesPerView: 4, spaceBetween: 32 }
				}
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
