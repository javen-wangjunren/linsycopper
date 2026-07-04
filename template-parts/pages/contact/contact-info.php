<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = get_flat_field( 'contact_info_title', [], 'Get in Touch' );
$desc    = get_flat_field( 'contact_info_desc', [], '' );
$methods = get_flat_field( 'contact_methods', [], [] );

if ( empty( $methods ) ) {
	return;
}

$title = is_string( $title ) ? trim( $title ) : '';
$desc  = is_string( $desc ) ? trim( $desc ) : '';

if ( ! function_exists( 'linsy_contact_info_icon_markup' ) ) {
	/**
	 * Return the fixed icon markup for contact info cards.
	 *
	 * @param string $label Card label.
	 * @return string
	 */
	function linsy_contact_info_icon_markup( $label ) {
		$key = strtolower( trim( (string) $label ) );
		$key = preg_replace( '/[^a-z0-9]+/', '-', $key );
		$key = trim( (string) $key, '-' );

		$icons = array(
			'phone'          => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.63 2.63a2 2 0 0 1-.45 2.11L8 9.91a16 16 0 0 0 6.09 6.09l1.45-1.29a2 2 0 0 1 2.11-.45c.85.3 1.73.51 2.63.63A2 2 0 0 1 22 16.92z"/></svg>',
			'email'          => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>',
			'address'        => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-6-5.33-6-11a6 6 0 1 1 12 0c0 5.67-6 11-6 11z"/><circle cx="12" cy="10" r="2.5"/></svg>',
			'business-hours' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l2.5 2.5"/></svg>',
			'hours'          => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l2.5 2.5"/></svg>',
		);

		return $icons[ $key ] ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l2.5 2.5"/></svg>';
	}
}

$title_tokens = $title ? preg_split( '/\s+/', $title ) : [];
$title_last   = '';
$title_first  = '';

if ( is_array( $title_tokens ) && count( $title_tokens ) >= 2 ) {
	$title_last  = array_pop( $title_tokens );
	$title_first = implode( ' ', $title_tokens );
} else {
	$title_first = $title;
}
?>

<section class="lc-contact-info-scope bg-white pt-[100px] pb-[100px] font-sans">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="lc-section-header mb-12 text-center">
			<h1 class="lc-h1-page text-balance text-[#1F2937]">
				<?php if ( $title_last ) : ?>
					<?php echo esc_html( $title_first ); ?> <span class="text-[#F97C30]"><?php echo esc_html( $title_last ); ?></span>
				<?php else : ?>
					<?php echo esc_html( $title_first ); ?>
				<?php endif; ?>
			</h1>
			<?php if ( $desc ) : ?>
				<p class="lc-body-section mx-auto mt-3 max-w-2xl text-pretty">
					<?php echo esc_html( $desc ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
			<?php foreach ( $methods as $method ) : ?>
				<?php
				$label   = isset( $method['label'] ) ? (string) $method['label'] : '';
				$value   = isset( $method['value'] ) ? (string) $method['value'] : '';
				$link    = isset( $method['link'] ) ? trim( (string) $method['link'] ) : '';

				if ( ! $label && ! $value ) {
					continue;
				}
				?>
				<div class="group flex flex-col items-center rounded-sm border border-[#E5E7EB] bg-white p-6 text-center transition-all hover:border-[#F97C30] hover:shadow-lg">
					<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-sm bg-[#0B3570]/10 text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
						<?php echo linsy_contact_info_icon_markup( $label ); ?>
					</div>

					<?php if ( $label ) : ?>
						<h3 class="lc-h3-section mb-2 text-[#1F2937]">
							<?php echo esc_html( $label ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( $value ) : ?>
						<?php if ( $link ) : ?>
							<a href="<?php echo esc_url( $link ); ?>" class="lc-mono-meta mb-3 font-bold text-[#0B3570] transition-colors hover:text-[#F97C30]">
								<?php echo esc_html( $value ); ?>
							</a>
						<?php else : ?>
							<p class="lc-mono-meta mb-3 font-bold text-[#0B3570]">
								<?php echo esc_html( $value ); ?>
							</p>
						<?php endif; ?>
					<?php endif; ?>

					<div class="mt-4 h-0.5 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full"></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
