<?php
/**
 * Template Part: Home Hero
 * 
 * Logic:
 * 1. Fetches ACF data for the Home Hero module.
 * 2. Renders a full-screen height banner with background image.
 * 3. Displays Certifications, Headline, Description, CTAs, and Stats.
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
$headline_highlight = get_flat_field( 'hero_highlight_headline', [], '& Bronze Alloys' );
$legacy_headline = get_flat_field( 'home_hero_title' );
$description    = get_flat_field( 'home_hero_desc', [], 'Largest inventory of C11000, C10100, and Naval Brass in the region. Cut to size, precision machined, and shipped globally.' );

// CTAs
$cta_primary    = get_flat_field( 'home_hero_cta_primary' );
$cta_secondary  = get_flat_field( 'home_hero_cta_secondary' );

// Repeaters
$certs          = get_flat_field( 'home_hero_certs', [], [] );
$stats          = get_flat_field( 'home_hero_stats', [], [] );

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

// Default Data (if empty)
if ( empty( $certs ) ) {
	$certs = [
		['text' => 'ASTM B152'],
		['text' => 'RoHS Compliant'],
		['text' => 'Full MTR Docs'],
	];
}

if ( empty( $stats ) ) {
	$stats = [
		['value' => '1,000+', 'label' => 'Tons Ready Stock'],
		['value' => 'ISO 9001', 'label' => 'Certified Quality'],
		['value' => '25+ Years', 'label' => 'Industry Experience'],
		['value' => '48-Hr', 'label' => 'Quote Turnaround'],
	];
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
	class="lc-hero relative min-h-screen lg:min-h-screen flex flex-col overflow-hidden bg-neutral-950 bg-center bg-cover bg-no-repeat"
	style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.35) 50%, rgba(0,0,0,0.60) 100%), url('<?php echo esc_url( $bg_image_url ); ?>');"
>
	<!-- Content Container (flex-1 ensures it pushes stats to bottom) -->
	<div class="relative z-10 flex-1 flex flex-col justify-center mx-auto w-full max-w-[1280px] px-4 sm:px-6 lg:px-8 pt-[96px] pb-[32px] sm:pt-[120px] sm:pb-[60px]">
		
		<div class="max-w-4xl">
			<!-- 1. Certifications (Industrial Tags) -->
			<?php if ( ! empty( $certs ) ) : ?>
				<div class="flex flex-wrap items-center gap-4 mb-8 md:gap-6 md:mb-10">
					<?php foreach ( $certs as $cert ) : 
						$cert_text = is_array( $cert ) ? $cert['text'] : $cert;
					?>
						<span class="flex items-center gap-2 font-mono text-[15px] font-bold text-[#F4BD5D]">
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0 opacity-80"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
							<?php echo esc_html( $cert_text ); ?>
						</span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- 2. Headline (Machined Impact) -->
			<h1 class="!text-[42px] sm:!text-5xl md:!text-7xl lg:!text-[88px] font-bold text-white !leading-[1] tracking-tight text-balance mb-8 text-heading">
				<?php if ( '' !== trim( (string) $headline ) || '' !== trim( (string) $headline_highlight ) ) : ?>
					<?php echo esc_html( $headline ); ?>
					<?php if ( '' !== trim( (string) $headline_highlight ) ) : ?>
						<br>
						<span class="text-[#F97C30]"><?php echo esc_html( $headline_highlight ); ?></span>
					<?php endif; ?>
				<?php else : ?>
					<?php echo wp_kses_post( $legacy_headline ? $legacy_headline : 'Premium Copper <br><span class="text-[#F97C30]">&amp; Bronze Alloys</span>' ); ?>
				<?php endif; ?>
			</h1>

			<!-- 3. Description (Clean Industrial) -->
			<p class="text-lg md:text-xl text-white/80 leading-relaxed max-w-2xl mb-10 md:mb-12">
				<?php
				$description_html = wp_kses(
					nl2br( html_entity_decode( (string) $description, ENT_QUOTES, 'UTF-8' ) ),
					[
						'br'     => [],
						'strong' => [],
						'em'     => [],
						'b'      => [],
						'i'      => [],
					]
				);
				echo $description_html;
				?>
			</p>

			<!-- 4. CTAs (Action Oriented) -->
			<div class="flex flex-wrap gap-5 mb-10 md:mb-16">
				<!-- Primary CTA -->
				<?php if ( $cta_primary ) : ?>
					<a
						href="<?php echo esc_url( $cta_primary['url'] ); ?>"
						target="<?php echo esc_attr( $cta_primary['target'] ?: '_self' ); ?>"
						class="lc-hero-btn lc-hero-btn--primary group"
					>
						<?php echo esc_html( $cta_primary['title'] ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 transition-transform group-hover:translate-x-1.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php else: ?>
					<a href="/shapes" class="lc-hero-btn lc-hero-btn--primary group">
						Browse Products
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 transition-transform group-hover:translate-x-1.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>

				<!-- Secondary CTA (Request a Quote) -->
				<?php if ( $cta_secondary ) : ?>
					<a
						href="<?php echo esc_url( $cta_secondary['url'] ); ?>"
						target="<?php echo esc_attr( $cta_secondary['target'] ?: '_self' ); ?>"
						class="lc-hero-btn lc-hero-btn--secondary group"
					>
						<?php echo esc_html( $cta_secondary['title'] ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php else: ?>
					<a href="/contact" class="lc-hero-btn lc-hero-btn--secondary group">
						Request a Quote
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- 5. Stats Dashboard (Anchored to Bottom, Seamless Background) -->
	<div class="relative z-10 w-full border-t border-white/10 bg-black/20 backdrop-blur-sm">
		<div class="mx-auto w-full max-w-[1280px] px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
			<?php if ( ! empty( $stats ) ) : ?>
				<div class="grid grid-cols-2 sm:grid-cols-4 gap-8 md:gap-16">
					<?php foreach ( $stats as $stat ) : 
						$val = is_array( $stat ) ? $stat['value'] : $stat['value'];
						$lbl = is_array( $stat ) ? $stat['label'] : $stat['label'];
					?>
						<div class="group">
							<div class="font-mono text-2xl sm:text-3xl md:text-4xl font-bold text-[#F4BD5D] mb-1.5 transition-transform group-hover:scale-105 inline-block">
								<?php echo esc_html( $val ); ?>
							</div>
							<div class="text-[10px] md:text-[11px] font-bold uppercase tracking-[0.2em] text-white/50 leading-tight">
								<?php echo esc_html( $lbl ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
