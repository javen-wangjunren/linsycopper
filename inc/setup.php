<?php
/**
 * Theme Setup & Configuration (主题初始化配置)
 * ==========================================================================
 * 文件作用:
 * 主题初始化配置文件。负责设置 WordPress 核心功能支持、强制覆盖 GeneratePress 默认布局、
 * 以及配置编辑器行为。
 *
 * 核心逻辑:
 * 1. 基础支持: 注册菜单、Title Tag、特色图片等。
 * 2. 布局接管: 强制全宽、无侧边栏、隐藏默认标题 (为 Tailwind 设计系统铺路)。
 * 3. 编辑器控制: 根据页面元数据决定是否启用古腾堡编辑器。
 *
 * 架构角色:
 * [Configuration Layer]
 * 它是主题的 "配置中心"，确保 GeneratePress 不会干扰我们的定制开发。
 *
 * 🚨 避坑指南:
 * 1. 不要移除 `generate_sidebar_layout` 等过滤器，否则布局会崩坏。
 * 2. 新增菜单位置请在 `register_nav_menus` 中添加。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ==================================================
 * I. 基础主题支持 (Theme Support)
 * ==================================================
 */
add_action( 'after_setup_theme', function() {
	// 启用 SEO 标题管理
	add_theme_support( 'title-tag' );
	
	// 启用特色图片
	add_theme_support( 'post-thumbnails' );
	
	// 注册菜单位置
	// [扩展]: 如果需要新增 Footer 菜单，请在此处添加
	register_nav_menus( array(
		'primary'         => 'Primary Menu',
		'footer_products' => 'Footer - Products',
		'footer_company'  => 'Footer - Company',
	) );
} );

/**
 * ==================================================
 * II. 布局与样式强制覆盖 (Layout Overrides)
 * ==================================================
 * 目的: 彻底接管 GeneratePress 的布局控制权，
 * 确保所有页面默认都是 "全宽" + "无侧边栏"，
 * 所有的 Padding/Margin 由 Tailwind 类名控制。
 */

// 1. 强制全局 "无侧边栏"
add_filter( 'generate_sidebar_layout', function( $layout ) {
	return 'no-sidebar';
}, 999 );

// 2. 强制页面容器为 "全宽" (2000px 只是一个足够大的值，实际上由 Tailwind max-w-* 控制)
add_filter( 'generate_container_width', function( $width ) {
	return '2000'; 
} );

// 3. 禁用 GP 默认标题 (由 Block/Hero 模块接管)
add_filter( 'generate_show_title', '__return_false' );

/**
 * ==================================================
 * III. 内容编辑器控制 (Editor Control)
 * ==================================================
 * 目的: 强制执行 "Visual First" SOP。
 * 1. 针对 Page 和 CPT 全局禁用古腾堡编辑器。
 * 2. 针对 Post (博客) 保留古腾堡，用于自由撰写内容。
 * 3. 移除 Page/CPT 默认富文本编辑器，强制使用 ACF 建模。
 */

// 1. 禁用古腾堡编辑器 (Block Editor) - 仅针对特定类型
add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
	// 需要禁用古腾堡的类型
	$disabled_types = array( 'page', 'product', 'industry' );
	
	if ( in_array( $post_type, $disabled_types, true ) ) {
		return false;
	}
	
	return $use_block_editor;
}, 100, 2 );

// 2. 移除默认的富文本编辑器 (Editor Support)
add_action( 'init', function() {
	// 针对 Page
	remove_post_type_support( 'page', 'editor' );
	
	// 针对 CPT (根据 inc/post-types.php 中的注册名)
	remove_post_type_support( 'product', 'editor' );
	remove_post_type_support( 'industry', 'editor' );
	
	// 注意: 'post' (博客) 保留 'editor' 支持以配合古腾堡使用
}, 100 );

add_filter( 'body_class', function( $classes ) {
	if ( is_admin() ) {
		return $classes;
	}

	$is_blog = is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_author() || is_date();

	if ( ! $is_blog ) {
		$classes[] = 'lc-app';
	}

	return $classes;
} );
