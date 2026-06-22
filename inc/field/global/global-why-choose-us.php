<?php
/**
 * Global Module: Why Choose Us
 * Location: Global Options Page > Global Modules Tab
 * 
 * Defines fields for the 3-column "Quality & Manufacturing" section.
 * 
 * Structure:
 * 1. Section Header (Title, Subtitle, CTA)
 * 2. Card 1: Certification (Image, Title, Desc)
 * 3. Card 2: Machine (Image, Title, Desc)
 * 4. Card 3: Logistics (Image, Title, Desc)
 *
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_global_why_choose_us',
		'title'  => 'Module: Why Choose Us',
		'fields' => array(
			// 1. Section Header
			array(
				'key' => 'field_global_wcu_title',
				'label' => 'Section Title',
				'name' => 'wcu_title',
				'type' => 'text',
				'default_value' => 'Quality & Manufacturing',
				'wrapper' => array( 'width' => '33' ),
			),
			array(
				'key' => 'field_global_wcu_subtitle',
				'label' => 'Section Subtitle',
				'name' => 'wcu_subtitle',
				'type' => 'textarea',
				'rows' => 2,
				'default_value' => '从实验室级别的合规性验证到高精度机械加工，我们确保每一件出厂产品都符合 ASTM 标准并具备卓越的物理性能。',
				'wrapper' => array( 'width' => '66' ),
			),
			array(
				'key' => 'field_global_wcu_cta',
				'label' => 'CTA Button Link',
				'name' => 'wcu_cta_link',
				'type' => 'link',
				'return_format' => 'array',
				'instructions' => 'Link to the full "Why Choose Us" page.',
			),

			// 2. Card 1: Certification
			array(
				'key' => 'field_global_wcu_tab_1',
				'label' => 'Card 1: Cert',
				'type' => 'tab',
			),
			array(
				'key' => 'field_global_wcu_cert_img',
				'label' => 'Certification Image',
				'name' => 'wcu_cert_image',
				'type' => 'image',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'wrapper' => array( 'width' => '20' ),
			),
			array(
				'key' => 'field_global_wcu_cert_title',
				'label' => 'Title',
				'name' => 'wcu_cert_title',
				'type' => 'text',
				'default_value' => 'Quality Compliance',
				'wrapper' => array( 'width' => '30' ),
			),
			array(
				'key' => 'field_global_wcu_cert_desc',
				'label' => 'Description',
				'name' => 'wcu_cert_desc',
				'type' => 'textarea',
				'rows' => 3,
				'wrapper' => array( 'width' => '50' ),
			),

			// 3. Card 2: Machine
			array(
				'key' => 'field_global_wcu_tab_2',
				'label' => 'Card 2: Machine',
				'type' => 'tab',
			),
			array(
				'key' => 'field_global_wcu_machine_img',
				'label' => 'Machine Image',
				'name' => 'wcu_machine_image',
				'type' => 'image',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'wrapper' => array( 'width' => '20' ),
			),
			array(
				'key' => 'field_global_wcu_machine_title',
				'label' => 'Title',
				'name' => 'wcu_machine_title',
				'type' => 'text',
				'default_value' => 'Precision Machining',
				'wrapper' => array( 'width' => '30' ),
			),
			array(
				'key' => 'field_global_wcu_machine_desc',
				'label' => 'Description',
				'name' => 'wcu_machine_desc',
				'type' => 'textarea',
				'rows' => 3,
				'wrapper' => array( 'width' => '50' ),
			),

			// 4. Card 3: Logistics
			array(
				'key' => 'field_global_wcu_tab_3',
				'label' => 'Card 3: Logistics',
				'type' => 'tab',
			),
			array(
				'key' => 'field_global_wcu_logistic_img',
				'label' => 'Logistics Image',
				'name' => 'wcu_logistic_image',
				'type' => 'image',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'wrapper' => array( 'width' => '20' ),
			),
			array(
				'key' => 'field_global_wcu_logistic_title',
				'label' => 'Title',
				'name' => 'wcu_logistic_title',
				'type' => 'text',
				'default_value' => 'Global Logistics',
				'wrapper' => array( 'width' => '30' ),
			),
			array(
				'key' => 'field_global_wcu_logistic_desc',
				'label' => 'Description',
				'name' => 'wcu_logistic_desc',
				'type' => 'textarea',
				'rows' => 3,
				'wrapper' => array( 'width' => '50' ),
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product', // Temp location, will be cloned
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => false, // Only active when cloned
		'description' => 'Global Why Choose Us module.',
	) );

}
