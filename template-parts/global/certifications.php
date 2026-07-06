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

$cert_items = array_values(
	array_filter(
		$certs,
		static function ( $cert ) {
			return ! empty( $cert['cert_image'] );
		}
	)
);

if ( empty( $cert_items ) ) {
	return;
}

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
		<div class="grid grid-cols-2 gap-4 md:gap-6 xl:grid-cols-4">
			<?php foreach ( $cert_items as $cert ) : ?>
				<?php
				$image_id = isset( $cert['cert_image'] ) ? (int) $cert['cert_image'] : 0;
				?>
				<div class="lc-cert-card aspect-[3/4] rounded-sm bg-white border border-black/10 shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-[#F97C30]">
					<div class="flex w-full h-full p-0 items-center justify-center">
						<?php
						$img_attrs = array(
							'class' => 'w-full h-full object-contain',
							'loading' => 'lazy',
							'decoding' => 'async',
							'fetchpriority' => 'low',
						);
						echo wp_get_attachment_image( $image_id, 'large', false, $img_attrs );
						?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
