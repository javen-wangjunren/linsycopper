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

<section class="bg-white pt-[100px] pb-[100px] font-sans">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="lc-section-header mb-12 text-center">
			<h1 class="text-heading text-balance text-4xl font-bold tracking-tight text-[#1F2937] md:text-5xl">
				<?php if ( $title_last ) : ?>
					<?php echo esc_html( $title_first ); ?> <span class="text-[#F97C30]"><?php echo esc_html( $title_last ); ?></span>
				<?php else : ?>
					<?php echo esc_html( $title_first ); ?>
				<?php endif; ?>
			</h1>
			<?php if ( $desc ) : ?>
				<p class="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
					<?php echo esc_html( $desc ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( $methods as $method ) : ?>
				<?php
				$icon_id = isset( $method['icon'] ) ? (int) $method['icon'] : 0;
				$label   = isset( $method['label'] ) ? (string) $method['label'] : '';
				$value   = isset( $method['value'] ) ? (string) $method['value'] : '';
				$link    = isset( $method['link'] ) ? trim( (string) $method['link'] ) : '';

				if ( ! $label && ! $value && ! $icon_id ) {
					continue;
				}
				?>
				<div class="group flex flex-col items-center rounded-sm border border-[#E5E7EB] bg-white p-6 text-center transition-all hover:border-[#F97C30] hover:shadow-lg">
					<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-sm bg-[#0B3570]/10 text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
						<?php if ( $icon_id ) : ?>
							<?php echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'class' => 'h-6 w-6 object-contain' ) ); ?>
						<?php endif; ?>
					</div>

					<?php if ( $label ) : ?>
						<h3 class="text-heading mb-2 font-semibold text-[#1F2937]">
							<?php echo esc_html( $label ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( $value ) : ?>
						<?php if ( $link ) : ?>
							<a href="<?php echo esc_url( $link ); ?>" class="mb-3 text-sm font-mono font-bold text-[#0B3570] transition-colors hover:text-[#F97C30]">
								<?php echo esc_html( $value ); ?>
							</a>
						<?php else : ?>
							<p class="mb-3 text-sm font-mono font-bold text-[#0B3570]">
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
