<?php
/**
 * Product Hero Field Group
 * Location: Product (CPT) > Hero Section
 * 
 * Defines fields for:
 * 1. Product Images (Gallery)
 * 2. Short Description
 * 3. Key Specs (Repeater)
 * 4. Actions (CTA Buttons)
 * 5. Business Data (Repeater)
 *
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_product_hero',
		'title'  => 'Product Hero',
		'fields' => array(
			
			// ===================================
			// Module Wrapper: Accordion (Open)
			// ===================================
			array(
				'key' => 'field_product_hero_accordion',
				'label' => 'Hero Section',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),

			// 1. Product Images
			array(
				'key' => 'field_product_hero_tab_images',
				'label' => 'Images',
				'type' => 'tab',
			),
			array(
				'key' => 'field_product_hero_gallery',
				'label' => 'Product Gallery',
				'name' => 'product_hero_gallery',
				'type' => 'gallery',
				'return_format' => 'id', // Integer for wp_get_attachment_image
				'preview_size' => 'medium',
				'insert' => 'append',
				'library' => 'all',
				'min' => 1,
				'instructions' => 'Upload product images. First image will be the main hero image.',
			),

			// 2. Info & Specs
			array(
				'key' => 'field_product_hero_tab_info',
				'label' => 'Info & Specs',
				'type' => 'tab',
			),
			array(
				'key' => 'field_product_hero_desc',
				'label' => 'Short Description',
				'name' => 'product_hero_desc',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'br',
				'instructions' => 'Brief overview appearing below the specs. Keep it under 200 characters.',
			),
			array(
				'key' => 'field_product_hero_specs',
				'label' => 'Key Specifications',
				'name' => 'product_hero_specs',
				'type' => 'repeater',
				'layout' => 'table', // Compact table layout
				'button_label' => 'Add Spec',
				'max' => 4, // Recommended 3, allow 4 max
				'sub_fields' => array(
					array(
						'key' => 'field_product_hero_spec_value',
						'label' => 'Value',
						'name' => 'value',
						'type' => 'text',
						'placeholder' => '>99.9% Cu',
					),
					array(
						'key' => 'field_product_hero_spec_label',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
						'placeholder' => 'PURITY',
					),
				),
			),

			// 3. Actions (CTA)
			array(
				'key' => 'field_product_hero_tab_actions',
				'label' => 'Actions',
				'type' => 'tab',
			),
			array(
				'key' => 'field_product_hero_quote_text',
				'label' => 'Quote Button Text',
				'name' => 'product_hero_quote_text',
				'type' => 'text',
				'default_value' => 'Get A Quote',
				'wrapper' => array('width' => '50'),
			),
			array(
				'key' => 'field_product_hero_quote_link',
				'label' => 'Quote Button Link',
				'name' => 'product_hero_quote_link',
				'type' => 'link',
				'return_format' => 'url',
				'default_value' => '/contact',
				'wrapper' => array('width' => '50'),
			),
			array(
				'key' => 'field_product_hero_datasheet_text',
				'label' => 'Datasheet Button Text',
				'name' => 'product_hero_datasheet_text',
				'type' => 'text',
				'default_value' => 'Download Datasheet',
				'wrapper' => array('width' => '50'),
			),
			array(
				'key' => 'field_product_hero_datasheet_file',
				'label' => 'Datasheet File',
				'name' => 'product_hero_datasheet_file',
				'type' => 'file',
				'return_format' => 'url',
				'library' => 'all',
				'wrapper' => array('width' => '50'),
			),

			// 4. Business Data
			array(
				'key' => 'field_product_hero_tab_business',
				'label' => 'Business Data',
				'type' => 'tab',
			),
			array(
				'key' => 'field_product_hero_business_data',
				'label' => 'Business Parameters',
				'name' => 'product_hero_business_data',
				'type' => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Parameter',
				'sub_fields' => array(
					array(
						'key' => 'field_product_hero_biz_label',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
						'placeholder' => 'Lead Time',
					),
					array(
						'key' => 'field_product_hero_biz_value',
						'label' => 'Value',
						'name' => 'value',
						'type' => 'text',
						'placeholder' => '3-5 Business Days',
					),
					array(
						'key' => 'field_product_hero_biz_highlight',
						'label' => 'Highlight?',
						'name' => 'is_highlight',
						'type' => 'true_false',
						'ui' => 1,
						'ui_on_text' => 'Bold',
						'ui_off_text' => 'Normal',
					),
				),
			),

		),
		'location' => array(
			// No location rules needed for a module that is only cloned
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => false, // Disabled: This group is cloned into CPTs
	) );
}
