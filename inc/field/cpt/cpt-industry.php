<?php

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_cpt_industry_main',
		'title'  => 'Industry Fields',
		'fields' => array(
			array(
				'key' => 'field_industry_slide_desc',
				'label' => 'Slide Description',
				'name' => 'industry_slide_desc',
				'type' => 'textarea',
				'instructions' => 'Used in Industry Slider. Keep it concise (1–2 lines).',
				'required' => 0,
				'rows' => 3,
				'new_lines' => 'br',
			),
			array(
				'key' => 'field_industry_related_products',
				'label' => 'Related Products',
				'name' => 'industry_related_products',
				'type' => 'post_object',
				'instructions' => 'Select related Products to highlight for this industry.',
				'required' => 0,
				'allow_null' => 0,
				'return_format' => 'object',
				'multiple' => 1,
				'post_type' => array(
					0 => 'product',
				),
				'ui' => 1,
			),
			array(
				'key' => 'field_industry_slide_image',
				'label' => 'Slide Image',
				'name' => 'industry_slide_image',
				'type' => 'image',
				'instructions' => 'Used in Industry Slider. Recommended 4:3 (e.g., 1600×1200).',
				'required' => 0,
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'industry',
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
