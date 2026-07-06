<?php
/**
 * Template Part: About - Factory Advantages
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = get_flat_field(
	'factory_advantages_title',
	[],
	'Why industrial buyers choose Linsy Copper for long-term supply and processing support'
);
$items = get_flat_field( 'factory_advantages_items', [], [] );
$cta_text = get_flat_field( 'factory_advantages_cta_text', [], 'Discuss Your Copper Requirement' );
$cta_url = get_flat_field( 'factory_advantages_cta_url', [], '/contact-us/' );

if ( empty( $items ) || ! is_array( $items ) ) {
	$items = array(
		array( 'item_icon_key' => 'quality', 'item_title' => 'Stable quality control' ),
		array( 'item_icon_key' => 'cut_to_size', 'item_title' => 'Flexible cut-to-size support' ),
		array( 'item_icon_key' => 'stock', 'item_title' => 'Reliable stock planning' ),
		array( 'item_icon_key' => 'spec', 'item_title' => 'Specification alignment' ),
		array( 'item_icon_key' => 'support', 'item_title' => 'Responsive project support' ),
		array( 'item_icon_key' => 'delivery', 'item_title' => 'Export-ready delivery flow' ),
		array( 'item_icon_key' => 'supply', 'item_title' => 'Long-term supply mindset' ),
		array( 'item_icon_key' => 'improvement', 'item_title' => 'Continuous process improvement' ),
	);
}

if ( ! function_exists( 'linsy_render_about_factory_advantage_icon' ) ) {
	/**
	 * Render approved icon set for factory advantages.
	 *
	 * @param string $icon_key Icon key.
	 * @return void
	 */
	function linsy_render_about_factory_advantage_icon( $icon_key ) {
		switch ( $icon_key ) {
			case 'quality':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M12 3l7 4v5c0 5-3.4 8.7-7 9-3.6-.3-7-4-7-9V7l7-4z"></path>
					<path d="m9 12 2 2 4-4"></path>
				</svg>
				<?php
				break;
			case 'cut_to_size':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M4 7h16"></path><path d="M7 4v6"></path><path d="M17 4v6"></path><path d="M6 17h6"></path><path d="M4 12h16v7H4z"></path>
				</svg>
				<?php
				break;
			case 'stock':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M3 7h18"></path><path d="M6 3v8"></path><path d="M18 3v8"></path><path d="M4 12h16v8H4z"></path><path d="M8 16h8"></path>
				</svg>
				<?php
				break;
			case 'spec':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M4 15V8l8-4 8 4v7"></path><path d="M8 12h8"></path><path d="M12 8v8"></path><path d="M7 19h10"></path>
				</svg>
				<?php
				break;
			case 'support':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M8 17l-4 3V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H8z"></path><path d="M8 10h8"></path><path d="M8 14h5"></path>
				</svg>
				<?php
				break;
			case 'delivery':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M3 6h15v11H3z"></path><path d="M18 10h2l1 2v5h-3"></path><circle cx="7.5" cy="18" r="1.5"></circle><circle cx="17.5" cy="18" r="1.5"></circle>
				</svg>
				<?php
				break;
			case 'supply':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M12 3 4 7v5c0 4.6 3.2 8.2 8 9 4.8-.8 8-4.4 8-9V7l-8-4z"></path><path d="M9 12h6"></path><path d="M12 9v6"></path>
				</svg>
				<?php
				break;
			case 'improvement':
			default:
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<path d="M12 20V10"></path><path d="m8 14 4-4 4 4"></path><path d="M5 4h14"></path><path d="M5 20h14"></path>
				</svg>
				<?php
				break;
		}
	}
}
?>

<section class="lc-factory-advantages relative overflow-hidden border-t border-[#0B3570]/6 bg-white pt-[88px] pb-[104px]">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="mx-auto max-w-[720px] text-center">
			<div class="mb-5 flex items-center justify-center gap-4">
				<span class="h-px w-12 bg-[#F97C30]"></span>
				<p class="text-sm font-medium tracking-tight text-[#0B3570]/72">Factory advantages</p>
				<span class="h-px w-12 bg-[#F97C30]"></span>
			</div>

			<h2 class="text-3xl font-bold leading-tight tracking-tight text-heading md:text-[40px] lg:text-[46px]">
				<?php echo esc_html( $title ); ?>
			</h2>
		</div>

		<div class="mt-14 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$icon_key = isset( $item['item_icon_key'] ) ? (string) $item['item_icon_key'] : 'quality';
				$item_title = isset( $item['item_title'] ) ? (string) $item['item_title'] : '';

				if ( $item_title === '' ) {
					continue;
				}
				?>
				<article class="rounded-sm border border-[#0B3570]/6 bg-[#F8F9FA] p-7 shadow-[0_8px_22px_rgba(11,53,112,0.035)]">
					<div class="mb-5 flex h-11 w-11 items-center justify-center rounded-sm border border-[#F97C30]/24 bg-white text-[#0B3570]">
						<?php linsy_render_about_factory_advantage_icon( $icon_key ); ?>
					</div>
					<h3 class="text-xl font-semibold leading-snug text-heading">
						<?php echo esc_html( $item_title ); ?>
					</h3>
				</article>
			<?php endforeach; ?>
		</div>

		<?php if ( $cta_text && $cta_url ) : ?>
			<div class="mt-12 flex justify-center">
				<a href="<?php echo esc_url( $cta_url ); ?>" class="lc-home-viewall-btn inline-flex items-center justify-center rounded-sm border px-7 py-3 text-sm font-semibold transition-colors">
					<?php echo esc_html( $cta_text ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
