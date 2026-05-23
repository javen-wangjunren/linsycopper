<?php

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key' => 'group_home_industry_slider_immersive',
		'title' => 'Home Industry Slider',
		'fields' => array(
			array(
				'key' => 'field_industry_slides',
				'label' => 'Slides',
				'name' => 'industry_slides',
				'type' => 'repeater',
				'instructions' => 'Add 2–6 slides. Each slide supports background image, label, title, description, two metrics, and CTA.',
				'required' => 0,
				'min' => 0,
				'layout' => 'block',
				'button_label' => 'Add Slide',
				'collapsed' => 'field_industry_slide_title',
				'sub_fields' => array(
					array(
						'key' => 'field_industry_slide_bg_image',
						'label' => 'Background Image',
						'name' => 'industry_slide_bg_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
						'library' => 'all',
						'required' => 0,
						'instructions' => 'Full-width background image.',
						'wrapper' => array(
							'width' => '50',
						),
					),
					array(
						'key' => 'field_industry_slide_kicker',
						'label' => 'Kicker',
						'name' => 'industry_slide_kicker',
						'type' => 'text',
						'required' => 0,
						'instructions' => 'Orange label (e.g., Automotive Industry).',
						'wrapper' => array(
							'width' => '50',
						),
					),
					array(
						'key' => 'field_industry_slide_title',
						'label' => 'Title',
						'name' => 'industry_slide_title',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => '',
						'required' => 0,
						'instructions' => 'Main headline (line breaks allowed).',
					),
					array(
						'key' => 'field_industry_description',
						'label' => 'Description',
						'name' => 'industry_description',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => '',
						'required' => 0,
						'instructions' => 'Short description (1–2 lines recommended).',
					),
					array(
						'key' => 'field_industry_slide_metrics',
						'label' => 'Metrics',
						'name' => 'industry_slide_metrics',
						'type' => 'repeater',
						'instructions' => 'Exactly 2 metrics as shown in the design.',
						'required' => 0,
						'min' => 2,
						'max' => 2,
						'layout' => 'table',
						'button_label' => 'Add Metric',
						'collapsed' => 'field_industry_slide_metric_label',
						'sub_fields' => array(
							array(
								'key' => 'field_industry_slide_metric_label',
								'label' => 'Label',
								'name' => 'industry_slide_metric_label',
								'type' => 'text',
								'required' => 0,
								'wrapper' => array(
									'width' => '50',
								),
							),
							array(
								'key' => 'field_industry_slide_metric_value',
								'label' => 'Value',
								'name' => 'industry_slide_metric_value',
								'type' => 'text',
								'required' => 0,
								'wrapper' => array(
									'width' => '50',
								),
							),
						),
					),
					array(
						'key' => 'field_industry_slide_cta_label',
						'label' => 'CTA Label',
						'name' => 'industry_slide_cta_label',
						'type' => 'text',
						'required' => 0,
						'default_value' => 'Get a Specific Quote',
						'wrapper' => array(
							'width' => '50',
						),
					),
					array(
						'key' => 'field_industry_slide_cta_link',
						'label' => 'CTA Link',
						'name' => 'industry_slide_cta_link',
						'type' => 'link',
						'required' => 0,
						'return_format' => 'array',
						'wrapper' => array(
							'width' => '50',
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 3,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => false,
	) );
} );
