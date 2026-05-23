<?php
/**
 * Product Applications Field Group
 * Location: Product (CPT) > Applications Section
 * 
 * Defines fields for:
 * 1. Section Title & Subtitle
 * 2. Application Cases (Repeater with Image, Name, Desc)
 *
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_product_applications',
		'title'  => 'Product Applications',
		'fields' => array(
			
			// ===================================
			// Module Wrapper: Accordion (Closed)
			// ===================================
			array(
				'key' => 'field_product_applications_accordion',
				'label' => 'Applications Section',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),

			// 1. Section Header
			array(
				'key' => 'field_product_app_title',
				'label' => 'Section Title',
				'name' => 'product_application_title',
				'type' => 'text',
				'default_value' => 'Applications & Use Cases',
				'wrapper' => array(
					'width' => '50',
				),
			),
			array(
				'key' => 'field_product_app_subtitle',
				'label' => 'Section Subtitle',
				'name' => 'product_application_subtitle',
				'type' => 'textarea',
				'rows' => 2,
				'default_value' => 'Proven solutions across diverse industries. From aerospace to marine environments.',
				'wrapper' => array(
					'width' => '50',
				),
			),

			// 2. Applications List (Repeater)
			array(
				'key' => 'field_product_app_list',
				'label' => 'Applications List',
				'name' => 'product_application_list',
				'type' => 'repeater',
				'layout' => 'block', // Block layout for better card visualization
				'button_label' => 'Add Application Case',
				'sub_fields' => array(
					array(
						'key' => 'field_product_app_list_image',
						'label' => 'Application Image',
						'name' => 'application_image',
						'type' => 'image',
						'return_format' => 'id', // Integer ID
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'wrapper' => array(
							'width' => '20',
						),
					),
					array(
						'key' => 'field_product_app_list_name',
						'label' => 'Application Name',
						'name' => 'application_name', // Normalized to snake_case
						'type' => 'text',
						'wrapper' => array(
							'width' => '30',
						),
					),
					array(
						'key' => 'field_product_app_list_desc',
						'label' => 'Short Description',
						'name' => 'application_shortdesc',
						'type' => 'textarea',
						'rows' => 3,
						'wrapper' => array(
							'width' => '50',
						),
					),
				),
			),
			
			// End Accordion
			array(
				'key' => 'field_product_applications_accordion_end',
				'label' => 'End Accordion',
				'type' => 'accordion',
				'endpoint' => 1,
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product', // Cloned directly into Product CPT
				),
			),
		),
		'menu_order' => 20, // After Hero (0) and Description (10)
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => false, // Only active when cloned
		'description' => 'Applications slider module.',
	) );

}
