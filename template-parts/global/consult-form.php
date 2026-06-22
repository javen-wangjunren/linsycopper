<?php
/**
 * Template Part: Consult Form Section
 * ==========================================================================
 * Location: template-parts/global/consult-form.php
 * 
 * Logic:
 * - It wraps the pure 'form-consult' atom with a full-width section layout.
 * - Used as a standard section in Product and About Templates.
 * 
 * @package GeneratePress_Child
 */

// 1. Get Custom Background
$bg_id = get_flat_field( 'consult_form_bg' );
$bg_url = $bg_id ? wp_get_attachment_image_url( $bg_id, 'full' ) : '';

?>

<!-- Block Wrapper (Section + Background) -->
<section class="relative pt-[100px] pb-32 font-sans bg-gray-50">
	
	<!-- Decorative Background -->
	<div class="absolute inset-0 top-1/3 h-2/3 overflow-hidden pointer-events-none bg-[#0B3570]">
		<?php if ( $bg_url ) : ?>
			<!-- Custom Image Background -->
			<img src="<?php echo esc_url( $bg_url ); ?>" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-luminosity" alt="Background Texture">
			<div class="absolute inset-0 bg-gradient-to-t from-[#0B3570] to-transparent opacity-80"></div>
		<?php else : ?>
			<!-- Default Stripe Pattern -->
			<div class="absolute inset-0 opacity-5">
				<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
					<defs>
						<pattern id="diagonal-stripes" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse" patternTransform="rotate(-45)">
							<line x1="0" y1="0" x2="0" y2="20" stroke="white" stroke-width="10" />
						</pattern>
					</defs>
					<rect width="100%" height="100%" fill="url(#diagonal-stripes)" />
				</svg>
			</div>
		<?php endif; ?>
	</div>

	<!-- Content Container -->
	<div class="mx-auto max-w-6xl px-4 relative z-10">
		<div class="mx-auto max-w-4xl -mb-16">
            <!-- Card Wrapper -->
            <div class="lc-consult-form-scope bg-white rounded-sm shadow-2xl p-8 md:p-10 border-t-4 border-[#F97C30]">
                
                <!-- Render the Form Atom -->
                <?php get_template_part( 'template-parts/components/form' ); ?>

            </div>
		</div>
	</div>
</section>
