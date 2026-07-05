<?php
/**
 * Product Description Field Group
 * Location: Product (CPT) > Description
 * 
 * Defines fields for:
 * 1. Product Overview (Title & Content)
 * 2. Key Features (Repeater)
 *
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_product_description',
		'title'  => 'Product Description',
		'fields' => array(
			
			// ===================================
			// Module Wrapper: Accordion (Closed)
			// ===================================
			array(
				'key' => 'field_product_desc_accordion',
				'label' => 'Description Section',
				'type' => 'accordion',
				'open' => 0, // Default closed
				'multi_expand' => 1,
				'endpoint' => 0,
			),

			// 1. Overview
			array(
				'key' => 'field_product_desc_tab_overview',
				'label' => 'Overview',
				'type' => 'tab',
			),
			array(
				'key' => 'field_product_desc_title',
				'label' => 'Section Title',
				'name' => 'product_desc_title',
				'type' => 'text',
				'default_value' => 'Product Overview',
				'instructions' => 'The main heading for this section.',
			),
			array(
				'key' => 'field_product_desc_content',
				'label' => 'Content',
				'name' => 'product_desc_content',
				'type' => 'wysiwyg',
				'tabs' => 'visual',
				'toolbar' => 'basic',
				'media_upload' => 0,
				'instructions' => 'Detailed product description. Use paragraphs and simple lists.',
			),

			// 2. Features
			array(
				'key' => 'field_product_desc_tab_features',
				'label' => 'Features',
				'type' => 'tab',
			),
			array(
				'key' => 'field_product_desc_features_title',
				'label' => 'Features Title',
				'name' => 'product_desc_features_title',
				'type' => 'text',
				'default_value' => 'Key Features',
			),
			array(
				'key' => 'field_product_desc_features',
				'label' => 'Feature List',
				'name' => 'product_desc_features',
				'type' => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Feature',
				'sub_fields' => array(
					array(
						'key' => 'field_product_desc_feature_text',
						'label' => 'Feature Text',
						'name' => 'text',
						'type' => 'text',
						'placeholder' => 'Manufactured to ASTM B152 standards',
					),
				),
			),
		),
		'location' => array(
			// No location rules needed for a module that is only cloned
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => false, // Disabled: This group is cloned into CPTs
	) );
}
