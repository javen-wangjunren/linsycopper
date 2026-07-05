<?php
/**
 * ACF Options Page Configuration (全局设置页配置)
 * ==========================================================================
 * 文件作用:
 * 注册 ACF 全局设置页面 (Options Page)，用于管理全站通用的静态内容。
 * 包括页眉(Header)、页脚(Footer)以及通用的全局模块(Global Modules)。
 *
 * 核心逻辑:
 * 1. 注册父级菜单 "Global Settings"。
 * 2. 注册子菜单 "Header", "Footer", "Global Modules"。
 * 3. 以统一的 Accordion orchestrator 编排 Global Modules。
 * 4. 对历史 group 包裹数据执行一次性迁移，回归扁平字段结构。
 *
 * 架构角色:
 * [Global Data Store]
 * 作为全站通用数据的存储中心。模板文件 (Templates) 或 局部模板 (Partials) 在渲染
 * 通用模块时，如果当前页面没有特定内容，会回退读取此处的全局数据。
 *
 * 设计约束:
 * - 页面级容器统一放在本文件中。
 * - 模块源字段组只负责纯字段定义，不再承载页面级 Accordion/Tab。
 * ==========================================================================
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * 将历史 group 包裹的 option 数据复制到新的扁平字段中。
 *
 * @param string $legacy_group_name 旧 group 字段名。
 * @param array  $field_map         新字段名 => 新字段 key 的映射。
 * @return void
 */
function linsy_migrate_legacy_global_module_group( $legacy_group_name, array $field_map ) {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$legacy_data = get_field( $legacy_group_name, 'option' );

	if ( ! is_array( $legacy_data ) || empty( $legacy_data ) ) {
		return;
	}

	foreach ( $field_map as $field_name => $field_key ) {
		if ( ! array_key_exists( $field_name, $legacy_data ) ) {
			continue;
		}

		$current_value = get_field( $field_name, 'option' );

		if ( null !== $current_value && '' !== $current_value && array() !== $current_value ) {
			continue;
		}

		update_field( $field_key, $legacy_data[ $field_name ], 'option' );
	}
}

/**
 * 一次性迁移 Global Modules 的历史 group 数据。
 *
 * @return void
 */
function linsy_maybe_migrate_legacy_global_module_options() {
	if ( ! is_admin() || ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	if ( get_option( 'linsy_global_modules_migrated_v1' ) ) {
		return;
	}

	linsy_migrate_legacy_global_module_group(
		'global_why_choose_us',
		array(
			'wcu_title'          => 'field_global_wcu_title',
			'wcu_subtitle'       => 'field_global_wcu_subtitle',
			'wcu_cta_link'       => 'field_global_wcu_cta',
			'wcu_cert_image'     => 'field_global_wcu_cert_img',
			'wcu_cert_title'     => 'field_global_wcu_cert_title',
			'wcu_cert_desc'      => 'field_global_wcu_cert_desc',
			'wcu_machine_image'  => 'field_global_wcu_machine_img',
			'wcu_machine_title'  => 'field_global_wcu_machine_title',
			'wcu_machine_desc'   => 'field_global_wcu_machine_desc',
			'wcu_logistic_image' => 'field_global_wcu_logistic_img',
			'wcu_logistic_title' => 'field_global_wcu_logistic_title',
			'wcu_logistic_desc'  => 'field_global_wcu_logistic_desc',
		)
	);

	linsy_migrate_legacy_global_module_group(
		'global_certifications',
		array(
			'cert_title' => 'field_cert_title',
			'cert_desc'  => 'field_cert_desc',
			'cert_list'  => 'field_cert_list',
		)
	);

	update_option( 'linsy_global_modules_migrated_v1', gmdate( 'c' ), false );
}

add_action( 'admin_init', 'linsy_maybe_migrate_legacy_global_module_options' );

// ==========================================================================
// I. 注册设置页面 (Register Options Pages)
// ==========================================================================
if ( function_exists( 'acf_add_options_page' ) ) {

	// 1. 注册主菜单 (Parent)
	acf_add_options_page( array(
		'page_title' 	=> 'Global Settings',
		'menu_title'	=> 'Global Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> true, // 开启重定向，自动跳转到第一个子菜单
		'position'      => 2,
		'icon_url'      => 'dashicons-admin-site-alt3', // 🌐 图标
	) );

	// 2. 注册子菜单: Global Modules
	acf_add_options_sub_page( array(
		'page_title' 	=> 'Global Modules',
		'menu_title'	=> 'Global Modules',
		'parent_slug'	=> 'theme-general-settings',
		'menu_slug'     => 'theme-global-modules', // Explicit slug for location rules
	) );

	// 3. 注册子菜单: Header (可选)
	acf_add_options_sub_page( array(
		'page_title' 	=> 'Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
		'menu_slug'     => 'theme-header-settings',
	) );

	// 4. 注册子菜单: Footer (可选)
	acf_add_options_sub_page( array(
		'page_title' 	=> 'Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
		'menu_slug'     => 'theme-footer-settings',
	) );

}

// ==========================================================================
// II. 注册全局模块字段组 (Register Global Modules Fields)
// ==========================================================================
if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_options_global_modules',
		'title'  => 'Global Modules',
		'fields' => array(
			array(
				'key' => 'field_tab_global_modules_overview',
				'label' => 'Overview',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_acc_global_wcu_wrapper',
				'label' => 'Why Choose Us',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_options_global_wcu_clone',
				'label' => 'Why Choose Us Fields',
				'name' => 'global_wcu_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_global_why_choose_us',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_global_certs_wrapper',
				'label' => 'Certifications',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_options_global_certs_clone',
				'label' => 'Certifications Fields',
				'name' => 'global_certifications_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_home_certifications',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_global_faq_wrapper',
				'label' => 'FAQ',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_options_global_faq_clone',
				'label' => 'FAQ Fields',
				'name' => 'global_faq_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_global_faq',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_global_available_sizes_wrapper',
				'label' => 'Available Sizes',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_options_global_available_sizes_clone',
				'label' => 'Available Sizes Fields',
				'name' => 'global_available_sizes_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_global_available_sizes',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_global_consult_form_wrapper',
				'label' => 'Consult Form',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_options_global_consult_form_clone',
				'label' => 'Consult Form Fields',
				'name' => 'global_consult_form_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_global_consult_form',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_global_contact_wrapper',
				'label' => 'Global Contact',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_options_global_contact_clone',
				'label' => 'Global Contact Fields',
				'name' => 'global_contact_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_global_contact_section',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_global_modules_end',
				'label' => 'End',
				'type' => 'accordion',
				'endpoint' => 1,
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-global-modules',
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

}
