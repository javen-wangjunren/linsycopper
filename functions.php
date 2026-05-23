<?php
/**
 * Child Theme - Main Controller (Scaffold Version)
 * ==========================================================================
 * 文件作用:
 * 这个文件是整个主题的"总指挥部" (Bootstrap Loader)。
 * 它只负责定义常量、加载模块文件和核心资源。
 * 
 * 核心逻辑:
 * 1. 初始化: 定义主题常量 (路径、版本)。
 * 2. 模块加载: 自动加载 `inc/` 目录下的功能模块。
 * 3. 样式加载: 加载父主题 GeneratePress 样式。
 * 4. 辅助功能: SVG 上传支持。
 *
 * 🚨 架构原则:
 * - ❌ 不要在这里写具体的业务逻辑 (add_action/filter)。
 * - ✅ 新功能请在 `inc/` 下新建文件，并在 `$inc_files` 数组中注册。
 * ==========================================================================
 */

// 🚫 防止直接访问
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==================================================
 * I. 主题常量定义 (Constants)
 * ==================================================
 * [TODO]: 新项目开始时，可以将 'STARTER_' 批量替换为项目特定前缀
 */
define( 'STARTER_VERSION', '1.0.0' );
define( 'STARTER_DIR', get_stylesheet_directory() );
define( 'STARTER_URI', get_stylesheet_directory_uri() );
define( 'STARTER_INC_DIR', STARTER_DIR . '/inc' );

/**
 * ==================================================
 * II. 核心模块加载 (Module Loading)
 * ==================================================
 */

$inc_files = [
    // 1. 核心架构 (必须保留)
    'setup.php',             // 主题初始化 / 基础支持
    'assets.php',            // 资源加载 (CSS/JS/Tailwind)
    'helpers.php',           // 全局工具函数
    'admin-filters.php',     // 后台体验优化 (SVG支持等)

    // 2. ACF 核心 (必须保留)
    'fields.php',            // ACF 字段自动加载器 (重命名 fields.php -> acf/fields.php)
    // 3. 业务模块 (新项目按需开启 - 默认注释)
    'post-types.php',        // 自定义文章类型 (CPT)
    'register-taxonomies.php', // 自定义分类法
    // 'template-functions.php',// 模板特定逻辑
    'options-page.php',      // 全局选项页
    'duplicate.php',         // 文章复制工具
    'api/consult-form.php',  // 询盘表单 API
    'api/product-search.php',
    'query-filters.php',     // 查询过滤器 (pre_get_posts)
    'blog-template-functions.php', // Blog 专用逻辑 (TOC等)
    // 'seo.php',               // SEO 逻辑
];




// B. 加载模块清单
foreach ( $inc_files as $file ) {
    $path = STARTER_INC_DIR . '/' . $file;

    if ( file_exists( $path ) ) {
        require_once $path;
    } else {
        // 开发模式下提示缺失文件
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( "⚠️ Starter Theme Note: 模块文件未创建 - {$file}" );
        }
    }
}

/**
 * ==================================================
 * III. 样式与资源加载 (Styles)
 * ==================================================
 */
add_action( 'wp_enqueue_scripts', function () {

    // 加载父主题样式 (GeneratePress)
    // 子主题的 Tailwind 样式由 inc/assets.php 负责加载
    $parent_theme = wp_get_theme()->parent();
    $parent_version = $parent_theme ? $parent_theme->get( 'Version' ) : wp_get_theme()->get( 'Version' );

    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css',
        [],
        $parent_version
    );
    
}, 10 );

/**
 * Load Cloudflare Turnstile Script
 */
function linsy_enqueue_turnstile() {
	wp_enqueue_script( 'cf-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'linsy_enqueue_turnstile' );

/**
 * ==================================================
 * IV. 通用辅助功能 (Utilities)
 * ==================================================
 */

// 允许上传 SVG (非常通用的需求，建议保留)
add_filter( 'upload_mimes', function( $mimes ) { 
    $mimes['svg'] = 'image/svg+xml'; 
    return $mimes; 
} ); 

add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) { 
    $filetype = wp_check_filetype( $filename, $mimes ); 
    return [ 
        'ext'             => $filetype['ext'], 
        'type'            => $filetype['type'], 
        'proper_filename' => $data['proper_filename'] 
    ]; 
}, 10, 4 );
