<?php
/**
 * Post Duplication Functionality (文章快速复制功能)
 * ==========================================================================
 * 文件作用:
 * 为特定的自定义文章类型 (CPT) 添加 "Duplicate" (复制) 功能。
 * 允许管理员在后台列表页一键复制文章（包括标题、内容、分类和 Meta 字段），
 * 并自动跳转到新文章的编辑页面。
 *
 * 核心逻辑:
 * 1. UI 增强: 在文章列表的 "行操作" (Row Actions) 中添加 "Duplicate" 链接。
 * 2. 逻辑处理: 监听自定义的 `admin_action` 钩子，执行复制操作。
 * 3. 数据克隆: 深度复制文章的所有属性，包括 ACF 字段 (post_meta) 和分类 (Taxonomies)。
 *
 * 架构角色:
 * [Admin Utility]
 * 这是一个纯后台工具，旨在提高内容录入效率，特别是对于结构复杂的 CPT (如 Material)。
 *
 * 🚨 避坑指南:
 * 1. 权限控制: 必须检查 `current_user_can('edit_posts')` 和 Nonce，防止未授权访问。
 * 2. Meta 复制: 使用 `add_post_meta` 循环插入，以支持同一个 Key 有多个值的情况 (虽然 ACF 通常不用，但原生字段可能用到)。
 * 3. 状态重置: 新复制的文章状态强制设为 'draft' (草稿)，避免意外发布重复内容。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ==========================================================================
// I. UI 增强: 添加复制链接
// ==========================================================================

/**
 * 在文章列表的操作行添加 "Duplicate" 链接
 * 
 * @param array  $actions 现有的操作链接数组 (Edit, Quick Edit, Trash, View)
 * @param object $post    当前文章对象
 * @return array 修改后的操作链接数组
 */
function lc_duplicate_post_link( $actions, $post ) {
    // 1. 类型限制: 仅针对 material 和 capability 类型开启
    // 如果后续有新的 CPT 需要此功能，添加到数组中即可
    if ( ! in_array( $post->post_type, array( 'material', 'capability', 'product' ) ) ) {
        return $actions;
    }

    // 2. 权限检查
    if ( ! current_user_can( 'edit_posts' ) ) {
        return $actions;
    }

    // 3. 构建操作 URL
    // 使用 wp_nonce_url 生成带 nonce 的安全链接
    $url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => 'lc_duplicate_post_as_draft', // 自定义 Action 名称
                'post'   => $post->ID,
            ),
            admin_url( 'admin.php' ) // 指向 admin.php 处理 admin_action 钩子
        ),
        basename( __FILE__ ), // Nonce Action
        'duplicate_nonce'     // Nonce Name
    );

    // 4. 插入链接
    $actions['duplicate'] = '<a href="' . esc_url( $url ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

    return $actions;
}

add_filter( 'post_row_actions', 'lc_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'lc_duplicate_post_link', 10, 2 );

// ==========================================================================
// II. 逻辑处理: 执行复制
// ==========================================================================

/**
 * 处理复制逻辑
 * 触发时机: 访问 admin.php?action=lc_duplicate_post_as_draft
 */
add_action( 'admin_action_lc_duplicate_post_as_draft', 'lc_duplicate_post_as_draft' );

function lc_duplicate_post_as_draft() {
    
    // 1. 安全与完整性检查
    // 检查是否提供了 post ID
    if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) ) || ( isset( $_REQUEST['action'] ) && 'lc_duplicate_post_as_draft' != $_REQUEST['action'] ) ) {
        wp_die( 'No post to duplicate has been supplied!' );
    }

    // 检查 Nonce 有效性
    if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    // 2. 获取原始数据
    $post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
    $post    = get_post( $post_id );

    // 3. 准备新数据
    $current_user    = wp_get_current_user();
    $new_post_author = $current_user->ID;

    if ( isset( $post ) && $post != null ) {

        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => '', // 留空，让 WordPress 自动基于新标题生成唯一的 slug
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft', // 强制设为草稿
            'post_title'     => $post->post_title . ' (Copy)', // 标题后加后缀
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );

        // 4. 插入新文章
        $new_post_id = wp_insert_post( $args );

        // 5. 复制分类 (Taxonomies)
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( $taxonomies as $taxonomy ) {
            $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
            wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
        }

        // 6. 复制 Meta 字段 (包括 ACF 数据)
        $post_meta_infos = get_post_meta( $post_id );
        if ( count( $post_meta_infos ) != 0 ) {
            foreach ( $post_meta_infos as $meta_key => $meta_values ) {
                // 跳过部分内部字段 (可选优化，目前全量复制)
                foreach ( $meta_values as $meta_value ) {
                    // 使用 add_post_meta 并在末尾用 wp_slash 处理，防止反斜杠丢失
                    add_post_meta( $new_post_id, $meta_key, wp_slash( $meta_value ) );
                }
            }
        }

        // 7. 完成并跳转
        // 直接跳转到新文章的编辑页面，方便用户立即修改
        wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
        exit;
        
    } else {
        wp_die( 'Post creation failed, could not find original post: ' . $post_id );
    }
}
