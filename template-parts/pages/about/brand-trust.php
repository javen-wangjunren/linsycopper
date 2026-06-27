<?php
/**
 * Template Part: About - Brand Trust
 *
 * Displays a static trust grid of manufacturer logos for the About page only.
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$brand_assets = array(
	array(
		'name' => 'ABB',
		'file' => 'ABB.svg',
	),
	array(
		'name' => 'Alfa Laval',
		'file' => 'AlfaLaval.svg',
	),
	array(
		'name' => 'Eaton Corporation',
		'file' => 'Eaton_Corporation.svg',
	),
	array(
		'name' => 'Emerson',
		'file' => 'Emerson.svg',
	),
	array(
		'name' => 'GE Vernova',
		'file' => 'GE_Vernova.svg',
	),
	array(
		'name' => 'Parker Hannifin',
		'file' => 'Parker_Hannifin.svg',
	),
	array(
		'name' => 'Rockwell Automation',
		'file' => 'Rockwell_Automation.svg',
	),
	array(
		'name' => 'Schneider Electric',
		'file' => 'Schneider.svg',
	),
	array(
		'name' => 'Siemens',
		'file' => 'Siemens.svg',
	),
	array(
		'name' => 'Wartsila',
		'file' => 'Wärtsilä.svg',
	),
);

$brand_base_dir = trailingslashit( get_stylesheet_directory() ) . 'assets/image/about/';
$brand_base_url = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/image/about/';
$brands         = array();

foreach ( $brand_assets as $brand ) {
	$file_name = isset( $brand['file'] ) ? (string) $brand['file'] : '';
	$file_path = $brand_base_dir . $file_name;

	if ( $file_name === '' || ! file_exists( $file_path ) ) {
		continue;
	}

	$brands[] = array(
		'name' => isset( $brand['name'] ) ? (string) $brand['name'] : '',
		'url'  => $brand_base_url . rawurlencode( $file_name ),
	);
}

if ( empty( $brands ) ) {
	return;
}
?>

<section class="bg-white pt-20 pb-24">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="mb-10 text-center">
			<h2 class="lc-h2-section text-heading">Trusted by Global Manufacturers</h2>
		</div>

		<div class="grid grid-cols-2 gap-4 sm:gap-5 md:grid-cols-3 lg:grid-cols-5 lg:gap-6">
			<?php foreach ( $brands as $brand ) : ?>
				<div class="group flex h-24 items-center justify-center rounded-sm border border-[#E5E7EB] bg-white px-6 py-4 transition-all duration-300 hover:border-[#F97C30] hover:shadow-md">
					<img
						src="<?php echo esc_url( $brand['url'] ); ?>"
						alt="<?php echo esc_attr( $brand['name'] ); ?>"
						class="max-h-7 sm:max-h-8 w-full object-contain"
						loading="lazy"
						decoding="async"
					/>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
