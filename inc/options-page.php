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
 * 3. 定义 "Global Modules" 的字段组，使用 ACF Clone 功能复用已有的 Block 字段组。
 *
 * 架构角色:
 * [Global Data Store]
 * 作为全站通用数据的存储中心。模板文件 (Templates) 或 局部模板 (Partials) 在渲染
 * 通用模块（如 CTA, Why Choose Us）时，如果当前页面没有特定内容，
 * 会回退 (Fallback) 读取此处的全局数据。
 *
 * 🚨 避坑指南:
 * 1. 字段名冲突: 为了防止多个 Clone 字段组中的同名字段（如 title, description）冲突，
 *    我们采用了 "Group Wrapping" 策略：每个 Clone 都在一个独立的 Group 字段中。
 *    例如: global_why_choose_us (Group) -> wcu_clone (Clone)。
 *    这样数据存储结构为: options_global_why_choose_us['title']，避免了扁平化存储导致的覆盖。
 * 2. Menu Slug: 子页面的 menu_slug 必须显式定义，确保与 Location Rules 中的判断一致。
 * ==========================================================================
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
			
			// ------------------------------------------------------------------
			// Module 1: Why Choose Us (Cloned)
			// ------------------------------------------------------------------
			// 架构说明: 
			// 使用 Group 包裹是为了建立命名空间 (Namespace)，
			// 这样即使其他模块也有 'title' 字段，也不会冲突。
			// 获取方式: $data = get_field('global_why_choose_us', 'option');
			// ------------------------------------------------------------------
			array(
				'key' => 'field_options_global_wcu_wrapper',
				'label' => 'Module: Why Choose Us',
				'name' => 'global_why_choose_us', 
				'type' => 'group',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_options_global_wcu_clone',
						'label' => 'Why Choose Us Fields',
						'name' => 'wcu_clone',
						'type' => 'clone',
						'clone' => array(
							0 => 'group_global_why_choose_us', // 引用 inc/field/module/global-why-choose-us.php
						),
						'display' => 'seamless',
						'layout' => 'block',
						'prefix_label' => 0,
						'prefix_name' => 0,
					),
				),
			),

			// ------------------------------------------------------------------
			// Module 2: Certifications (Cloned)
			// ------------------------------------------------------------------
			array(
				'key' => 'field_options_global_certs_wrapper',
				'label' => 'Module: Certifications',
				'name' => 'global_certifications',
				'type' => 'group',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_options_global_certs_clone',
						'label' => 'Certifications Fields',
						'name' => 'certs_clone',
						'type' => 'clone',
						'clone' => array(
							0 => 'group_home_certifications', // 引用 inc/field/global/certifications.php
						),
						'display' => 'seamless',
						'layout' => 'block',
						'prefix_label' => 0,
						'prefix_name' => 0,
					),
				),
			),

			// Future modules (e.g., CTA, Newsletter) can be added here...

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
