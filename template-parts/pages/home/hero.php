<?php
/**
 * Template Part: Home Hero
 * 
 * Logic:
 * 1. Fetches ACF data for the Home Hero module.
 * 2. Renders a full-screen height banner with background image.
 * 3. Displays Headline, CTAs, and Stats.
 * 
 * Industrial Design Rules:
 * - Robust background coverage using CSS Background (fixed scaling).
 * - High-contrast typography (Geist/Geist Mono).
 * - Precision alignment for industrial authority.
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Init (Data Fetching)
// ==========================================
$bg_image_id    = get_flat_field( 'home_hero_bg' );
$headline       = get_flat_field( 'hero_headline', [], 'Premium Copper' );
$legacy_headline = get_flat_field( 'home_hero_title' );
// CTAs
$cta_primary    = get_flat_field( 'home_hero_cta_primary' );
$cta_secondary  = get_flat_field( 'home_hero_cta_secondary' );

// ==========================================
// 2. Preprocess (Logic & Defaults)
// ==========================================

// Background Image
$bg_image_url = 'https://images.unsplash.com/photo-1565793979013-6b1ed28a3b43?auto=format&fit=crop&q=80&w=2000'; // Default fallback
if ( $bg_image_id ) {
	$img_src = wp_get_attachment_image_url( $bg_image_id, 'full' );
	if ( $img_src ) {
		$bg_image_url = $img_src;
	}
}

?>

<!-- 
	View: Home Hero
	==========================================================================
	Robustness Fix: 
	Using inline background style instead of child img tag to ensure the image 
	always follows the container's height without proportional scaling gaps.
-->
<section 
	class="lc-hero relative min-h-screen lg:min-h-screen flex flex-col overflow-hidden bg-neutral-950"
>
	<div class="absolute inset-0 overflow-hidden">
		<?php if ( $bg_image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$bg_image_id,
				'full',
				false,
				array(
					'class' => 'absolute inset-0 h-full w-full object-cover',
					'alt' => '',
					'aria-hidden' => 'true',
					'decoding' => 'async',
					'loading' => 'eager',
					'fetchpriority' => 'high',
					'sizes' => '100vw',
				)
			);
			?>
		<?php else : ?>
			<img class="absolute inset-0 h-full w-full object-cover" src="<?php echo esc_url( $bg_image_url ); ?>" alt="" aria-hidden="true" decoding="async" loading="eager" fetchpriority="high">
		<?php endif; ?>
		<div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/35 to-black/60"></div>
	</div>
	<!-- Content Container (flex-1 ensures it pushes stats to bottom) -->
	<div class="relative z-10 flex-1 flex flex-col justify-center mx-auto w-full max-w-[1280px] px-4 sm:px-6 lg:px-8 pt-[96px] pb-[32px] sm:pt-[120px] sm:pb-[60px]">
		
		<div class="mx-auto max-w-4xl text-center">
			<!-- 1. Headline (Machined Impact) -->
			<h1 class="lc-home-hero-title text-white text-balance mb-8">
				<?php if ( '' !== trim( (string) $headline ) ) : ?>
					<?php echo esc_html( $headline ); ?>
				<?php else : ?>
					<?php echo wp_kses_post( $legacy_headline ? $legacy_headline : 'Premium Copper' ); ?>
				<?php endif; ?>
			</h1>

			<!-- 2. CTAs (Action Oriented) -->
			<div class="flex flex-wrap justify-center gap-5 mb-10 md:mb-16">
				<!-- Primary CTA -->
				<?php if ( $cta_primary ) : ?>
					<a
						href="<?php echo esc_url( $cta_primary['url'] ); ?>"
						target="<?php echo esc_attr( $cta_primary['target'] ?: '_self' ); ?>"
						class="lc-hero-btn lc-hero-btn--primary"
					>
						<?php echo esc_html( $cta_primary['title'] ); ?>
					</a>
				<?php else: ?>
					<a href="/shapes" class="lc-hero-btn lc-hero-btn--primary">
						Browse Products
					</a>
				<?php endif; ?>

				<!-- Secondary CTA (Request a Quote) -->
				<?php if ( $cta_secondary ) : ?>
					<a
						href="<?php echo esc_url( $cta_secondary['url'] ); ?>"
						target="<?php echo esc_attr( $cta_secondary['target'] ?: '_self' ); ?>"
						class="lc-hero-btn lc-hero-btn--secondary"
					>
						<?php echo esc_html( $cta_secondary['title'] ); ?>
					</a>
				<?php else: ?>
					<a href="/contact" class="lc-hero-btn lc-hero-btn--secondary">
						Request a Quote
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

</section>
