<?php
/**
 * Theme Assets Management (Scaffold Version)
 * ==========================================================================
 * 文件作用:
 * 负责管理 WordPress 前端页面的资源加载 (Enqueue Scripts & Styles)。
 * 核心任务是引入 Tailwind 编译后的 CSS 以及现代交互库 (Alpine.js)。
 *
 * 核心逻辑:
 * 1. 样式加载: 加载 Tailwind 编译后的 CSS，并使用文件修改时间作为版本号 (Cache Busting)。
 * 2. 交互库: 默认加载 Alpine.js (轻量级响应式框架)。
 * 3. 资源优化: 移除 WordPress 默认的 Emoji 脚本以减少请求。
 *
 * 🚨 使用指南:
 * - 字体: 请在 [I. 基础资源] 区域添加 Google Fonts。
 * - 插件: 如果需要 Swiper 或 GSAP，请在 [I. 基础资源] 区域取消注释。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', function() {

    // ==========================================================================
    // I. 基础资源 (Fonts & Libraries)
    // ==========================================================================

    $gp_google_font_handles = array(
        'generate-google-fonts',
        'generate-fonts',
        'generatepress-google-fonts',
        'generatepress-fonts',
    );

    foreach ( $gp_google_font_handles as $handle ) {
        wp_dequeue_style( $handle );
        wp_deregister_style( $handle );
    }

    add_filter( 'style_loader_tag', function( $html, $handle, $href, $media ) {
        if ( is_string( $href ) && strpos( $href, 'fonts.googleapis.com' ) !== false ) {
            return '';
        }

        return $html;
    }, 10, 4 );

    $fonts_css_file = 'assets/css/fonts.css';
    $fonts_css_path = get_stylesheet_directory() . '/' . $fonts_css_file;
    $fonts_css_uri  = get_stylesheet_directory_uri() . '/' . $fonts_css_file;

    if ( file_exists( $fonts_css_path ) ) {
        wp_enqueue_style(
            'lc-fonts',
            $fonts_css_uri,
            array(),
            filemtime( $fonts_css_path )
        );
    }

    // 2. Alpine.js (Lightweight Reactivity) [默认开启]
    // 现代 Web 开发标配，用于处理 Header, Menu, Modal 等交互
    // 使用 defer 策略避免阻塞渲染
    $alpine_collapse_file = 'assets/vendor/alpine/collapse.min.js';
    $alpine_collapse_path = get_stylesheet_directory() . '/' . $alpine_collapse_file;
    $alpine_collapse_uri  = get_stylesheet_directory_uri() . '/' . $alpine_collapse_file;

    wp_enqueue_script(
        'alpine-collapse',
        $alpine_collapse_uri,
        array(),
        file_exists( $alpine_collapse_path ) ? filemtime( $alpine_collapse_path ) : null,
        array( 'strategy' => 'defer' )
    );

    $alpine_file = 'assets/vendor/alpine/alpine.min.js';
    $alpine_path = get_stylesheet_directory() . '/' . $alpine_file;
    $alpine_uri  = get_stylesheet_directory_uri() . '/' . $alpine_file;

    wp_enqueue_script( 
        'alpine-js', 
        $alpine_uri, 
        array( 'alpine-collapse' ), 
        file_exists( $alpine_path ) ? filemtime( $alpine_path ) : null, 
        array( 'strategy' => 'defer' ) 
    );

    // 3. Swiper Slider [按需开启]
    if ( is_front_page() || is_page_template( 'templates/page-about.php' ) ) {
        $swiper_css_file = 'assets/vendor/swiper/swiper-bundle.min.css';
        $swiper_css_path = get_stylesheet_directory() . '/' . $swiper_css_file;
        $swiper_css_uri  = get_stylesheet_directory_uri() . '/' . $swiper_css_file;

        $swiper_js_file = 'assets/vendor/swiper/swiper-bundle.min.js';
        $swiper_js_path = get_stylesheet_directory() . '/' . $swiper_js_file;
        $swiper_js_uri  = get_stylesheet_directory_uri() . '/' . $swiper_js_file;

        wp_enqueue_style(
            'swiper-css',
            $swiper_css_uri,
            array(),
            file_exists( $swiper_css_path ) ? filemtime( $swiper_css_path ) : null
        );

        wp_enqueue_script(
            'swiper-js',
            $swiper_js_uri,
            array(),
            file_exists( $swiper_js_path ) ? filemtime( $swiper_js_path ) : null,
            array( 'in_footer' => true, 'strategy' => 'defer' )
        );
    }

    // ==========================================================================
    // II. 核心样式表 (Tailwind CSS)
    // ==========================================================================

    /**
     * 加载本地编译后的 Tailwind CSS
     * 
     * 编译链路: 
     * src/input.css -> (Tailwind CLI) -> assets/css/style.css -> (WordPress Enqueue)
     */
    $tailwind_css_file = 'assets/css/style.css';
    $tailwind_css_path = get_stylesheet_directory() . '/' . $tailwind_css_file;
    $tailwind_css_uri  = get_stylesheet_directory_uri() . '/' . $tailwind_css_file;

    // 只有当文件存在时才加载 (避免开发初期报错)
    if ( file_exists( $tailwind_css_path ) ) {
        wp_enqueue_style(
            'starter-tailwind', // Handle Name
            $tailwind_css_uri,
            array( 'generate-style' ), // 依赖: 确保在 GP 主样式之后加载，以便覆盖
            filemtime( $tailwind_css_path ) // 版本号: 自动缓存清除 (Cache Busting)
        );
    } else {
        // 自动生成时可能会缺失这个文件，静默失败或记录日志
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
             error_log( 'Tailwind CSS file not found at: ' . $tailwind_css_path );
        }
    }

    // ==========================================================================
    // III. 资源瘦身 (Performance Optimization)
    // ==========================================================================
    
    // 1. 禁用 WordPress Emoji 脚本 (减少 HTTP 请求)
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    // 2. [可选] 禁用 GP 原生脚本 (如果你打算完全重写 Header/Nav)
    // wp_dequeue_script( 'generate-menu' );
    // wp_dequeue_script( 'generate-navigation' );

}, 20 );
