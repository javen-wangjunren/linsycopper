<?php
/**
 * Grade Taxonomy Manual Ordering (Grade 排序)
 * ==========================================================================
 * 文件作用:
 * 为 product_grade 分类法提供后台手动排序能力，并统一前端读取顺序。
 *
 * 核心逻辑:
 * 1. 注册 term meta `linsy_grade_order`（整数，用于排序）。
 * 2. 后台 Grades 列表增加 "Order" 列：可点击表头排序，单元格内可直接输入数字
 *    保存（AJAX，无需进编辑页）。
 * 3. Grades 新增/编辑表单增加 Order 输入框。
 * 4. 提供 `linsy_get_ordered_grades()` helper，供侧边栏等前端统一按
 *    排序值读取（未设置 Order 的按名称字母序排在最后）。
 *
 * 排序规则:
 * - 显式设置的 Order (1,2,3...) 决定先后。
 * - Order 为 0 / 未设置的 term 统一视为 9999，按名称升序排在有序项之后，
 *   保证列表稳定、可预测（解决"顺序随机"问题）。
 *
 * 架构角色:
 * [Admin Infrastructure + Frontend Data]
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 常量: 排序 term meta key
 */
define( 'LINSY_GRADE_ORDER_META', 'linsy_grade_order' );
define( 'LINSY_GRADE_ORDER_DEFAULT', 9999 );

/**
 * 1. 注册 term meta
 */
add_action( 'init', 'linsy_register_grade_order_meta', 20 );

function linsy_register_grade_order_meta() {
	register_term_meta(
		'product_grade',
		LINSY_GRADE_ORDER_META,
		array(
			'type'              => 'integer',
			'single'            => true,
			'sanitize_callback' => 'absint',
			'show_in_rest'      => true,
		)
	);
}

/**
 * 2. 后台 Grades 列表: 增加 "Order" 列
 *
 * @param array $columns Term list columns.
 * @return array
 */
add_filter( 'manage_edit-product_grade_columns', 'linsy_grade_order_columns' );

function linsy_grade_order_columns( $columns ) {
	$columns[ LINSY_GRADE_ORDER_META ] = __( 'Order', 'generatepress-child' );
	return $columns;
}

/**
 * 2a. 后台 Grades 列表: "Order" 列表格输出（可直接编辑的数字输入框）
 *
 * @param string $content     Column output.
 * @param string $column_name Column name.
 * @param int    $term_id     Term ID.
 * @return string
 */
add_filter( 'manage_product_grade_custom_column', 'linsy_grade_order_column_output', 10, 3 );

function linsy_grade_order_column_output( $content, $column_name, $term_id ) {
	if ( LINSY_GRADE_ORDER_META !== $column_name ) {
		return $content;
	}

	$order = (int) get_term_meta( $term_id, LINSY_GRADE_ORDER_META, true );

	return sprintf(
		'<input type="number" min="0" step="1" class="linsy-grade-order-input" data-term-id="%d" value="%d" title="%s" style="width:72px;" />',
		(int) $term_id,
		$order,
		esc_attr__( 'Enter a number and press Enter / blur to save', 'generatepress-child' )
	);
}

/**
 * 2b. 后台 Grades 列表: "Order" 列可排序
 *
 * @param array $columns Sortable columns.
 * @return array
 */
add_filter( 'manage_edit-product_grade_sortable_columns', 'linsy_grade_order_sortable_columns' );

function linsy_grade_order_sortable_columns( $columns ) {
	$columns[ LINSY_GRADE_ORDER_META ] = LINSY_GRADE_ORDER_META;
	return $columns;
}

/**
 * 2c. 后台 Grades 列表: 默认按 Order 排序（未点表头时也生效）
 *
 * 仅在 Grades 列表页（edit-tags.php?taxonomy=product_grade）且用户未显式
 * 选择排序列时接管，避免影响其它查询。
 *
 * @param array $args       Term query args.
 * @param array $taxonomies Taxonomies being queried.
 * @return array
 */
add_filter( 'get_terms_args', 'linsy_grade_order_get_terms_args', 10, 2 );

function linsy_grade_order_get_terms_args( $args, $taxonomies ) {
	if ( ! is_admin() || ! in_array( 'product_grade', (array) $taxonomies, true ) ) {
		return $args;
	}

	// 仅接管 Grades 列表页。
	if ( empty( $_GET['taxonomy'] ) || 'product_grade' !== $_GET['taxonomy'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return $args;
	}

	// 用户已显式选择排序列（Name / Order / ...）时不接管。
	if ( ! empty( $_GET['orderby'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return $args;
	}

	$args['orderby'] = LINSY_GRADE_ORDER_META;
	$args['order']   = 'ASC';

	return $args;
}

/**
 * 2d. 按 Order term meta 排序的 SQL 处理
 *
 * 通过 LEFT JOIN termmeta 实现：
 * - 有 Order 的 term 按数值升序排列；
 * - 无 Order 的 term 视为 9999，按名称升序排在最后（列表稳定、可预测）。
 *
 * @param array $clauses    Term query SQL clauses.
 * @param array $taxonomies Taxonomies being queried.
 * @param array $args       Term query args.
 * @return array
 */
add_filter( 'terms_clauses', 'linsy_grade_order_terms_clauses', 10, 3 );

function linsy_grade_order_terms_clauses( $clauses, $taxonomies, $args ) {
	if ( empty( $args['orderby'] ) || LINSY_GRADE_ORDER_META !== $args['orderby'] ) {
		return $clauses;
	}

	global $wpdb;

	$order = ( isset( $args['order'] ) && 'DESC' === strtoupper( $args['order'] ) ) ? 'DESC' : 'ASC';

	$clauses['join'] .= $wpdb->prepare(
		" LEFT JOIN {$wpdb->termmeta} AS linsy_grade_order_mo ON (t.term_id = linsy_grade_order_mo.term_id AND linsy_grade_order_mo.meta_key = %s)",
		LINSY_GRADE_ORDER_META
	);
	$clauses['orderby'] = sprintf(
		'ORDER BY CAST(COALESCE(linsy_grade_order_mo.meta_value, %d) AS UNSIGNED) %s, t.name %s',
		LINSY_GRADE_ORDER_DEFAULT,
		$order,
		$order
	);

	return $clauses;
}

/**
 * 2e. 后台 Grades 列表: 行内保存 Order（AJAX）
 */
add_action( 'wp_ajax_linsy_save_grade_order', 'linsy_save_grade_order_ajax' );

function linsy_save_grade_order_ajax() {
	check_ajax_referer( 'linsy-grade-order', 'nonce' );

	if ( ! current_user_can( 'manage_categories' ) ) {
		wp_send_json_error( array( 'message' => __( 'Insufficient permissions.', 'generatepress-child' ) ) );
	}

	$term_id = isset( $_POST['term_id'] ) ? absint( $_POST['term_id'] ) : 0;
	$order   = isset( $_POST['order'] ) ? absint( $_POST['order'] ) : 0;

	$term = get_term( $term_id, 'product_grade' );

	if ( ! $term || is_wp_error( $term ) ) {
		wp_send_json_error( array( 'message' => __( 'Term not found.', 'generatepress-child' ) ) );
	}

	update_term_meta( $term_id, LINSY_GRADE_ORDER_META, $order );

	wp_send_json_success(
		array(
			'term_id' => $term_id,
			'order'   => $order,
		)
	);
}

/**
 * 2f. 后台 Grades 列表: 打印行内保存所需的 JS（仅 Grades 列表页）
 */
add_action( 'admin_footer-edit-tags.php', 'linsy_print_grade_order_script' );

function linsy_print_grade_order_script() {
	$screen = get_current_screen();

	if ( ! $screen || 'edit-product_grade' !== $screen->id ) {
		return;
	}

	$ajax_url = admin_url( 'admin-ajax.php' );
	$nonce    = wp_create_nonce( 'linsy-grade-order' );
	?>
	<script>
		(function () {
			const inputClass = 'linsy-grade-order-input';
			const saveUrl = <?php echo wp_json_encode( $ajax_url ); ?>;
			const nonce = <?php echo wp_json_encode( $nonce ); ?>;

			document.addEventListener('DOMContentLoaded', function () {
				document.querySelectorAll('tbody').forEach((tbody) => {
					tbody.addEventListener('change', function (e) {
						const input = e.target.closest('input.' + inputClass);
						if (!input || !input.value) {
							return;
						}
						const termId = parseInt(input.dataset.termId, 10);
						if (!termId) {
							return;
						}

						const body = new URLSearchParams();
						body.set('action', 'linsy_save_grade_order');
						body.set('nonce', nonce);
						body.set('term_id', termId);
						body.set('order', input.value);

						const original = input.style.borderColor;
						input.style.borderColor = '#F97C30';

						fetch(saveUrl, {
							method: 'POST',
							credentials: 'same-origin',
							headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
							body: body.toString(),
						})
							.then((res) => res.json())
							.then((json) => {
								input.style.borderColor = json && json.success ? '#8BC34A' : '#EF4444';
							})
							.catch(() => {
								input.style.borderColor = '#EF4444';
							});
					});
				});
			});
		})();
	</script>
	<?php
}

/**
 * 3. Grades 新增 / 编辑表单: Order 输入框
 */
add_action( 'product_grade_add_form_fields', 'linsy_grade_order_add_form_field' );
add_action( 'product_grade_edit_form_fields', 'linsy_grade_order_edit_form_field', 10, 2 );

function linsy_grade_order_add_form_field() {
	?>
	<div class="form-field term-order-wrap">
		<label for="linsy-grade-order-add"><?php esc_html_e( 'Order', 'generatepress-child' ); ?></label>
		<input
			type="number"
			id="linsy-grade-order-add"
			name="<?php echo esc_attr( LINSY_GRADE_ORDER_META ); ?>"
			value="0"
			min="0"
			step="1"
		/>
		<p class="description"><?php esc_html_e( 'Order of this grade in the catalog sidebar. Lower numbers appear first; leave 0 to sort alphabetically after ordered items.', 'generatepress-child' ); ?></p>
	</div>
	<?php
}

function linsy_grade_order_edit_form_field( $term, $taxonomy ) {
	$order = (int) get_term_meta( $term->term_id, LINSY_GRADE_ORDER_META, true );
	?>
	<tr class="form-field term-order-wrap">
		<th scope="row">
			<label for="linsy-grade-order-edit"><?php esc_html_e( 'Order', 'generatepress-child' ); ?></label>
		</th>
		<td>
			<input
				type="number"
				id="linsy-grade-order-edit"
				name="<?php echo esc_attr( LINSY_GRADE_ORDER_META ); ?>"
				value="<?php echo esc_attr( $order ); ?>"
				min="0"
				step="1"
			/>
			<p class="description"><?php esc_html_e( 'Order of this grade in the catalog sidebar. Lower numbers appear first; leave 0 to sort alphabetically after ordered items.', 'generatepress-child' ); ?></p>
		</td>
	</tr>
	<?php
}

/**
 * 3a. 保存新增 / 编辑表单中的 Order
 *
 * @param int $term_id Term ID.
 */
add_action( 'created_product_grade', 'linsy_grade_order_save_form_value' );
add_action( 'edited_product_grade', 'linsy_grade_order_save_form_value' );

function linsy_grade_order_save_form_value( $term_id ) {
	if ( ! isset( $_POST[ LINSY_GRADE_ORDER_META ] ) ) {
		return;
	}

	$order = absint( $_POST[ LINSY_GRADE_ORDER_META ] );
	update_term_meta( $term_id, LINSY_GRADE_ORDER_META, $order );
}

/**
 * 4. 前端统一读取: 按 Order 排序的 Grades 列表
 *
 * 排序规则与后台一致（Order 升序，未设置按名称升序排在最后），
 * 供侧边栏等前端位置使用，保证"后台设置的顺序 = 前端展示顺序"。
 *
 * @return WP_Term[] Sorted grade terms.
 */
function linsy_get_ordered_grades() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_grade',
			'hide_empty' => false,
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	usort(
		$terms,
		static function ( $a, $b ) {
			$oa = (int) get_term_meta( $a->term_id, LINSY_GRADE_ORDER_META, true );
			$ob = (int) get_term_meta( $b->term_id, LINSY_GRADE_ORDER_META, true );

			if ( $oa <= 0 ) {
				$oa = LINSY_GRADE_ORDER_DEFAULT;
			}
			if ( $ob <= 0 ) {
				$ob = LINSY_GRADE_ORDER_DEFAULT;
			}

			if ( $oa !== $ob ) {
				return $oa <=> $ob;
			}

			return strcasecmp( $a->name, $b->name );
		}
	);

	return $terms;
}
