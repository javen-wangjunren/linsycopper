<?php
/**
 * Product Specifications Field Group
 * Location: Product (CPT) > Specifications Section
 * 
 * Defines fields for:
 * 1. Section Title & Subtitle
 * 2. Specifications Tables (Repeater of Repeaters)
 *    - Table Name
 *    - Table Data (Rows/Cols)
 *
 * @package GeneratePress_Child
 */

add_action( 'acf/init', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_product_specifications',
		'title'  => 'Product Specifications',
		'fields' => array(
			
			// ===================================
			// Module Wrapper: Accordion (Closed)
			// ===================================
			array(
				'key' => 'field_product_spec_accordion',
				'label' => 'Specifications Section',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),

			// 1. Section Header
			array(
				'key' => 'field_product_spec_title',
				'label' => 'Section Title',
				'name' => 'product_spec_title',
				'type' => 'text',
				'default_value' => 'Technical Specifications',
				'wrapper' => array(
					'width' => '50',
				),
			),
			array(
				'key' => 'field_product_spec_subtitle',
				'label' => 'Section Subtitle',
				'name' => 'product_spec_subtitle',
				'type' => 'textarea',
				'rows' => 2,
				'default_value' => 'Precision data for engineering decisions. All values tested per ASTM standards.',
				'wrapper' => array(
					'width' => '50',
				),
			),

			// 2. Specifications Tables (Outer Repeater)
			array(
				'key' => 'field_product_spec_tables',
				'label' => 'Specification Tables',
				'name' => 'product_spec_tables',
				'type' => 'repeater',
				'layout' => 'block', // Block layout to separate tables clearly
				'button_label' => 'Add New Spec Table',
				'instructions' => 'Add multiple tables (e.g., Chemical Composition, Mechanical Properties).',
				'sub_fields' => array(
					
					// Table Name
					array(
						'key' => 'field_product_spec_table_name',
						'label' => 'Table Name',
						'name' => 'spec_table_name',
						'type' => 'text',
						'placeholder' => 'e.g., Chemical Composition',
						'instructions' => 'Displayed with a numbered index (01, 02...).',
					),

					// Table Data (Inner Repeater)
					array(
						'key' => 'field_product_spec_table_data',
						'label' => 'Table Data',
						'name' => 'spec_table_data',
						'type' => 'repeater',
						'layout' => 'table', // Table layout for data entry
						'button_label' => 'Add Row',
						'instructions' => 'Row 1 is the Header. Maximum 4 columns.',
						'sub_fields' => array(
							array(
								'key' => 'field_product_spec_col_1',
								'label' => 'Col 1',
								'name' => 'col_1',
								'type' => 'text',
							),
							array(
								'key' => 'field_product_spec_col_2',
								'label' => 'Col 2',
								'name' => 'col_2',
								'type' => 'text',
							),
							array(
								'key' => 'field_product_spec_col_3',
								'label' => 'Col 3',
								'name' => 'col_3',
								'type' => 'text',
							),
							array(
								'key' => 'field_product_spec_col_4',
								'label' => 'Col 4',
								'name' => 'col_4',
								'type' => 'text',
							),
						),
					),
				),
			),

			array(
				'key' => 'field_product_spec_available_grades',
				'label' => 'Available Grades (Linked)',
				'name' => 'product_spec_available_grades',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Grade Link',
				'instructions' => 'Optional: Use this when you want each grade value to link to another Product page.',
				'collapsed' => 'field_product_spec_available_grade_label',
				'sub_fields' => array(
					array(
						'key' => 'field_product_spec_available_grade_label',
						'label' => 'Grade Label',
						'name' => 'grade_label',
						'type' => 'text',
						'required' => 0,
						'wrapper' => array(
							'width' => '33',
						),
					),
					array(
						'key' => 'field_product_spec_available_grade_product',
						'label' => 'Link To Product',
						'name' => 'grade_product_id',
						'type' => 'post_object',
						'post_type' => array(
							0 => 'product',
						),
						'return_format' => 'id',
						'ui' => 1,
						'required' => 0,
						'wrapper' => array(
							'width' => '67',
						),
					),
				),
			),
			
			// End Accordion
			array(
				'key' => 'field_product_spec_accordion_end',
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
		'menu_order' => 30, // After Applications (20)
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => false, // Only active when cloned
		'description' => 'Technical specifications tables.',
	) );
} );
