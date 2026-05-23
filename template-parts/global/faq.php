<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = get_flat_field( 'contact_faq_title', [], '' );
$desc  = get_flat_field( 'contact_faq_desc', [], '' );
$faqs  = get_flat_field( 'contact_faq_list', [], [] );

if ( empty( $faqs ) ) {
	$title = $title ? $title : get_flat_field( 'contact_faq_title', [], 'Frequently Asked Questions', true );
	$desc  = $desc ? $desc : get_flat_field( 'contact_faq_desc', [], 'Find answers to common questions about our products, services, and ordering process', true );
	$faqs  = get_flat_field( 'contact_faq_list', [], [], true );
}

if ( empty( $faqs ) ) {
	return;
}
?>

<section class="lc-faq-scope bg-[#F8F9FA] pt-[100px] pb-[100px] font-sans">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="mx-auto max-w-[768px]">
			<div class="mb-12 text-center">
				<div class="mb-3 inline-block rounded-sm bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
					FAQ
				</div>
				<h2 class="text-heading text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
					<?php echo esc_html( $title ? $title : 'Frequently Asked Questions' ); ?>
				</h2>
				<?php if ( $desc ) : ?>
					<p class="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>
			</div>

			<div class="rounded-sm border border-[#E5E7EB] bg-white" x-data="{ open: null }">
				<?php foreach ( $faqs as $index => $item ) : ?>
					<?php
					$question = isset( $item['contact_faq_question'] ) ? trim( (string) $item['contact_faq_question'] ) : '';
					$answer   = isset( $item['contact_faq_answer'] ) ? trim( (string) $item['contact_faq_answer'] ) : '';

					if ( ! $question && ! $answer ) {
						continue;
					}

					$id = 'faq-item-' . (int) $index;
					?>
					<div class="border-b border-[#E5E7EB] px-6 py-4 last:border-b-0">
						<button
							type="button"
							class="lc-faq-trigger flex w-full items-center justify-between gap-4 text-left font-semibold text-[#1F2937] transition-colors hover:text-[#0B3570]"
							@click="open === <?php echo (int) $index; ?> ? open = null : open = <?php echo (int) $index; ?>"
							:aria-expanded="open === <?php echo (int) $index; ?> ? 'true' : 'false'"
							aria-controls="<?php echo esc_attr( $id ); ?>"
						>
							<span><?php echo esc_html( $question ); ?></span>
							<svg class="h-4 w-4 shrink-0 text-[#6B7280] transition-transform" :class="open === <?php echo (int) $index; ?> ? 'rotate-180 text-[#0B3570]' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<path d="m6 9 6 6 6-6"></path>
							</svg>
						</button>

						<div
							id="<?php echo esc_attr( $id ); ?>"
							class="pt-4 text-[#6B7280] leading-relaxed"
							x-show="open === <?php echo (int) $index; ?>"
							x-transition
							x-cloak
						>
							<?php echo esc_html( $answer ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
