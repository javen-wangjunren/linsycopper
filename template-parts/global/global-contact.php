<?php
/**
 * Render: Global Contact Section (Full Module)
 * ==========================================================================
 * Location: template-parts/global/global-contact.php
 * 
 * Logic:
 * 1. Fetches global data from Options Page ('option').
 * 2. Renders layout: Left (Info) + Right (Consult Form Atom).
 * 3. Uses 'form-consult' atom for the form part.
 * 
 * @package GeneratePress_Child
 */

// 1. Fetch Global Data
$title     = get_field( 'global_contact_title', 'option' );
$desc      = get_field( 'global_contact_desc', 'option' );
$bg_id     = get_field( 'global_contact_bg', 'option' );
$strengths = get_field( 'global_contact_strengths', 'option' );
$footer_contact_list = get_field( 'footer_contact_list', 'option' );
$whatsapp_icon_svg = '<path d="M20.5 11.5a8.5 8.5 0 0 1-12.5 7.5L3 20l1.2-4.6A8.5 8.5 0 1 1 20.5 11.5Z"/><path d="M8.6 8.9c.2-.5.4-.5.7-.5h.6c.2 0 .4 0 .5.4l.7 1.7c.1.2.1.4 0 .6l-.3.5c-.1.2-.2.3 0 .5.4.7 1 1.4 1.8 1.9.2.1.4.1.5 0l.5-.6c.2-.2.4-.2.6-.1l1.6.8c.3.1.4.2.4.4v.6c0 .3-.1.6-.5.8-.4.2-1 .3-1.5.2-1.2-.3-2.4-1-3.4-2-1-1-1.7-2.1-2-3.3-.1-.5 0-1.1.2-1.5Z"/>';

$contact_methods = array(
	'whatsapp' => array(
		'label'    => 'Whatsapp',
		'content'  => '+86 181 2470 3776',
		'link_url' => 'https://api.whatsapp.com/send?phone=8618124703776',
		'icon_svg' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>',
	),
	'email'    => array(
		'label'    => 'Email',
		'content'  => 'david@linsycopper.com',
		'link_url' => 'mailto:david@linsycopper.com',
		'icon_svg' => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>',
	),
);

if ( ! empty( $footer_contact_list ) && is_array( $footer_contact_list ) ) {
	foreach ( $footer_contact_list as $item ) {
		$link_url = isset( $item['link_url'] ) ? trim( (string) $item['link_url'] ) : '';

		if ( '' === $link_url ) {
			continue;
		}

		$link_url_lower = strtolower( $link_url );
		$method_key     = '';

		if ( false !== strpos( $link_url_lower, 'mailto:' ) ) {
			$method_key = 'email';
		} elseif ( false !== strpos( $link_url_lower, 'whatsapp' ) || false !== strpos( $link_url_lower, 'wa.me' ) ) {
			$method_key = 'whatsapp';
		}

		if ( '' === $method_key ) {
			continue;
		}

		$contact_methods[ $method_key ] = array(
			'label'    => isset( $item['label'] ) ? (string) $item['label'] : $contact_methods[ $method_key ]['label'],
			'content'  => isset( $item['content'] ) ? (string) $item['content'] : $contact_methods[ $method_key ]['content'],
			'link_url' => $link_url,
			'icon_svg' => 'whatsapp' === $method_key
				? $whatsapp_icon_svg
				: ( isset( $item['icon_svg'] ) ? (string) $item['icon_svg'] : $contact_methods[ $method_key ]['icon_svg'] ),
		);
	}
}

// 2. Fallback Defaults (Safe Mode)
if ( empty( $title ) ) $title = 'Consult Our Experts';
if ( empty( $desc ) ) $desc   = 'Give us a call at <a href="tel:3462305191" class="font-bold text-white underline transition hover:text-[#F97C30]">346.230.5191</a> or leave us a message below.';
?>

<!-- Copper UI: Vertical Rhythm -->
<section id="contact-form" class="lc-global-contact relative overflow-hidden bg-[#0B3570] font-sans">
    
    <!-- Background Layer -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <?php if ( $bg_id ) : ?>
            <?php echo wp_get_attachment_image( $bg_id, 'full', false, array( 'class' => 'h-full w-full object-cover opacity-30 grayscale' ) ); ?>
        <?php else : ?>
            <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&q=80&w=1600" alt="Industrial Background" class="h-full w-full object-cover opacity-30 grayscale">
        <?php endif; ?>
        
        <!-- Blue Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0B3570] via-[#0B3570]/90 to-transparent"></div>
    </div>

    <div class="relative z-10 mx-auto flex max-w-[1280px] flex-col items-center gap-16 px-6 py-20 lg:flex-row">
        
        <!-- Left Content -->
        <div class="text-white lg:w-5/12">
            <!-- Heading -->
            <h2 class="lc-h2-display mb-6 uppercase text-white">
                <?php echo esc_html( $title ); ?>
            </h2>
            
            <!-- Description -->
            <div class="lc-body-section lc-global-contact__desc mb-10">
                <?php echo wp_kses_post( $desc ); ?>
            </div>

            <div class="lc-global-contact__links mb-10">
                <?php foreach ( array( 'whatsapp', 'email' ) as $method_key ) : ?>
                    <?php
                    $method = isset( $contact_methods[ $method_key ] ) ? $contact_methods[ $method_key ] : null;

                    if ( empty( $method['content'] ) || empty( $method['link_url'] ) ) {
                        continue;
                    }

                    $icon_svg = isset( $method['icon_svg'] ) ? (string) $method['icon_svg'] : '';

                    if ( $icon_svg && preg_match( '/<svg[^>]*>(.*)<\/svg>/s', $icon_svg, $matches ) ) {
                        $icon_svg = $matches[1];
                    }
                    ?>
                    <a
                        href="<?php echo esc_url( $method['link_url'] ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="lc-global-contact__link-item"
                    >
                        <svg class="lc-global-contact__link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <?php echo $icon_svg; ?>
                        </svg>
                        <span class="lc-global-contact__link-text">
                            <?php echo wp_kses_post( $method['content'] ); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Strengths Grid -->
            <?php if ( ! empty( $strengths ) ) : ?>
            <div class="grid grid-cols-2 gap-y-8 gap-x-12 border-t border-white/10 pt-10">
                <?php foreach ( $strengths as $item ) : ?>
                <div>
                    <!-- Copper UI: Font Logic (Mono for Data) -->
                    <div class="lc-mono-value lc-global-contact__stat-value text-2xl text-[#F4BD5D]">
                        <?php echo esc_html( $item['strength_value'] ); ?>
                    </div>
                    <!-- Copper UI: Micro Typography -->
                    <div class="lc-mono-kicker lc-global-contact__stat-label mt-1 opacity-60">
                        <?php echo esc_html( $item['strength_label'] ); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right: Contact Form -->
        <!-- Copper UI: Micro-Radius (rounded-sm) & Interaction Border -->
        <div class="lc-consult-form-scope w-full rounded-sm border-t-4 border-[#F97C30] bg-white p-8 shadow-2xl md:p-10 lg:w-7/12">
            
            <!-- Render the Form Atom -->
            <?php get_template_part( 'template-parts/components/form' ); ?>
            
        </div>

    </div>
</section>
