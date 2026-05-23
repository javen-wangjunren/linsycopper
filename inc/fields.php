<?php
/**
 * ACF Field Auto-Loader (Scaffold Version)
 * ==========================================================================
 * 文件作用:
 * 集中自动加载所有模块的 ACF 字段定义文件 (PHP Export)。
 * 
 * 核心逻辑:
 * 1. 扫描 `inc/field/` 目录及其子目录：加载所有 PHP 字段定义文件。
 *
 * 架构角色:
 * [Configuration Loader]
 * 这个文件是 ACF 字段配置的"总入口"。
 * 它确保了所有的 PHP 字段定义文件被 WordPress 识别并执行。
 * 使用递归扫描机制，支持任意深度的目录结构。
 *
 * 🚨 使用指南:
 * 1. 将 ACF 导出的 PHP 代码保存为 .php 文件。
 * 2. 根据字段作用域放入对应的子目录 (如 pages/home.php)。
 * 3. 刷新页面，字段即生效。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 仅在 ACF 插件激活且可用时执行，防止未安装插件导致致命错误
if ( function_exists( 'acf_add_local_field_group' ) ) {
    
    // 定义基础目录路径
    $base_dir = get_stylesheet_directory() . '/inc/field/';
    
    if ( is_dir( $base_dir ) ) {
        // 使用递归迭代器扫描所有 .php 文件
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $base_dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );

        foreach ( $iterator as $file ) {
            if ( $file->isFile() && $file->getExtension() === 'php' ) {
                require_once $file->getPathname();
                // 调试日志 (可选，开发时开启)
                // error_log('ACF Loaded: ' . $file->getPathname());
            }
        }
    } else {
        // 目录不存在时的警告
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( "ACF Loader Error: Directory not found - {$base_dir}" );
        }
    }
}
