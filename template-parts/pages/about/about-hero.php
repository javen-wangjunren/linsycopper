<?php
/**
 * Template Part: About - Hero
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = get_flat_field(
	'about_hero_title',
	[],
	'A reliable copper materials partner built for industrial supply and precision service'
);
$intro = get_flat_field(
	'about_hero_intro',
	[],
	"Linsy Copper supports manufacturers, fabricators, and sourcing teams with stable copper material supply, responsive project communication, and processing coordination that fits real production timelines.\n\nFrom standard stock programs to custom-cut orders, we focus on consistency, traceability, and practical execution so industrial buyers can move faster with less uncertainty across procurement, engineering, and delivery."
);
$band_bg_id = (int) get_flat_field( 'about_hero_band_bg_image', [], 0 );
$advantages = get_flat_field( 'about_hero_advantages', [], [] );

if ( empty( $advantages ) || ! is_array( $advantages ) ) {
	$advantages = array(
		array(
			'item_number'      => '01',
			'item_title'       => 'Reliable material sourcing',
			'item_description' => 'Stable sourcing support for copper and alloy programs across repeat orders, specification updates, and project schedules.',
		),
		array(
			'item_number'      => '02',
			'item_title'       => 'Processing flexibility',
			'item_description' => 'Cut-to-size, packaging coordination, and order handling that reduce extra conversion steps for buyers and factories.',
		),
		array(
			'item_number'      => '03',
			'item_title'       => 'Traceable quality control',
			'item_description' => 'Material records, inspection alignment, and clearer batch communication help teams purchase with more confidence.',
		),
		array(
			'item_number'      => '04',
			'item_title'       => 'Responsive technical support',
			'item_description' => 'Faster quote discussion and practical spec review help bridge the gap between purchasing needs and production reality.',
		),
		array(
			'item_number'      => '05',
			'item_title'       => 'Global shipment readiness',
			'item_description' => 'Export-friendly packing and delivery coordination support international buyers who need steadier execution after order confirmation.',
		),
	);
}

$intro_paragraphs = preg_split( '/\R{2,}/', trim( (string) $intro ) );
$intro_paragraphs = array_values(
	array_filter(
		array_map( 'trim', is_array( $intro_paragraphs ) ? $intro_paragraphs : array() )
	)
);

if ( empty( $intro_paragraphs ) ) {
	$intro_paragraphs = array( (string) $intro );
}

$band_bg_url = $band_bg_id ? wp_get_attachment_image_url( $band_bg_id, 'full' ) : '';
?>

<section class="lc-about-hero relative overflow-hidden bg-white pt-[100px]">
	<div class="relative">
		<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
			<div class="grid gap-12 border-b border-[#0B3570]/10 pb-16 lg:grid-cols-2 lg:items-start lg:gap-16">
				<div class="max-w-[640px] border-l-4 border-[#F97C30] pl-6 lg:pr-8">
					<p class="mb-5 text-sm font-medium leading-6 text-[#0B3570]/70">
						About us
					</p>
					<h2 class="text-heading text-4xl font-bold leading-[0.98] tracking-tight md:text-5xl lg:text-[58px]">
						<?php echo esc_html( $title ); ?>
					</h2>
				</div>

				<div class="max-w-[620px] space-y-6 lg:justify-self-end">
					<?php foreach ( $intro_paragraphs as $paragraph ) : ?>
						<p class="lc-body-section md:text-lg">
							<?php echo esc_html( $paragraph ); ?>
						</p>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="relative overflow-hidden bg-[#0B3570]">
			<?php if ( $band_bg_url ) : ?>
				<div class="absolute inset-0">
					<img
						src="<?php echo esc_url( $band_bg_url ); ?>"
						alt=""
						aria-hidden="true"
						class="h-full w-full object-cover object-center opacity-[0.34]"
					/>
					<div class="absolute inset-0 bg-[#0B3570]/70"></div>
				</div>
			<?php endif; ?>

			<div class="relative mx-auto max-w-[1280px] px-4 py-10 sm:px-6 lg:px-8 lg:py-12">
				<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
					<?php foreach ( $advantages as $index => $item ) : ?>
						<?php
						$number = isset( $item['item_number'] ) && $item['item_number'] !== ''
							? (string) $item['item_number']
							: sprintf( '%02d', $index + 1 );
						$item_title = isset( $item['item_title'] ) ? (string) $item['item_title'] : '';
						$item_desc  = isset( $item['item_description'] ) ? (string) $item['item_description'] : '';

						if ( $item_title === '' && $item_desc === '' ) {
							continue;
						}
						?>
						<article class="bg-black/5 px-5 py-5 text-white">
							<div class="mb-3 font-mono text-4xl font-bold leading-none tracking-tight text-white md:text-[46px]">
								<?php echo esc_html( $number ); ?>
							</div>
							<h3 class="mb-2 text-lg font-semibold leading-snug text-white">
								<?php echo esc_html( $item_title ); ?>
							</h3>
							<?php if ( $item_desc ) : ?>
								<p class="text-sm leading-6 text-white/74">
									<?php echo esc_html( $item_desc ); ?>
								</p>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
