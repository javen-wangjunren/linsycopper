<?php
/**
 * Page Template: Contact - Field Definitions
 * 
 * Logic:
 * Uses the 'clone' strategy to import modular field groups for the Contact page.
 * 
 * Modules:
 * 1. Contact Info (inc/field/pages/contact/contact-info.php)
 * 2. Consult Form (Global)
 * 3. FAQ (inc/field/global/faq.php)
 * 
 * @package GeneratePress_Child
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_page_contact_main',
		'title'  => 'Contact Page Modules',
		'fields' => array(
			
			// =================================================================
			// Tab: Overview
			// =================================================================
			array(
				'key' => 'field_tab_contact_overview',
				'label' => 'Overview',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),

			// =================================================================
			// Accordion: Contact Info
			// =================================================================
			array(
				'key' => 'field_acc_contact_info_wrapper',
				'label' => 'Contact Information',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_contact_info_clone',
				'label' => 'Contact Info Section',
				'name' => 'contact_info_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_contact_info',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: FAQ
			// =================================================================
			array(
				'key' => 'field_acc_contact_faq_wrapper',
				'label' => 'FAQ',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_contact_faq_clone',
				'label' => 'FAQ Section',
				'name' => 'contact_faq_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_global_faq',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// Close accordion
			array(
				'key' => 'field_acc_contact_end',
				'label' => 'End',
				'type' => 'accordion',
				'endpoint' => 1,
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/page-contact.php',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	) );

} );
