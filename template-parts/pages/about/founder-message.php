<?php
/**
 * Template Part: About - Founder Message
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = get_flat_field(
	'founder_message_title',
	[],
	'A long-term business is built on trust, consistency, and the willingness to keep improving.'
);
$body = get_flat_field(
	'founder_message_body',
	[],
	"From the very beginning, I believed that supplying industrial materials should be more than completing an order. It should mean helping customers move forward with confidence, whether they need stable stock, precise processing, or a partner who responds clearly when timelines and specifications matter.\n\nWhat we continue to build at Linsy Copper is not only production capability, but also a way of working rooted in reliability, practical communication, and long-term trust. That is the standard I expect from our team, and the promise I hope every customer can feel in each cooperation."
);
$portrait_id = (int) get_flat_field( 'founder_message_portrait', [], 0 );
$signature_image_id = (int) get_flat_field( 'founder_signature_image', [], 0 );
$founder_name = get_flat_field( 'founder_name', [], 'Jack Zhang' );
$founder_role = get_flat_field( 'founder_role', [], 'Founder, Linsy Copper' );

$body_paragraphs = preg_split( '/\R{2,}/', trim( (string) $body ) );
$body_paragraphs = array_values(
	array_filter(
		array_map( 'trim', is_array( $body_paragraphs ) ? $body_paragraphs : array() )
	)
);

if ( empty( $body_paragraphs ) ) {
	$body_paragraphs = array( (string) $body );
}
?>

<section class="lc-founder-message">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<div class="lc-founder-message__grid">
			<div class="lc-founder-message__media lc-founder-message__media--desktop">
				<figure class="lc-founder-message__figure">
					<div class="lc-founder-message__image-wrap">
						<?php if ( $portrait_id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$portrait_id,
								'large',
								false,
								array(
									'class'   => 'lc-founder-message__image',
									'loading' => 'lazy',
								)
							);
							?>
						<?php else : ?>
							<div class="lc-founder-message__image-placeholder">
								<svg class="h-24 w-24 text-[#0B3570]/10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
								</svg>
							</div>
						<?php endif; ?>
					</div>
				</figure>
			</div>

			<div class="lc-founder-message__content">
				<div class="lc-founder-message__kicker">
					<span class="lc-founder-message__kicker-line"></span>
					<p class="lc-founder-message__kicker-text">Founder message</p>
				</div>

				<div class="lc-founder-message__media lc-founder-message__media--mobile">
					<figure class="lc-founder-message__figure">
						<div class="lc-founder-message__image-wrap">
							<?php if ( $portrait_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									$portrait_id,
									'large',
									false,
									array(
										'class'   => 'lc-founder-message__image',
										'loading' => 'lazy',
									)
								);
								?>
							<?php else : ?>
								<div class="lc-founder-message__image-placeholder">
									<svg class="h-24 w-24 text-[#0B3570]/10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
										<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
									</svg>
								</div>
							<?php endif; ?>
						</div>
					</figure>
				</div>

				<h2 class="lc-founder-message__title">
					<?php echo wp_kses( $title, array( 'br' => array() ) ); ?>
				</h2>

				<div class="lc-founder-message__body">
						<?php foreach ( $body_paragraphs as $paragraph ) : ?>
							<p class="lc-founder-message__paragraph"><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
				</div>

				<div class="lc-founder-message__signature">
					<div class="lc-founder-message__signature-mark">
						<?php if ( $signature_image_id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$signature_image_id,
								'large',
								false,
								array(
									'class'    => 'lc-founder-message__signature-image',
									'loading'  => 'lazy',
									'decoding' => 'async',
									'alt'      => $founder_name ? sprintf( '%s signature', $founder_name ) : 'Founder signature',
								)
							);
							?>
						<?php else : ?>
							<p class="lc-founder-message__name"><?php echo esc_html( $founder_name ); ?></p>
						<?php endif; ?>
					</div>
					<p class="lc-founder-message__role"><?php echo esc_html( $founder_role ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>
