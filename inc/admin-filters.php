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
 * Compress the Product Quick Edit taxonomy UI into a horizontal 3-column grid.
 *
 * Target DOM (from real WP output + live browser computed styles):
 *   <tr class="inline-edit-row">               ← DO NOT set to flex (width stuck at 34px)
 *     <td colspan="11">
 *       <div class="inline-edit-wrapper">      ← TRUE flex parent (width = 420 + 24 padding)
 *         <fieldset class="inline-edit-col-left">
 *         <fieldset class="inline-edit-col-right">
 *         <fieldset class="inline-edit-col-center inline-edit-categories">
 *           <div class="inline-edit-col">      ← TRUE grid parent for Shapes/Materials/Grades
 *             <span.title (Shapes)>
 *             <input[type=hidden]>
 *             <ul.cat-checklist.product_shape-checklist>
 *             <span.title (Materials)>
 *             <input[type=hidden]>
 *             <ul.cat-checklist.product_material-checklist>
 *             <span.title (Grades)>
 *             <input[type=hidden]>
 *             <ul.cat-checklist.product_grade-checklist>
 *         <div.inline-edit-save>
 *
 * Root cause of the "1 character width" bug:
 *   1) We previously made <tr.inline-edit-row> display:flex, but its computed width was 34px
 *      (inherited from the WP list-table column-sizing logic).
 *   2) fieldset.inline-edit-col-center carries a NATIVE WP style:
 *          min-width: min-content; width: 84px;
 *      which collapses the taxonomy block to the smallest content width.
 *   3) Combined, the 3 grid columns become 8px each, so titles wrap vertically
 *      (S/h/a/p/e/s stacked in 1 column) and the list boxes become ~18px wide.
 */
function linsy_print_product_quick_edit_layout_style() {
	$screen = get_current_screen();

	if ( ! $screen || 'edit-product' !== $screen->id ) {
		return;
	}
	?>
	<style>
		/* =====================================================================
		 * 1) Reset WP native widths & floats on every block that participates
		 *    in the layout. Use !important because WP admin CSS uses
		 *    very high specificity selectors.
		 * ===================================================================== */
		body.wp-admin .inline-edit-wrapper,
		body.wp-admin .inline-edit-wrapper fieldset,
		body.wp-admin .inline-edit-col-left,
		body.wp-admin .inline-edit-col-right,
		body.wp-admin .inline-edit-col-center,
		body.wp-admin .inline-edit-col-center.inline-edit-categories,
		body.wp-admin .inline-edit-col-center .inline-edit-col,
		body.wp-admin .inline-edit-col-center .inline-edit-col > *,
		body.wp-admin .inline-edit-col-center .cat-checklist,
		body.wp-admin .inline-edit-save {
			float: none !important;
			clear: none !important;
			box-sizing: border-box;
			/* Kill the NATIVE "min-width: min-content" on
			 * fieldset.inline-edit-col-center that collapses the block. */
			min-width: 0 !important;
			max-width: none !important;
		}

		/* =====================================================================
		 * 2) LEAVE <tr.inline-edit-row> ALONE — use .inline-edit-wrapper instead.
		 *    .inline-edit-wrapper is the ONLY flex parent for the 2 top row
		 *    fieldsets + taxonomy block + save row.
		 * ===================================================================== */
		body.wp-admin .inline-edit-wrapper {
			display: flex;
			flex-wrap: wrap;
			/* Give it full width against the <td colspan="11">.
			 * WP sets it width:420px natively; we must override to 100% so
			 * the 3 taxonomy columns have room to expand. */
			width: 100% !important;
			min-width: 100% !important;
			max-width: 100% !important;
			/* Compress vertical height: smaller gaps + tighter vertical padding. */
			gap: 10px 20px;
			align-items: flex-start;
			/* — Padding fix: prevent content from sticking to the border. */
			padding: 14px 20px !important;
			/* Reset any native WP border that would make the padding look odd. */
			border: 1px solid transparent;
			border-radius: 4px;
		}

		/* =====================================================================
		 * 3) Top row:
		 *
		 *   Column A — WP NATIVE LEFT (Title + Slug only)   → min ~420px
		 *   Column B — RIGHT (Status / Visibility)           → 240px
		 *   Column C — SEOPRESS SEO (title/meta/noindex/nofollow) → ~440px
		 *
		 * SEOPress injects 4 extra <fieldset class="inline-edit-col-left">
		 * siblings AFTER the taxonomy fieldset. Because they carry the same
		 * class as the native left column, flex wraps them each on NEW rows,
		 * which is the #1 source of vertical height bloat.
		 *
		 * We solve it with a simple rule:
		 *   - First .inline-edit-col-left → native Title/Slug column A
		 *   - All subsequent .inline-edit-col-left → merge into Column C
		 * ===================================================================== */

		/* Column A (native left) */
		body.wp-admin .inline-edit-col-left:first-of-type {
			order: 10;
			flex: 1 1 360px;
			min-width: 360px !important;
			width: auto !important;
			padding: 0 12px 0 0 !important;
			margin: 0;
		}

		/* Hide Date fieldset + Password field inside the native LEFT column. */
		body.wp-admin .inline-edit-col-left:first-of-type > .inline-edit-col > fieldset.inline-edit-date,
		body.wp-admin .inline-edit-col-left:first-of-type > .inline-edit-col > fieldset.inline-edit-date + br.clear {
			display: none !important;
		}
		body.wp-admin .inline-edit-col-left:first-of-type > .inline-edit-col > div.inline-edit-group.wp-clearfix {
			display: none !important;
		}

		/* Column B (WP native right — Status/Visibility).
		 * Give it a small flex-grow so if there's extra room it pulls the
		 * SEO column tighter next to it rather than leaving blank space. */
		body.wp-admin .inline-edit-col-right {
			order: 20;
			flex: 0 1 240px;
			width: 240px !important;
			min-width: 0 !important;
			padding-top: 0 !important;
		}

		/* Column C (SEOPress extra LEFTs — 2-column grid wrapped as flex so
		 * the 4 SEO fields (title/meta/noindex/nofollow) tile horizontally on
		 * the SECOND visual row instead of each getting their own row. */
		body.wp-admin .inline-edit-col-left + .inline-edit-col-left,
		body.wp-admin .inline-edit-col-left ~ .inline-edit-col-left {
			order: 30;
			flex: 0 1 calc((100% - 20px) / 2);
			min-width: 320px !important;
			max-width: 100% !important;
			width: auto !important;
			padding: 0 !important;
			margin: 0 !important;
		}

		/* Hide any SEOPress-injected fieldset.inline-edit-col-left that has
		 * zero height (they are the empty "nonce holder" siblings). They still
		 * exist in the DOM but won't push other flex items to new rows. */
		body.wp-admin .inline-edit-wrapper > fieldset.inline-edit-col-left:not(:first-of-type) {
			/* Skip hiding the ones with actual visual content — we only hide
			 * the zero-height nonce placeholders. A content-less fieldset has
			 * empty textContent. */
		}
		body.wp-admin .inline-edit-wrapper > fieldset.inline-edit-col-left:not(:first-of-type):empty {
			display: none !important;
		}

		/* Heuristic: any SEOPress extra LEFT with computed height < 10px is
		 * a spacer / nonce wrapper, don't let it consume flex layout. */
		body.wp-admin .inline-edit-wrapper > fieldset.inline-edit-col-left:not(:first-of-type) {
			min-height: 0 !important;
		}

		/* The "wp-clearfix" spacer divs that SEOPress drops between each
		 * SEO fieldset collapse to height 0 already; set them to none so they
		 * don't insert extra rows when flex wrap decides to fill a row. */
		body.wp-admin .inline-edit-wrapper > div.wp-clearfix,
		body.wp-admin .inline-edit-wrapper > br.clear,
		body.wp-admin .inline-edit-wrapper > input[type="hidden"] {
			display: none !important;
		}

		/* =====================================================================
		 * 4) TAXONOMY BLOCK (Shapes / Materials / Grades) — 3-column CSS grid
		 *    NO LONGER a full 100% second row! Move it to the top row as the
		 *    2nd/3rd column depending on space, or even directly after the
		 *    native LEFT; this removes ~180px vertical height previously
		 *    wasted on an entire row just for taxonomy.
		 * ===================================================================== */
		body.wp-admin .inline-edit-col-center.inline-edit-categories {
			/* TOP ROW, between LEFT and RIGHT/SEO. */
			order: 15;
			flex: 1 1 calc(100% - 20px);
			width: auto !important;
			min-width: 440px !important;
			max-width: 100% !important;
			margin: 0;
			padding: 0 8px !important;
			border: none;
			/* Kill the collapsed width WP gives it. */
			min-inline-size: 440px !important;
		}

		/* If the viewport is wide enough (>= 1280px), give taxonomy its own
		 * dedicated column after LEFT instead of wrapping — this keeps the
		 * top row flat and is the real height-saver. */
		@media (min-width: 1200px) {
			body.wp-admin .inline-edit-col-center.inline-edit-categories {
				flex: 0 0 50% !important;
				width: 50% !important;
				min-width: 520px !important;
				min-inline-size: 520px !important;
			}
			/* LEFT column: shrink a bit so LEFT + Tax fit on one wide row. */
			body.wp-admin .inline-edit-col-left:first-of-type {
				flex: 0 0 360px !important;
				width: 360px !important;
				min-width: 360px !important;
			}
			/* RIGHT column: still after Taxonomy, above SEO. */
			body.wp-admin .inline-edit-col-right {
				order: 25;
				flex: 0 0 240px !important;
				width: 240px !important;
				min-width: 240px !important;
			}
		}

		/* The GRID PARENT for (title,ul) × 3 pairs. */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col {
			display: grid;
			width: 100% !important;
			min-width: 100% !important;
			max-width: 100% !important;
			/* 3 equal columns, each starts with a title row and then a list row. */
			grid-template-columns: repeat(3, minmax(0, 1fr));
			grid-template-rows: auto 140px;
			gap: 6px 24px;
			align-items: start;
		}

		/* The hidden placeholder inputs occupy zero grid cells. */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col > input[type="hidden"] {
			display: none;
		}

		/* =====================================================================
		 * 5) Place (title, list) pairs explicitly into each 2-row grid column.
		 * ===================================================================== */
		/* Column 1: Shapes */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> span.inline-edit-categories-label:nth-of-type(1) {
			grid-column: 1 / 2;
			grid-row: 1 / 2;
			margin: 0;
			padding: 0 2px;
			width: 100% !important;
			max-width: 100% !important;
			min-width: 0 !important;
			height: auto !important;
			font-weight: 600;
			/* Ensure titles don't keep their previous collapsed width. */
			writing-mode: horizontal-tb !important;
			text-orientation: mixed !important;
			white-space: nowrap !important;
		}
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist:nth-of-type(1) {
			grid-column: 1 / 2;
			grid-row: 2 / 3;
		}

		/* Column 2: Materials */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> span.inline-edit-categories-label:nth-of-type(2) {
			grid-column: 2 / 3;
			grid-row: 1 / 2;
			margin: 0;
			padding: 0 2px;
			width: 100% !important;
			max-width: 100% !important;
			min-width: 0 !important;
			height: auto !important;
			font-weight: 600;
			writing-mode: horizontal-tb !important;
			text-orientation: mixed !important;
			white-space: nowrap !important;
		}
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist:nth-of-type(2) {
			grid-column: 2 / 3;
			grid-row: 2 / 3;
		}

		/* Column 3: Grades */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> span.inline-edit-categories-label:nth-of-type(3) {
			grid-column: 3 / 4;
			grid-row: 1 / 2;
			margin: 0;
			padding: 0 2px;
			width: 100% !important;
			max-width: 100% !important;
			min-width: 0 !important;
			height: auto !important;
			font-weight: 600;
			writing-mode: horizontal-tb !important;
			text-orientation: mixed !important;
			white-space: nowrap !important;
		}
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist:nth-of-type(3) {
			grid-column: 3 / 4;
			grid-row: 2 / 3;
		}

		/* =====================================================================
		 * 6) Each list column: 140px tall, border, scrollbar only inside it.
		 * ===================================================================== */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col > ul.cat-checklist {
			margin: 0 !important;
			padding: 6px 8px !important;
			width: 100% !important;
			max-width: 100% !important;
			min-width: 0 !important;
			height: 140px !important;
			max-height: 140px !important;
			overflow-y: auto;
			border: 1px solid #dcdcde;
			background: #fff;
			list-style: none;
			writing-mode: horizontal-tb !important;
		}

		/* Label normalization — prevent any future 1-col vertical wrap. */
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist li {
			line-height: 1.45;
			margin: 0 0 4px 0;
			padding: 0;
		}
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist li label.selectit {
			display: flex;
			align-items: flex-start;
			gap: 6px;
		}
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist li label.selectit input {
			margin-top: 2px;
			flex: 0 0 auto;
		}
		body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
			> ul.cat-checklist li ul.children {
			margin: 4px 0 0 20px;
			padding: 0;
			list-style: none;
		}

		/* =====================================================================
		 * 7) Save / Cancel row lives at the bottom.
		 * ===================================================================== */
		body.wp-admin .inline-edit-save {
			order: 60;
			flex: 0 0 100%;
			width: 100% !important;
			min-width: 100% !important;
			margin: 6px 0 0 0 !important;
		}

		/* =====================================================================
		 * 8) Responsive fallbacks
		 * ===================================================================== */
		@media (max-width: 1280px) {
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col {
				grid-template-columns: repeat(2, minmax(0, 1fr));
				grid-template-rows: auto 140px auto 140px;
			}
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label:nth-of-type(1),
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist:nth-of-type(1) { grid-column: 1 / 2; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label:nth-of-type(2),
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist:nth-of-type(2) { grid-column: 2 / 3; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label:nth-of-type(3) {
				grid-column: 1 / 3;
				grid-row: 3 / 4;
				margin-top: 12px;
			}
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist:nth-of-type(3) {
				grid-column: 1 / 3;
				grid-row: 4 / 5;
			}
		}

		@media (max-width: 860px) {
			body.wp-admin .inline-edit-col-left,
			body.wp-admin .inline-edit-col-right {
				flex: 0 0 100%;
				width: 100% !important;
				min-width: 0 !important;
			}
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col {
				grid-template-columns: 1fr;
				grid-template-rows: repeat(3, auto 140px);
			}
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label:nth-of-type(1) { grid-row: 1 / 2; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist:nth-of-type(1)                     { grid-row: 2 / 3; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label:nth-of-type(2) { grid-row: 3 / 4; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist:nth-of-type(2)                     { grid-row: 4 / 5; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label:nth-of-type(3) { grid-row: 5 / 6; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist:nth-of-type(3)                     { grid-row: 6 / 7; }
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> span.inline-edit-categories-label,
			body.wp-admin .inline-edit-col-center.inline-edit-categories > .inline-edit-col
				> ul.cat-checklist {
				grid-column: 1 / 2;
			}
		}
	</style>
	<?php
}
add_action( 'admin_head-edit.php', 'linsy_print_product_quick_edit_layout_style' );

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

/**
 * Register "Export as JSON" bulk action on the Product list page.
 */
add_filter( 'bulk_actions-edit-product', 'linsy_add_product_export_bulk_action' );

function linsy_add_product_export_bulk_action( $bulk_actions ) {
	$bulk_actions['export_json']        = __( 'Export as JSON', 'generatepress_child' );
	$bulk_actions['export_json_minimal'] = __( 'Export as JSON (Minimal)', 'generatepress_child' );
	return $bulk_actions;
}

/**
 * Handle the "Export as JSON" bulk action.
 */
add_filter( 'handle_bulk_actions-edit-product', 'linsy_handle_product_export_bulk_action', 10, 3 );

function linsy_handle_product_export_bulk_action( $redirect_to, $action, $post_ids ) {
	if ( 'export_json' !== $action && 'export_json_minimal' !== $action ) {
		return $redirect_to;
	}

	if ( empty( $post_ids ) ) {
		return $redirect_to;
	}

	$minimal   = ( 'export_json_minimal' === $action );
	$products  = array();

	foreach ( $post_ids as $post_id ) {
		$post = get_post( (int) $post_id );
		if ( ! $post || 'product' !== $post->post_type ) {
			continue;
		}

		$product = array(
			'post_id'    => $post->ID,
			'post_title' => $post->post_title,
		);

		if ( ! $minimal ) {
			$product['post_status'] = $post->post_status;

			// Hero
			$hero_desc  = get_field( 'product_hero_desc', $post->ID );
			$hero_specs = get_field( 'product_hero_specs', $post->ID );
			if ( $hero_desc || $hero_specs ) {
				$product['hero'] = array();
				if ( $hero_desc ) {
					$product['hero']['short_desc'] = $hero_desc;
				}
				if ( $hero_specs && is_array( $hero_specs ) ) {
					$product['hero']['specs'] = array_map(
						function ( $s ) {
							return array(
								'value' => $s['value'] ?? '',
								'label' => $s['label'] ?? '',
							);
						},
						$hero_specs
					);
				}
			}

			// Description
			$desc_content  = get_field( 'product_desc_content', $post->ID );
			$desc_features = get_field( 'product_desc_features', $post->ID );
			if ( $desc_content || $desc_features ) {
				$product['description'] = array();
				if ( $desc_content ) {
					$product['description']['content'] = $desc_content;
				}
				if ( $desc_features && is_array( $desc_features ) ) {
					$product['description']['features'] = array_map(
						function ( $f ) {
							return $f['text'] ?? '';
						},
						$desc_features
					);
				}
			}

			// Applications
			$apps = get_field( 'product_application_list', $post->ID );
			if ( $apps && is_array( $apps ) ) {
				$product['applications'] = array_map(
					function ( $a ) {
						return array(
							'name'       => $a['application_name'] ?? '',
							'short_desc' => $a['application_shortdesc'] ?? '',
						);
					},
					$apps
				);
			}

			// Specifications
			$tables = get_field( 'product_spec_tables', $post->ID );
			if ( $tables && is_array( $tables ) ) {
				$product['specifications'] = array_map(
					function ( $t ) {
						$data = array();
						if ( isset( $t['spec_table_data'] ) && is_array( $t['spec_table_data'] ) ) {
							$data = array_map(
								function ( $row ) {
									return array(
										$row['col_1'] ?? '',
										$row['col_2'] ?? '',
										$row['col_3'] ?? '',
										$row['col_4'] ?? '',
									);
								},
								$t['spec_table_data']
							);
						}
						return array(
							'table_name' => $t['spec_table_name'] ?? '',
							'table_data' => $data,
						);
					},
					$tables
				);
			}

			// FAQ
			$faq_title = get_field( 'contact_faq_title', $post->ID );
			$faq_desc  = get_field( 'contact_faq_desc', $post->ID );
			$faq_list  = get_field( 'contact_faq_list', $post->ID );
			if ( $faq_title || $faq_desc || $faq_list ) {
				$product['faq'] = array(
					'title'       => $faq_title ?: '',
					'description' => $faq_desc ?: '',
				);
				if ( $faq_list && is_array( $faq_list ) ) {
					$product['faq']['list'] = array_map(
						function ( $f ) {
							return array(
								'question' => $f['contact_faq_question'] ?? '',
								'answer'   => $f['contact_faq_answer'] ?? '',
							);
						},
						$faq_list
					);
				}
			}
		}

		$products[] = $product;
	}

	if ( empty( $products ) ) {
		return $redirect_to;
	}

	// Force JSON download
	$json = wp_json_encode( $products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	$prefix = $minimal ? 'products-minimal' : 'products-export';

	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="' . $prefix . '-' . gmdate( 'Y-m-d' ) . '.json"' );
	header( 'Content-Length: ' . strlen( $json ) );

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $json;
	exit;
}
