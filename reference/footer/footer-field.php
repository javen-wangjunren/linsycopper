<?php

/**
 * 角色：Footer 模块的字段 Schema 定义
 * 位置：/inc/acf/field/footer.php
 * 说明：页脚模块的字段逻辑,挂载在global setting中的footer设置中
 */


if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {
		acf_add_local_field_group( array(
			'key'    => 'group_3dp_footer_settings',
			'title'  => 'Footer Settings',
			'fields' => array(
				array(
					'key'   => 'field_footer_left_info',
					'label' => 'Brand Info',
					'name'  => 'footer_left_info',
					'type'  => 'group',
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_footer_logo_image',
							'label'         => 'Logo Image',
							'name'          => 'logo_image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'          => 'field_footer_contact_list',
							'label'        => 'Contact Information',
							'name'         => 'contact_list',
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => 'Add Contact Item',
							'collapsed'    => 'field_footer_contact_type',
							'sub_fields'   => array(
								array(
									'key'     => 'field_footer_contact_type',
									'label'   => 'Label/Type',
									'name'    => 'label',
									'type'    => 'text',
									'placeholder' => 'e.g. Phone, Email, Address',
									'wrapper' => array( 'width' => '30' ),
								),
								array(
									'key'     => 'field_footer_contact_icon',
									'label'   => 'Icon SVG',
									'name'    => 'icon_svg',
									'type'    => 'textarea',
									'rows'    => 3,
									'instructions' => 'Paste SVG code here. Remove width/height for auto-scaling.',
									'wrapper' => array( 'width' => '70' ),
								),
								array(
									'key'       => 'field_footer_contact_content',
									'label'     => 'Content',
									'name'      => 'content',
									'type'      => 'textarea',
									'rows'      => 3,
									'new_lines' => 'br',
									'wrapper'   => array( 'width' => '100' ),
								),
							),
						),
					),
				),
				array(
					'key'           => 'field_footer_materials_view_all',
					'label'         => 'Materials View All Link',
					'name'          => 'materials_view_all',
					'type'          => 'link',
					'instructions'  => 'Add the "View All Materials" link for the footer menu.',
					'wrapper'       => array( 'width' => '100' ),
				),
				array(
					'key'           => 'field_footer_copyright',
					'label'         => 'Copyright Text',
					'name'          => 'footer_copyright',
					'type'          => 'text',
					'instructions'  => '使用 {year} 自动替换为当前年份。',
					'default_value' => '© {year} NOW3DP MANUFACTURING INC. ALL RIGHTS RESERVED.',
				),
				array(
					'key'          => 'field_footer_social_links',
					'label'        => 'Social Media Links',
					'name'         => 'footer_social_links',
					'type'         => 'repeater',
					'layout'       => 'block',
					'collapsed'    => 'field_footer_social_name',
					'button_label' => 'Add Social Link',
					'sub_fields'   => array(
						array(
							'key'     => 'field_footer_social_name',
							'label'   => 'Platform Name',
							'name'    => 'name',
							'type'    => 'text',
							'wrapper' => array( 'width' => '30' ),
						),
						array(
							'key'     => 'field_footer_social_url',
							'label'   => 'URL',
							'name'    => 'url',
							'type'    => 'url',
							'wrapper' => array( 'width' => '70' ),
						),
						array(
							'key'         => 'field_footer_social_icon',
							'label'       => 'Icon SVG',
							'name'        => 'icon_svg',
							'type'        => 'textarea',
							'rows'        => 3,
							'instructions' => 'Paste SVG code here. Remove width/height attributes for better scaling.',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-footer',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		) );
	} );
}
