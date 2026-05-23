<?php
/**
 * 模板专用业务逻辑函数库 (Template Functions)
 * ==========================================================================
 * 文件作用:
 * 存放与特定页面模板紧密相关的业务前端相关的逻辑函数，例如复杂的 WP_Query 构建、
 * 数据预处理等。
 *
 * 区别于 helpers.php:
 * - helpers.php: 通用工具，不包含业务逻辑 (Infrastructure)
 * - template-functions.php: 特定业务逻辑 (Business Logic)
 * 
 * 区别于 Admin 文件 (admin-filters.php, duplicate.php):
 * - admin-filters.php: 仅在 WP 后台运行，用于增强列表页筛选和批量操作。
 * - duplicate.php: 仅在 WP 后台运行，提供文章复制工具。
 * - template-functions.php: 仅在 WP 前端运行，为页面模板提供数据支持。
 * 
 * 为什么不合并？
 * 1. 关注点分离 (SoC): 前端逻辑与后台逻辑完全不同，分开维护更清晰。
 * 2. 性能优化: 后台逻辑不需要在前端加载，前端逻辑也不需要在后台运行。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 构建 All Materials 页面的查询对象
 * 
 * 逻辑：
 * 1. 获取 ACF 设置的分页数量、排序规则。
 * 2. 处理 URL 参数 (process, type, cost) 并转换为 Meta Query / Tax Query。
 * 3. 返回配置好的 WP_Query 对象。
 * 
 * @return WP_Query
 */
function _3dp_build_material_query() {
    // 1. 获取基础配置
    $acf_posts_per_page = get_field( 'all_materials_posts_per_page' );
    
    // 修复：如果数据库中存的是旧默认值 60，或者为空，则强制使用 12
    if ( $acf_posts_per_page == 60 || empty( $acf_posts_per_page ) ) {
        $posts_per_page = 12;
    } else {
        $posts_per_page = (int) $acf_posts_per_page;
    }

    $orderby = (string) ( get_field( 'all_materials_orderby' ) ?: 'title' );
    $order   = (string) ( get_field( 'all_materials_order' ) ?: 'ASC' );
    $paged   = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // 2. 构建基础参数
    $args = array(
        'post_type'      => 'material',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'orderby'        => $orderby,
        'order'          => $order,
        'paged'          => $paged,
        'tax_query'      => array( 'relation' => 'AND' ),
        'meta_query'     => array( 'relation' => 'AND' ),
    );

    if ( ! empty( $_GET['q'] ) ) {
        $q = trim( sanitize_text_field( (string) $_GET['q'] ) );
        if ( '' !== $q ) {
            $args['s'] = $q;
            $args['search_columns'] = array( 'post_title' );
        }
    }

    // 3. 获取默认筛选值 (ACF)
    $default_processes = get_field( 'all_materials_default_processes' ); // returns IDs
    $default_types     = get_field( 'all_materials_default_types' ); // returns IDs
    $default_costs     = get_field( 'all_materials_default_cost_levels' ); // returns values

    // 4. 处理 Process 筛选
    if ( ! empty( $_GET['process'] ) ) {
        $processes = explode( ',', sanitize_text_field( $_GET['process'] ) );
        $args['tax_query'][] = array(
            'taxonomy' => 'material_process',
            'field'    => 'slug',
            'terms'    => $processes,
        );
    } elseif ( ! empty( $default_processes ) && ! isset( $_GET['process'] ) ) {
        // Apply Default Process Filter if no URL param
        $args['tax_query'][] = array(
            'taxonomy' => 'material_process',
            'field'    => 'term_id', // ACF returns IDs
            'terms'    => $default_processes,
        );
    }

    // 5. 处理 Type 筛选
    if ( ! empty( $_GET['type'] ) ) {
        $types = explode( ',', sanitize_text_field( $_GET['type'] ) );
        $args['tax_query'][] = array(
            'taxonomy' => 'material_type',
            'field'    => 'slug',
            'terms'    => $types,
        );
    } elseif ( ! empty( $default_types ) && ! isset( $_GET['type'] ) ) {
        // Apply Default Type Filter if no URL param
        $args['tax_query'][] = array(
            'taxonomy' => 'material_type',
            'field'    => 'term_id',
            'terms'    => $default_types,
        );
    }

    // 6. 处理 Cost 筛选
    if ( ! empty( $_GET['cost'] ) ) {
        $costs = explode( ',', sanitize_text_field( $_GET['cost'] ) );
        $args['meta_query'][] = array(
            'key'     => 'material_cost_level',
            'value'   => $costs,
            'compare' => 'IN',
        );
    } elseif ( ! empty( $default_costs ) && ! isset( $_GET['cost'] ) ) {
        // Apply Default Cost Filter if no URL param
        $args['meta_query'][] = array(
            'key'     => 'material_cost_level',
            'value'   => $default_costs,
            'compare' => 'IN',
        );
    }

    // 7. 返回查询对象
    return new WP_Query( $args );
}

/**
 * 获取 Material 关联的 Capability 数据 (Override Data)
 * 
 * 用于 Single Material 模板中，自动获取所属工艺 (Material Process) 关联的
 * Capability 文章数据，并格式化为前端模块所需的结构。
 * 
 * @param int $material_id Material Post ID
 * @return array|null 格式化后的数据数组，如果没有关联数据则返回 null
 */
function get_material_linked_capability( $material_id ) {
    // 1. 获取当前 Material 所属的 Process 分类
    $current_material_terms = get_the_terms( $material_id, 'material_process' );
    
    if ( empty( $current_material_terms ) || is_wp_error( $current_material_terms ) ) {
        return null;
    }

    $linked_cap_data_override = array();

    foreach ( $current_material_terms as $term ) {
        // 2. 检查分类是否关联了 Capability (ACF 字段 on Taxonomy Term)
        $linked_cap = get_field( 'taxonomy_linked_capability', 'material_process_' . $term->term_id );
        
        if ( $linked_cap ) {
            $cap_id = $linked_cap->ID;
            
            // --- A. Basic Info ---
            $cap_title = get_the_title( $cap_id );
            
            // Fix: Use prefixed key because 'cap_hero' clone has prefix_name => 1
            $cap_desc_raw = get_field( 'cap_hero_hero_description', $cap_id ); 
            $cap_desc = strip_tags( $cap_desc_raw ); // Strip HTML tags
            
            // --- B. Metrics (Highlight Cards) ---
            // From Capability Design Guide
            $cap_metrics = get_field( 'cap_design_guide_capability_design_guide_core_specs', $cap_id );
            $highlights_data = array();
            
            if ( is_array( $cap_metrics ) ) {
                foreach ( $cap_metrics as $metric ) {
                    $highlights_data[] = array(
                        'title' => isset( $metric['label'] ) ? $metric['label'] : '',
                        'value' => isset( $metric['value'] ) ? $metric['value'] : '',
                        'unit'  => isset( $metric['unit'] ) ? $metric['unit'] : '',
                        'tag'   => $cap_title,
                    );
                }
            }

            // --- C. Finishing Tags (Reverse Query) ---
            // Find Surface Finish posts related to this Capability
            $finishing_tags_data = array();
            $linked_finishes = get_posts( array(
                'post_type' => 'surface-finish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'related_capabilities',
                        'value' => '"' . $cap_id . '"', // Try exact match first
                        'compare' => 'LIKE'
                    )
                )
            ) );

            if ( empty( $linked_finishes ) ) {
                // Fallback: loose match
                $linked_finishes = get_posts( array(
                    'post_type' => 'surface-finish',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'related_capabilities',
                            'value' => $cap_id,
                            'compare' => 'LIKE'
                        )
                    )
                ) );
            }

            if ( ! empty( $linked_finishes ) ) {
                foreach ( $linked_finishes as $finish ) {
                    $finishing_tags_data[] = array(
                        'text' => $finish->post_title,
                        'url'  => get_permalink( $finish->ID ),
                    );
                }
            }
            
            // --- D. Image (Fallback to Capability Hero Image) ---
            $cap_hero_image_id = get_field( 'cap_hero_hero_image', $cap_id );
            $image_url = ''; $image_w = ''; $image_h = '';
            
            if ( $cap_hero_image_id ) {
                $img_src = wp_get_attachment_image_src( $cap_hero_image_id, 'large' );
                if ( $img_src ) {
                    $image_url = $img_src[0];
                    $image_w = $img_src[1];
                    $image_h = $img_src[2];
                }
            }

            // --- E. Build Override Array ---
            $linked_cap_data_override[] = array(
                'title'          => $cap_title,
                'short_title'    => $cap_title,
                'hub_title'      => $cap_title,
                'hub_desc'       => $cap_desc,
                'highlights'     => $highlights_data,
                'finishing_tags' => $finishing_tags_data,
                'cta'            => array( 
                    'url' => get_permalink( $cap_id ), 
                    'label' => 'View ' . $cap_title, 
                    'target' => '' 
                ),
                'image'          => array(
                    'desktop' => $image_url,
                    'mobile'  => $image_url,
                    'width'   => $image_w,
                    'height'  => $image_h,
                ),
            );
            
            // Currently logic only supports one capability, so we can break here if needed
            // But if we want to support multiple, we keep loop.
            // Based on frontend logic, it seems to handle array of overrides.
        }
    }

    return ! empty( $linked_cap_data_override ) ? $linked_cap_data_override : null;
}
