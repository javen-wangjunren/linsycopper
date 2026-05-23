<?php
/**
 * ACF Fields: Surface Finish
 * 
 * 用于定义 Surface Finish CPT 的 ACF 字段组
 * 这个文档是Single Surface Finish 模板的 后端代码定义代码
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key' => 'group_surface_finish_details',
		'title' => 'Surface Finish Details',
		'fields' => array(
			// =================================================================
			// Tab 1: Overview
			// =================================================================
			array(
				'key' => 'tab_sf_overview',
				'label' => 'Overview',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'placement' => 'top',
				'endpoint' => 0,
			),
			// Module 1: Hero Banner (Accordion)
			array(
				'key' => 'acc_sf_hero',
				'label' => 'Hero Banner',
				'name' => '',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 1. Hero Section (Clone)
			array(
				'key' => 'field_sf_hero_clone',
				'label' => 'Hero Banner',
				'name' => 'sf_hero',
				'type' => 'clone',
				'display' => 'seamless', // 必须是 seamless
				'clone' => array(
					0 => 'group_hero_banner',
				),
				'prefix_label' => 0,
				'prefix_name' => 0, // 绝对不允许开启 prefix
			),
			// End Accordion
			array(
				'key' => 'acc_sf_hero_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// Module 2: Basic Info (Accordion)
			array(
				'key' => 'acc_sf_basic_info',
				'label' => 'Basic Info',
				'name' => '',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 2. Basic Info
			array(
				'key' => 'field_sf_related_capabilities',
				'label' => 'Applicable Capabilities',
				'name' => 'related_capabilities',
				'type' => 'relationship',
				'instructions' => 'Select the capabilities (processes) this surface finish is applicable to.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'capability',
				),
				'taxonomy' => '',
				'filters' => array(
					0 => 'search',
				),
				'elements' => '',
				'min' => '',
				'max' => '',
				'return_format' => 'object',
			),
			// End Accordion
			array(
				'key' => 'acc_sf_basic_info_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// =================================================================
			// Tab 2: Technical
			// =================================================================
			array(
				'key' => 'tab_sf_technical',
				'label' => 'Technical',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'placement' => 'top',
				'endpoint' => 0,
			),
			// Module 3: Visual Comparison (Accordion)
			array(
				'key' => 'acc_sf_visual',
				'label' => 'Visual Comparison',
				'name' => '',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 3. Visual Comparison (Clone)
			array(
				'key' => 'field_sf_visual_clone',
				'label' => 'Visual Comparison',
				'name' => 'sf_visual',
				'type' => 'clone',
				'display' => 'seamless', 
				'clone' => array(
					0 => 'group_visual_comparison',
				),
				'prefix_label' => 0,
				'prefix_name' => 0, // 绝对不允许开启 prefix
			),
			// End Accordion
			array(
				'key' => 'acc_sf_visual_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// Module 4: Technical Compatibility (Accordion)
			array(
				'key' => 'acc_sf_compat',
				'label' => 'Technical Compatibility',
				'name' => '',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 4. Technical Compatibility (Clone)
			array(
				'key' => 'field_sf_compat_clone',
				'label' => 'Technical Compatibility',
				'name' => 'sf_compat',
				'type' => 'clone',
				'display' => 'seamless',
				'clone' => array(
					0 => 'group_technical_compatibility',
				),
				'prefix_label' => 0,
				'prefix_name' => 0, // 绝对不允许开启 prefix
			),
			// End Accordion
			array(
				'key' => 'acc_sf_compat_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// =================================================================
			// Tab 3: Guide
			// =================================================================
			array(
				'key' => 'tab_sf_guide',
				'label' => 'Guide',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'placement' => 'top',
				'endpoint' => 0,
			),
			// Module 5: Design Guide (Accordion)
			array(
				'key' => 'acc_sf_guide',
				'label' => 'Design Guide',
				'name' => '',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 5. Design Guide (Clone)
			array(
				'key' => 'field_sf_guide_clone',
				'label' => 'Design Guide',
				'name' => 'sf_guide',
				'type' => 'clone',
				'display' => 'seamless',
				'clone' => array(
					0 => 'group_surface_finish_design_guide',
				),
				'prefix_label' => 0,
				'prefix_name' => 0, // 绝对不允许开启 prefix
			),
			// End Accordion
			array(
				'key' => 'acc_sf_guide_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// Module 6: Table Data Summary (Accordion)
			array(
				'key' => 'acc_sf_table_summary',
				'label' => 'Table Data Summary',
				'name' => '',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 6. Table Data Summary (Clone)
			array(
				'key' => 'field_sf_table_summary_clone',
				'label' => 'Table Data Summary',
				'name' => 'sf_table_summary',
				'type' => 'clone',
				'display' => 'seamless',
				'clone' => array(
					0 => 'group_sf_table_summary',
				),
				'prefix_label' => 0,
				'prefix_name' => 0, // 保持原始字段名 (sf_lead_time 等)，不加前缀
			),
			// End Accordion
			array(
				'key' => 'acc_sf_table_summary_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// Module 7: Commercial Parameters (Accordion)
			array(
				'key' => 'acc_sf_cp',
				'label' => 'Commercial Parameters',
				'name' => '',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			// 7. Commercial Parameters (Clone)
			array(
				'key' => 'field_sf_cp_clone',
				'label' => 'Commercial Parameters',
				'name' => 'sf_cp',
				'type' => 'clone',
				'display' => 'seamless',
				'clone' => array(
					0 => 'group_surface_finish_commercial_params',
				),
				'prefix_label' => 0,
				'prefix_name' => 0, // 绝对不允许开启 prefix
			),
			// End Accordion
			array(
				'key' => 'acc_sf_cp_end',
				'label' => '',
				'name' => '',
				'type' => 'accordion',
				'endpoint' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'surface-finish',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'the_content',
		),
		'active' => true,
		'description' => '',
	) );

endif;
