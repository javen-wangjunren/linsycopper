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

if ( ! function_exists( 'get_nav_menu_locations' ) ) {
    function get_nav_menu_locations() { return array(); }
}

if ( ! function_exists( 'wp_get_nav_menu_object' ) ) {
    function wp_get_nav_menu_object( $menu ) { return false; }
}

if ( ! function_exists( 'wp_get_nav_menu_items' ) ) {
    function wp_get_nav_menu_items( $menu, $args = array() ) { return array(); }
}

if ( ! function_exists( 'locate_template' ) ) {
    function locate_template( $template_names, $load = false, $load_once = true, $args = array() ) { return ''; }
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
 * @param bool   $is_option  [新增] 是否从 Options Page 获取 (默认 false)
 * @return mixed 
 */ 
function get_flat_field( $field_name, $block = array(), $default = null, $is_option = false ) { 
    // 优先级 0: 强制从 Options Page 获取
    if ( $is_option ) {
        $val = get_field( $field_name, 'option' );
        return ( $val !== null && $val !== '' ) ? $val : $default;
    }

    if ( is_numeric( $block ) ) {
        $block = array( '_context_post_id' => (int) $block );
    } elseif ( is_object( $block ) && isset( $block->ID ) ) {
        $block = array( '_context_post_id' => (int) $block->ID );
    }

    // 优先级 1: 直接从 Block 传过来的扁平数组里拿 (性能最高，不查数据库) 
    if ( is_array( $block ) && isset( $block[ $field_name ] ) && $block[ $field_name ] !== '' ) { 
        return $block[ $field_name ]; 
    } 

    // 优先级 2: 环境兜底 (万一这不是一个 Block，而是一个普通页面模板) 
    $post_id = ( is_array( $block ) && isset( $block['_context_post_id'] ) ) ? $block['_context_post_id'] : false; 
    
    // 如果没有 context_post_id，尝试获取当前页面 ID (作为最后的兜底)
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    // 优先级 3: 最后尝试查数据库 (如果确实没在 block 中)
    if ( function_exists( 'get_field' ) && $post_id ) {
        $value = get_field( $field_name, $post_id );
        if ( $value !== '' && $value !== null ) {
            return $value;
        }
    }

    // 优先级 4: 返回默认值
    return $default;
}

/**
 * 获取产品主图 ID。
 *
 * 业务规则：
 * 1. 优先使用 Product Hero Gallery 的第一张图
 * 2. 如果 Gallery 为空，则回退到 Featured Image
 * 3. 若两者都不存在，返回 0
 *
 * @param int $post_id Product post ID.
 * @return int
 */
function linsy_get_product_primary_image_id( $post_id ) {
    $post_id = (int) $post_id;

    if ( ! $post_id ) {
        return 0;
    }

    if ( function_exists( 'get_field' ) ) {
        $gallery_ids = get_field( 'product_hero_gallery', $post_id );

        if ( is_array( $gallery_ids ) && ! empty( $gallery_ids ) ) {
            return (int) reset( $gallery_ids );
        }

        if ( is_numeric( $gallery_ids ) ) {
            return (int) $gallery_ids;
        }
    }

    return (int) get_post_thumbnail_id( $post_id );
}

/**
 * 读取兼容性 option 字段，优先取新的扁平字段，缺失时回退到旧 group 结构。
 *
 * @param string $field_name         新的扁平字段名。
 * @param string $legacy_group_name  旧 group 字段名。
 * @param mixed  $default            默认值。
 * @return mixed
 */
function linsy_get_option_field_compat( $field_name, $legacy_group_name = '', $default = null ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $default;
    }

    $value = get_field( $field_name, 'option' );

    if ( null !== $value && '' !== $value && array() !== $value ) {
        return $value;
    }

    if ( $legacy_group_name ) {
        $legacy_group = get_field( $legacy_group_name, 'option' );

        if ( is_array( $legacy_group ) && array_key_exists( $field_name, $legacy_group ) ) {
            $legacy_value = $legacy_group[ $field_name ];

            if ( null !== $legacy_value && '' !== $legacy_value && array() !== $legacy_value ) {
                return $legacy_value;
            }
        }
    }

    return $default;
}

/**
 * 获取主菜单树状结构
 * 
 * @return array
 */
function get_primary_menu_tree() {
    $locations = get_nav_menu_locations();
    if ( ! isset( $locations['primary'] ) ) {
        return [];
    }

    $menu = wp_get_nav_menu_object( $locations['primary'] );
    if ( ! $menu ) {
        return [];
    }

    $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
    if ( ! $menu_items ) {
        return [];
    }

    $menu_tree = [];
    $menu_items_by_id = [];

    // First pass: Index by ID and initialize children
    foreach ( $menu_items as $item ) {
        $item->children = [];
        $menu_items_by_id[ $item->ID ] = $item;
    }

    // Second pass: Build tree
    foreach ( $menu_items as $item ) {
        if ( $item->menu_item_parent ) {
            if ( isset( $menu_items_by_id[ $item->menu_item_parent ] ) ) {
                $menu_items_by_id[ $item->menu_item_parent ]->children[] = $item;
            }
        } else {
            $menu_tree[] = $item;
        }
    }

    return $menu_tree;
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
