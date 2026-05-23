<?php
/**
 * Template Name: Single Surface Finish 
 * 这个文档是Single Surface Finish 模板的前端渲染代码
 * Description: The template for displaying a single Surface Finish CPT.
 * 
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// ==========================================
// 1. Hero Banner (Global Clone)
// ==========================================
// 使用统一的渲染函数，无需传递 prefix，因为字段名已统一为 hero_title 等。
if ( function_exists( '_starter_render_block' ) ) {
	_starter_render_block( 'blocks/global/hero-banner/render' );
}

// ==========================================
// 2. Visual Comparison (Render Block)
// ==========================================
// 渲染视觉对比模块，字段名统一为 visual_title 等。
if ( function_exists( '_starter_render_block' ) ) {
	_starter_render_block( 'blocks/global/visual-comparison/render' );
}

// ==========================================
// 3. Technical Compatibility (Render Block)
// ==========================================
// 渲染技术兼容性模块（工艺与材料）。
if ( function_exists( '_starter_render_block' ) ) {
	_starter_render_block( 'blocks/global/surface-finish-compatibility/render' );
}

// ==========================================
// 4. Design Guide (Render Block)
// ==========================================
// 渲染设计指南模块（最佳实践）。
if ( function_exists( '_starter_render_block' ) ) {
	_starter_render_block( 'blocks/global/surface-finish-design-guide/render' );
}

// ==========================================
// 5. Commercial Parameters (Render Block)
// ==========================================
// 渲染商业参数模块（价值/良率/成本）。
if ( function_exists( '_starter_render_block' ) ) {
	_starter_render_block( 'blocks/global/surface-finish-commercial-parameters/render' );
}

// ==========================================
// 6. Global CTA (Render Block)
// ==========================================
// 渲染全局 CTA 模块。这里传递 'id' 是为了能在 render 模版中区分或添加特定锚点，
// 但对于字段获取来说，它依然是无前缀的 cta_title。
if ( function_exists( '_starter_render_block' ) ) {
	_starter_render_block( 'blocks/global/cta/render', array( 
		'id' => 'cta' 
	) );
}

get_footer();
