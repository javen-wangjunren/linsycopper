<?php
/**
 * Header Settings Field Group
 * Location: Global Settings > Header
 * 
 * Defines fields for:
 * 1. Button (CTA)
 * 2. Menu Configuration (Custom Menu Locations for dynamic placement)
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_global_header_settings',
		'title'  => 'Header Settings',
		'fields' => array(
			// 1. CTA Button
			array(
				'key' => 'field_header_tab_cta',
				'label' => 'Call to Action',
				'type' => 'tab',
			),
			array(
				'key' => 'field_header_cta_text',
				'label' => 'Button Text',
				'name' => 'header_cta_text',
				'type' => 'text',
				'default_value' => 'Get A Quote',
			),
			array(
				'key' => 'field_header_cta_link',
				'label' => 'Button Link',
				'name' => 'header_cta_link',
				'type' => 'link',
				'return_format' => 'url',
				'default_value' => '/contact',
			),

			// 2. Custom Menus (Future Expansion)
			// Note: Currently using standard 'Primary Menu' location.
			// If we need to allow users to add arbitrary menus to specific slots,
			// we can add a Repeater here later.
			
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-header-settings',
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
}
