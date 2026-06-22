<?php
/**
 * Admin Filters & Columns (后台列表页增强)
 * ==========================================================================
 * 文件作用:
 * 定制 WordPress 后台文章列表页 (Admin List Table) 的功能。
 * 包括：增加自定义筛选器、添加自定义列、批量操作等。
 *
 * 核心逻辑:
 * 1. Material 列表: 增加 "批量发布" 功能。
 * 2. Material 列表: 增加 Process 和 Type 的分类筛选器。
 * 3. Surface Finish 列表: 增加 "Related Capabilities" 列。
 * 4. Surface Finish 列表: 增加 "按 Capability 筛选" 的功能。
 * 5. 通用: 移除不必要的 "日期筛选" (Disable Months Dropdown)。
 *
 * 架构角色:
 * [Admin Infrastructure]
 * 这个文件只影响 WP Admin 后台的体验，不影响前端页面渲染。
 * 它属于 "基础设施" 代码，旨在提高内容管理员 (Content Editor) 的工作效率。
 *
 * 🚨 避坑指南:
 * 1. `pre_get_posts` 钩子极其强大但也危险，必须严格限定 `is_admin()`, `is_main_query()` 以及 `post_type`，
 *    否则可能导致前端页面崩溃或数据混乱。
 * 2. ACF Relationship 字段存储的是序列化数组，因此 Meta Query 只能用 `LIKE` 进行模糊匹配。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product admin filter taxonomy config.
 *
 * @return array<string, string>
 */
function linsy_get_product_admin_filter_taxonomies() {
	return array(
		'product_shape'    => 'Shapes',
		'product_material' => 'Materials',
		'product_grade'    => 'Grades',
	);
}

/**
 * Hide the default date dropdown on the Product list screen.
 *
 * @param array  $months    Months dropdown options.
 * @param string $post_type Current post type.
 * @return array
 */
function linsy_hide_product_months_dropdown( $months, $post_type ) {
	if ( 'product' === $post_type ) {
		return array();
	}

	return $months;
}
add_filter( 'months_dropdown_results', 'linsy_hide_product_months_dropdown', 10, 2 );

/**
 * Detect the active product taxonomy filter.
 *
 * Only one taxonomy filter is allowed at a time. The first non-empty value wins.
 *
 * @return string
 */
function linsy_get_active_product_admin_filter_taxonomy() {
	foreach ( array_keys( linsy_get_product_admin_filter_taxonomies() ) as $taxonomy ) {
		if ( empty( $_GET[ $taxonomy ] ) ) {
			continue;
		}

		$value = sanitize_text_field( wp_unslash( $_GET[ $taxonomy ] ) );

		if ( '' !== $value ) {
			return $taxonomy;
		}
	}

	return '';
}

/**
 * Render taxonomy filters on the Product admin list table.
 */
function linsy_render_product_admin_taxonomy_filters() {
	global $typenow;

	if ( 'product' !== $typenow ) {
		return;
	}

	$active_taxonomy = linsy_get_active_product_admin_filter_taxonomy();

	foreach ( linsy_get_product_admin_filter_taxonomies() as $taxonomy => $label ) {
		$selected = '';

		if ( $taxonomy === $active_taxonomy && ! empty( $_GET[ $taxonomy ] ) ) {
			$selected = sanitize_text_field( wp_unslash( $_GET[ $taxonomy ] ) );
		}

		wp_dropdown_categories(
			array(
				'show_option_all' => sprintf( 'All %s', $label ),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'hide_empty'      => false,
				'hierarchical'    => true,
				'value_field'     => 'slug',
			)
		);
	}
}
add_action( 'restrict_manage_posts', 'linsy_render_product_admin_taxonomy_filters' );

/**
 * Apply the selected taxonomy filter to the Product admin query.
 *
 * @param WP_Query $query Admin list query.
 */
function linsy_apply_product_admin_taxonomy_filter( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );

	if ( 'product' !== $post_type ) {
		return;
	}

	$active_taxonomy = linsy_get_active_product_admin_filter_taxonomy();

	if ( '' === $active_taxonomy || empty( $_GET[ $active_taxonomy ] ) ) {
		return;
	}

	$term_slug = sanitize_title( wp_unslash( $_GET[ $active_taxonomy ] ) );

	if ( '' === $term_slug ) {
		return;
	}

	foreach ( array_keys( linsy_get_product_admin_filter_taxonomies() ) as $taxonomy ) {
		$query->set( $taxonomy, '' );
	}

	$query->set(
		'tax_query',
		array(
			array(
				'taxonomy' => $active_taxonomy,
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		)
	);
}
add_action( 'pre_get_posts', 'linsy_apply_product_admin_taxonomy_filter' );

/**
 * Keep only one taxonomy dropdown selected at a time in the Product list UI.
 */
function linsy_print_product_admin_filter_script() {
	$screen = get_current_screen();

	if ( ! $screen || 'edit-product' !== $screen->id ) {
		return;
	}

	$selectors = array_map(
		static function ( $taxonomy ) {
			return sprintf( 'select[name="%s"]', esc_js( $taxonomy ) );
		},
		array_keys( linsy_get_product_admin_filter_taxonomies() )
	);
	?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const selectors = <?php echo wp_json_encode( array_values( $selectors ) ); ?>;
			const selects = selectors
				.map((selector) => document.querySelector(selector))
				.filter(Boolean);

			selects.forEach((select) => {
				select.addEventListener('change', function () {
					if (!this.value) {
						return;
					}

					selects.forEach((otherSelect) => {
						if (otherSelect !== this) {
							otherSelect.value = '';
						}
					});
				});
			});
		});
	</script>
	<?php
}
add_action( 'admin_footer-edit.php', 'linsy_print_product_admin_filter_script' );
