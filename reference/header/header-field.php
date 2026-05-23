<?php

/**
 * 角色：Header 模块的字段 Schema 定义
 * 位置：/inc/acf/field/header.php
 * 说明：页头模块的字段逻辑,挂载在global setting中的header设置中
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {
		acf_add_local_field_group( array(
			'key'    => 'group_3dp_header_settings',
			'title'  => 'Header Settings',
			'fields' => array(
				array(
					'key'   => 'field_header_tab_content',
					'label' => 'Content',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_header_brand_group',
					'label' => 'Brand & Global',
					'name'  => 'header_brand_global',
					'type'  => 'group',
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_header_logo_image',
							'label'         => 'Logo Image',
							'name'          => 'logo_image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'           => 'field_header_logo_width',
							'label'         => 'Desktop Width',
							'name'          => 'logo_width',
							'type'          => 'number',
							'suffix'        => 'px',
							'min'           => 16,
							'max'           => 320,
							'wrapper'       => array( 'width' => '25' ),
						),
						array(
							'key'           => 'field_header_logo_width_mobile',
							'label'         => 'Mobile Width',
							'name'          => 'logo_width_mobile',
							'type'          => 'number',
							'suffix'        => 'px',
							'min'           => 16,
							'max'           => 200,
							'wrapper'       => array( 'width' => '25' ),
						),
						array(
							'key'           => 'field_header_cta_button',
							'label'         => 'Primary CTA Button',
							'name'          => 'cta_button',
							'type'          => 'link',
							'wrapper'       => array( 'width' => '100' ),
						),
					),
				),
				array(
					'key'   => 'field_header_capabilities_tab',
					'label' => 'Capabilities Dropdown',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_header_capabilities_parent_link',
					'label'   => 'Parent Link (All Capabilities)',
					'name'    => 'header_capabilities_link',
					'type'    => 'link',
					'wrapper' => array( 'width' => '100' ),
				),
				array(
					'key'          => 'field_header_capabilities_items',
					'label'        => 'Capabilities Items',
					'name'         => 'header_capabilities_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'collapsed'    => 'field_header_capabilities_tech_name',
					'button_label' => 'Add Capability',
					'sub_fields'   => array(
						array(
							'key'     => 'field_header_capabilities_tech_name',
							'label'   => 'Tech Name',
							'name'    => 'tech_name',
							'type'    => 'text',
							'wrapper' => array( 'width' => '40' ),
						),
						array(
							'key'     => 'field_header_capabilities_tag',
							'label'   => 'Tag',
							'name'    => 'tag',
							'type'    => 'text',
							'wrapper' => array( 'width' => '30' ),
						),
						array(
							'key'     => 'field_header_capabilities_link',
							'label'   => 'Link',
							'name'    => 'link',
							'type'    => 'link',
							'wrapper' => array( 'width' => '30' ),
						),
						array(
							'key'     => 'field_header_capabilities_subtitle',
							'label'   => 'Subtitle',
							'name'    => 'subtitle',
							'type'    => 'text',
							'wrapper' => array( 'width' => '100' ),
						),
					),
				),
				array(
					'key'   => 'field_header_materials_tab',
					'label' => 'Materials Dropdown',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_header_materials_parent_link',
					'label'   => 'Parent Link (All Materials)',
					'name'    => 'header_materials_link',
					'type'    => 'link',
					'wrapper' => array( 'width' => '100' ),
				),
				array(
					'key'          => 'field_header_material_columns',
					'label'        => 'Material Columns',
					'name'         => 'header_material_columns',
					'type'         => 'repeater',
					'layout'       => 'block',
					'collapsed'    => 'field_header_material_column_title',
					'button_label' => 'Add Column',
					'sub_fields'   => array(
						array(
							'key'   => 'field_header_material_column_title',
							'label' => 'Column Title',
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_header_material_column_links',
							'label'        => 'Links',
							'name'         => 'links',
							'type'         => 'repeater',
							'layout'       => 'block',
							'collapsed'    => 'field_header_material_link_label',
							'button_label' => 'Add Link',
							'sub_fields'   => array(
								array(
									'key'   => 'field_header_material_link_label',
									'label' => 'Label',
									'name'  => 'label',
									'type'  => 'text',
									'wrapper' => array( 'width' => '40' ),
								),
								array(
									'key'           => 'field_header_material_link_target',
									'label'         => 'Select Material',
									'name'          => 'material_id',
									'type'          => 'post_object',
									'post_type'     => array( 'material' ),
									'return_format' => 'id',
									'ui'            => 1,
									'wrapper'       => array( 'width' => '60' ),
								),
							),
						),
						array(
							'key'     => 'field_header_material_view_all_link',
							'label'   => 'View All Link',
							'name'    => 'view_all_link',
							'type'    => 'link',
							'instructions' => 'Optional "View All" link at the bottom of the list',
						),
					),
				),
				array(
					'key'   => 'field_header_company_tab',
					'label' => 'Company Dropdown',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_header_company_items',
					'label'        => 'Company Items',
					'name'         => 'header_company_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'collapsed'    => 'field_header_company_title',
					'button_label' => 'Add Item',
					'sub_fields'   => array(
						array(
							'key'     => 'field_header_company_title',
							'label'   => 'Title',
							'name'    => 'title',
							'type'    => 'text',
							'wrapper' => array( 'width' => '50' ),
						),
						array(
							'key'     => 'field_header_company_link',
							'label'   => 'Link',
							'name'    => 'link',
							'type'    => 'link',
							'wrapper' => array( 'width' => '50' ),
						),
						array(
							'key'     => 'field_header_company_desc',
							'label'   => 'Description',
							'name'    => 'description',
							'type'    => 'text',
							'wrapper' => array( 'width' => '100' ),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-header',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'active'                => true,
			'style'                 => 'seamless',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
		) );
	} );
}
