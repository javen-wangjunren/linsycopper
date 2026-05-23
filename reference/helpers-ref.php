<?php
/**
 * Global Helper Functions (Scaffold Version)
 * ==========================================================================
 * 文件作用:
 * 提供全站通用的辅助函数，主要用于解决 ACF 字段获取、Block ID 生成以及模版渲染隔离等问题。
 *
 * 核心逻辑:
 * 1. 极简字段获取 (get_flat_field): 专为“扁平化数据结构”设计，自带默认值兜底。
 * 2. 安全 ID 生成 (_starter_get_block_id): 为 HTML 元素生成唯一且稳定的 ID。
 * 3. 模版隔离渲染 (_starter_render_block): 类似于 get_template_part，但支持传递局部变量。
 *
 * 架构角色:
 * 作为 GeneratePress Child 主题的基础设施层，支撑 blocks/ 目录下所有模块的逻辑实现。
 * 它是连接 ACF 数据与前端模版的桥梁。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ==========================================================================
// I. 环境兼容性 (Environment Compatibility)
// ==========================================================================

/**
 * 环境兜底：get_post_type
 * 作用：防止在非 WordPress 环境或静态代码分析工具中报错。
 */
if ( ! function_exists( 'get_post_type' ) ) {
    function get_post_type( $post = null ) { return ''; }
}

if ( ! function_exists( 'wp_set_object_terms' ) ) {
    function wp_set_object_terms( $object_id, $terms, $taxonomy, $append = false ) { return array(); }
}

// ==========================================================================
// II. ACF 与 Block 工具 (ACF & Block Utilities)
// ==========================================================================

/**
 * 获取安全的 Block ID (通用版)
 * 
 * 逻辑优先级：
 * 1. 固定 ID (Fixed ID): 模板调用时强制指定。
 * 2. 锚点 ID (Anchor): 用户在编辑器侧边栏手动输入的 HTML 锚点。
 * 3. 自动 ID (Block ID): ACF 自动生成的唯一 ID。
 * 4. 随机 ID: 最后的兜底。
 *
 * @param array|null $block    ACF Block 数据数组
 * @param string     $prefix   ID 前缀 (默认 'block')
 * @param string     $fixed_id [可选] 强制使用的固定 ID
 * @return string
 */
function _starter_get_block_id( $block = null, $prefix = 'block', $fixed_id = '' ) {
    // 1. 优先使用传入的固定 ID
    if ( $fixed_id !== '' ) {
        return $prefix . '-' . $fixed_id;
    }

    // 2. 其次使用编辑器设置的锚点 (Anchor)
    if ( is_array( $block ) && ! empty( $block['anchor'] ) ) {
        return $block['anchor'];
    }

    // 3. 再次使用 Block 自带的 ID
    if ( is_array( $block ) && ! empty( $block['id'] ) ) {
        return $prefix . '-' . $block['id'];
    }

    // 4. 生成随机 ID 兜底
    return $prefix . '-' . uniqid();
}

/** 
 * 新一代极简字段获取函数 (适配视觉优先 SOP) 
 * 
 * 作用：专门用于获取扁平化命名 (如 hero_title) 的 ACF 字段。 
 * 优势：去除了所有历史包袱，只保留最高效的取值和兜底逻辑。 
 * 
 * @param string $field_name 字段名 (如 'hero_title') 
 * @param array  $block      区块数据对象 
 * @param mixed  $default    默认值兜底 (防止空标签) 
 * @return mixed 
 */ 
function get_flat_field( $field_name, $block = array(), $default = null ) { 
    // 优先级 1: 直接从 Block 传过来的扁平数组里拿 (性能最高，不查数据库) 
    if ( isset( $block[ $field_name ] ) && $block[ $field_name ] !== '' ) { 
        return $block[ $field_name ]; 
    } 

    // 优先级 2: 环境兜底 (万一这不是一个 Block，而是一个普通页面模板) 
    $post_id = isset( $block['_context_post_id'] ) ? $block['_context_post_id'] : false; 
    
    // 如果没有 context_post_id，尝试获取当前页面 ID (作为最后的兜底)
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $value = get_field( $field_name, $post_id ); 

    // 如果拿到值且不为空，返回真实值；否则返回你设置的默认值 
    return ( $value !== null && $value !== false && $value !== '' ) ? $value : $default; 
}

// ==========================================================================
// III. 模版渲染 (Template Rendering)
// ==========================================================================

/**
 * 模块独立渲染函数 (Scoped Renderer)
 * 
 * 核心价值：
 * 1. 作用域隔离: 确保 $block 变量只在当前模版生效，不污染全局。
 * 2. 路径简化: 自动补全 .php 后缀。
 * 
 * @param string $template_path 模块相对路径 (例如 'blocks/global/hero/render')
 * @param array  $block_data    传递给模版的数据数组 (在模版中通过 $block 访问)
 */
function _starter_render_block( $template_path, $block_data = array() ) {
    // 将数据赋值给 $block 变量，这是模版中约定的标准变量名
    $block = $block_data;
    
    // 自动补全文件后缀
    if ( substr( $template_path, -4 ) !== '.php' ) {
        $template_path .= '.php';
    }

    // 定位并加载模版
    // 使用 locate_template 允许子主题覆盖（虽然我们本身就在子主题里，但这是一个好习惯）
    $located = locate_template( $template_path );

    if ( $located ) {
        include $located;
    } else {
        // 开发环境下提示缺失模版
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            echo "<!-- Template not found: {$template_path} -->";
        }
    }
}