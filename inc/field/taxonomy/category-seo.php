<?php
/**
 * Category SEO Content / Technical Guide Fields
 * ==========================================================================
 * Location: Product Taxonomies (Shape, Material, Grade)
 * 
 * Fields:
 * 1. tech_guide_title (Text)
 * 2. tech_guide_desc (Textarea)
 * 3. tech_guide_image (Image ID)
 * 4. tech_guide_badge_title (Text)
 * 5. tech_guide_benefits (Repeater)
 * 6. tech_guide_apps (Repeater)
 * 
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

acf_add_local_field_group(array(
	'key' => 'group_category_seo_content',
	'title' => 'Category Technical Guide (SEO)',
	'fields' => array(
		array(
			'key' => 'field_tech_guide_accordion',
			'label' => 'Technical Guide',
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 0,
			'multi_expand' => 0,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_tech_guide_title',
			'label' => 'Guide Heading',
			'name' => 'tech_guide_title',
			'type' => 'text',
			'instructions' => 'e.g., Technical Guide: Copper Sheet Alloys',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_tech_guide_image',
			'label' => 'Guide Image',
			'name' => 'tech_guide_image',
			'type' => 'image',
			'instructions' => 'Right side image (Portrait or Square)',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_tech_guide_desc',
			'label' => 'Introduction Text',
			'name' => 'tech_guide_desc',
			'type' => 'textarea',
			'instructions' => 'Introductory paragraph below the heading.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 4,
			'new_lines' => 'br', // Auto <br>
		),
		array(
			'key' => 'field_tech_guide_badge_title',
			'label' => 'Badge Title',
			'name' => 'tech_guide_badge_title',
			'type' => 'text',
			'instructions' => 'e.g., ASTM (Leave empty to hide)',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'ASTM',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_tech_guide_benefits',
			'label' => 'Key Properties & Benefits',
			'name' => 'tech_guide_benefits',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_benefit_title',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Add Property',
			'sub_fields' => array(
				array(
					'key' => 'field_benefit_title',
					'label' => 'Label',
					'name' => 'benefit_title',
					'type' => 'text',
					'instructions' => 'e.g. Conductivity',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '30',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_benefit_desc',
					'label' => 'Description',
					'name' => 'benefit_desc',
					'type' => 'text',
					'instructions' => 'e.g. 101% IACS conductivity...',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '70',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
		array(
			'key' => 'field_tech_guide_apps',
			'label' => 'Applications',
			'name' => 'tech_guide_apps',
			'type' => 'repeater',
			'instructions' => 'Temporary: Use text for now. Will upgrade to Relationship field later.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Add Application',
			'sub_fields' => array(
				array(
					'key' => 'field_app_name',
					'label' => 'Application Name',
					'name' => 'app_name',
					'type' => 'text',
					'instructions' => 'e.g. Electric & Electronics',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_shape',
			),
		),
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_material',
			),
		),
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_grade',
			),
		),
	),
	'menu_order' => 5,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => 'SEO Content / Technical Guide section at the bottom of the taxonomy page.',
));

endif;
