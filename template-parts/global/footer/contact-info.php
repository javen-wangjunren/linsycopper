<?php
/**
 * Footer Contact Info Part
 * 
 * Displays:
 * - Address
 * - Phone
 * - Email
 */

$contact_list = get_field( 'footer_contact_list', 'option' );

// Default fallback content if no items added
if ( empty( $contact_list ) ) {
	$contact_list = array(
		array(
			'label'    => 'Address',
			'content'  => "1234 Industrial Blvd<br>Metal City, TX 77000",
			'icon_svg' => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/>',
			'link_url' => '',
		),
		array(
			'label'    => 'Phone',
			'content'  => '+1 (800) 123-4567',
			'icon_svg' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6.18 6.18l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.02z"/>',
			'link_url' => 'tel:+18001234567',
		),
		array(
			'label'    => 'Email',
			'content'  => 'sales@coppercorp.com',
			'icon_svg' => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
			'link_url' => 'mailto:sales@coppercorp.com',
		),
	);
}
?>
<ul class="lc-footer-contact-list space-y-4 text-sm">
	<?php foreach ( $contact_list as $item ) : 
		$label    = isset( $item['label'] ) ? $item['label'] : '';
		$content  = isset( $item['content'] ) ? $item['content'] : '';
		$icon_svg = isset( $item['icon_svg'] ) ? $item['icon_svg'] : '';
		$link_url = isset( $item['link_url'] ) ? $item['link_url'] : '';
		
		// Skip empty items
		if ( ! $content ) continue;
	?>
	<li class="flex items-start gap-3">
		<?php if ( $icon_svg ) : ?>
			<?php 
			if ( preg_match( '/<svg[^>]*>(.*)<\/svg>/s', $icon_svg, $matches ) ) {
				$inner_svg = $matches[1];
			} else {
				$inner_svg = $icon_svg;
			}
			?>
			<svg class="w-4 h-4 mt-0.5 shrink-0 text-action-copper" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<?php echo $inner_svg; ?>
			</svg>
		<?php endif; ?>
		
		<div>
			<?php if ( $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" class="transition-colors block <?php echo stripos( $label, 'phone' ) !== false ? 'font-mono' : ''; ?>">
					<?php echo wp_kses_post( $content ); ?>
				</a>
			<?php else : ?>
				<div class="block">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
