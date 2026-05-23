<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title_page = get_flat_field( 'contact_form_title', [], '' );
$desc_page  = get_flat_field( 'contact_form_desc', [], '' );

$title = $title_page ? $title_page : get_flat_field( 'contact_form_title', [], 'Send us Your Inquiry', true );
$desc  = $desc_page ? $desc_page : get_flat_field( 'contact_form_desc', [], 'Fill out the form below and our sales team will get back to you within 24 hours.', true );

$fast_title_page     = get_flat_field( 'contact_sidebar_fast_title', [], '' );
$fast_desc_page      = get_flat_field( 'contact_sidebar_fast_desc', [], '' );
$fast_highlight_page = get_flat_field( 'contact_sidebar_fast_highlight', [], '' );

$fast_title     = $fast_title_page ? $fast_title_page : get_flat_field( 'contact_sidebar_fast_title', [], 'Fast Response', true );
$fast_desc      = $fast_desc_page ? $fast_desc_page : get_flat_field( 'contact_sidebar_fast_desc', [], 'Our sales team responds within {highlight} to all inquiries.', true );
$fast_highlight = $fast_highlight_page ? $fast_highlight_page : get_flat_field( 'contact_sidebar_fast_highlight', [], '24 hours', true );

$commit_title_page = get_flat_field( 'contact_sidebar_commitments_title', [], '' );
$commit_list_page  = get_flat_field( 'contact_sidebar_commitments_list', [], null );

$commit_title = $commit_title_page ? $commit_title_page : get_flat_field( 'contact_sidebar_commitments_title', [], 'Our Commitments', true );
$commit_list  = is_array( $commit_list_page ) ? $commit_list_page : get_flat_field( 'contact_sidebar_commitments_list', [], array(
	array( 'contact_sidebar_commitment_item' => 'Full material traceability' ),
	array( 'contact_sidebar_commitment_item' => 'Mill Test Reports included' ),
	array( 'contact_sidebar_commitment_item' => 'ISO 9001 certified' ),
	array( 'contact_sidebar_commitment_item' => 'Competitive pricing' ),
), true );

$review_quote_page   = get_flat_field( 'contact_sidebar_review_quote', [], '' );
$review_name_page    = get_flat_field( 'contact_sidebar_review_name', [], '' );
$review_company_page = get_flat_field( 'contact_sidebar_review_company', [], '' );

$review_quote   = $review_quote_page ? $review_quote_page : get_flat_field( 'contact_sidebar_review_quote', [], '"Reliable supplier with excellent customer service. Highly recommended for bulk copper orders."', true );
$review_name    = $review_name_page ? $review_name_page : get_flat_field( 'contact_sidebar_review_name', [], 'David Morrison', true );
$review_company = $review_company_page ? $review_company_page : get_flat_field( 'contact_sidebar_review_company', [], 'AeroTech Manufacturing', true );

$fast_desc = is_string( $fast_desc ) ? trim( $fast_desc ) : '';
$fast_highlight = is_string( $fast_highlight ) ? trim( $fast_highlight ) : '';

$fast_desc_html = '';
if ( $fast_desc ) {
	$parts = explode( '{highlight}', $fast_desc );
	if ( count( $parts ) === 1 ) {
		$fast_desc_html = esc_html( $fast_desc );
	} else {
		$fast_desc_html =
			esc_html( $parts[0] ) .
			'<span class="font-semibold text-[#0B3570]">' . esc_html( $fast_highlight ) . '</span>' .
			esc_html( implode( '', array_slice( $parts, 1 ) ) );
	}
}

?>

<section class="bg-white pt-[100px] pb-[100px] font-sans">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="grid gap-12 lg:grid-cols-3">
			<div class="lg:col-span-2">
				<div class="space-y-6">
					<div>
						<h2 class="text-heading mb-2 text-3xl font-bold text-[#1F2937]">
							<?php echo esc_html( $title ); ?>
						</h2>
						<?php if ( $desc ) : ?>
							<p class="text-[#6B7280]">
								<?php echo esc_html( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>

					<?php get_template_part( 'template-parts/components/form' ); ?>
				</div>
			</div>

			<div class="lg:col-span-1">
				<div class="sticky top-8 space-y-6">
					<div class="rounded-sm border border-[#E5E7EB] bg-[#F8F9FA] p-6">
						<h3 class="text-heading mb-2 font-bold text-[#1F2937]">
							<?php echo esc_html( $fast_title ); ?>
						</h3>
						<?php if ( $fast_desc_html ) : ?>
							<p class="text-sm text-[#6B7280]">
								<?php echo $fast_desc_html; ?>
							</p>
						<?php endif; ?>
					</div>

					<div class="rounded-sm border border-[#E5E7EB] bg-white p-6">
						<h3 class="text-heading mb-4 font-bold text-[#1F2937]">
							<?php echo esc_html( $commit_title ); ?>
						</h3>
						<div class="space-y-4">
							<?php foreach ( (array) $commit_list as $row ) : ?>
								<?php
								$item = '';
								if ( is_array( $row ) && isset( $row['contact_sidebar_commitment_item'] ) ) {
									$item = (string) $row['contact_sidebar_commitment_item'];
								} elseif ( is_array( $row ) && isset( $row['item'] ) ) {
									$item = (string) $row['item'];
								}
								$item = trim( $item );

								if ( ! $item ) {
									continue;
								}
								?>
								<div class="flex items-start gap-3">
									<svg class="mt-0.5 h-5 w-5 shrink-0 text-[#F97C30]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
										<circle cx="12" cy="12" r="10"></circle>
										<path d="M9 12l2 2 4-4"></path>
									</svg>
									<span class="text-sm text-[#6B7280]">
										<?php echo esc_html( $item ); ?>
									</span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="rounded-sm border border-[#E5E7EB] bg-white p-6">
						<div class="mb-3 flex gap-1" aria-label="Rating: 5 out of 5">
							<?php for ( $i = 0; $i < 5; $i++ ) : ?>
								<span class="text-[#F97C30]">★</span>
							<?php endfor; ?>
						</div>

						<?php if ( $review_quote ) : ?>
							<p class="mb-3 text-sm italic text-[#6B7280]">
								<?php echo esc_html( $review_quote ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $review_name ) : ?>
							<div class="text-xs font-semibold text-[#1F2937]">
								<?php echo esc_html( $review_name ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $review_company ) : ?>
							<div class="text-xs text-[#6B7280]">
								<?php echo esc_html( $review_company ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
