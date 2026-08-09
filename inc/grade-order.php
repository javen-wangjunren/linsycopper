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
 * 注意: orderby 值写成 "order_custom" —— 纯字符串标记给 PHP 层 usort 用，
 * 不再交给 WP 去解析 SQL。避免和 ACF / TranslatePress 等插件在 terms_clauses
 * 上打架导致列表返回 0 行。
 *
 * @param array $columns Sortable columns.
 * @return array
 */
add_filter( 'manage_edit-product_grade_sortable_columns', 'linsy_grade_order_sortable_columns' );

function linsy_grade_order_sortable_columns( $columns ) {
	$columns[ LINSY_GRADE_ORDER_META ] = 'order_custom';
	return $columns;
}

/**
 * 2c. 后台 Grades 列表: 按 Order 做 PHP 层 usort 排序（零 SQL 改动）
 *
 * 触发条件（必须同时满足）：
 *   (1) is_admin()
 *   (2) 当前请求是 edit-tags.php?taxonomy=product_grade
 *   (3) (a) 未显式指定 orderby（默认进入列表页），或
 *       (b) orderby === "order_custom"（点 Order 表头），或
 *       (c) orderby === LINSY_GRADE_ORDER_META（兼容老 URL）
 *
 * 为什么用 `get_terms` filter（数组级 usort）而不是 terms_clauses：
 *   - SQL JOIN/ORDER 钩子极易和 ACF / TranslatePress / 翻译插件 / 自定义分类法
 *     扩展冲突，典型结果是「列表 header 显示 N items，但表格 No categories found」。
 *   - PHP 层排序只调顺序，不改 SQL，查询返回条数永远等于 SQL 返回条数，
 *     不会出现 0 行。Grade 数量 < 200，usort 性能开销可忽略。
 *
 * @param array        $terms      Term objects (or their IDs, if fields != all).
 * @param string[]     $taxonomies Taxonomies being queried.
 * @param array        $query_args Raw term query arguments (contains orderby/order etc.).
 * @return array
 */
add_filter( 'get_terms', 'linsy_grade_order_php_sort', 10, 3 );

function linsy_grade_order_php_sort( $terms, $taxonomies, $query_args ) {
	// 0. 只接管 product_grade taxonomy 的 is_admin 查询。
	if ( ! is_admin() || ! in_array( 'product_grade', (array) $taxonomies, true ) ) {
		return $terms;
	}

	// 1. 只接管后台 Grades 列表页的查询（避免影响菜单、Widgets 等其它 product_grade 查询）。
	global $pagenow;
	if ( ! ( 'edit-tags.php' === $pagenow && ! empty( $_GET['taxonomy'] ) && 'product_grade' === $_GET['taxonomy'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return $terms;
	}

	// 2. 如果是 fields != all（ids / names / tt_ids / slugs），不做排序（需要 term_id/name 属性才能排序，或者性能没意义）。
	if ( empty( $terms ) || ! is_object( reset( $terms ) ) ) {
		return $terms;
	}

	// 3. 判定当前是在做 Order 排序（默认 Order 升序；或点 Order 表头升序/降序）。
	//    $query_args['orderby'] 是 WP 解析后的最终 orderby（字符串或数组）。
	$orderby = isset( $query_args['orderby'] ) ? $query_args['orderby'] : '';
	$direction = ( isset( $query_args['order'] ) && 'DESC' === strtoupper( $query_args['order'] ) ) ? -1 : 1;

	$should_sort_by_order = false;
	if ( is_string( $orderby ) ) {
		if ( 'order_custom' === $orderby || LINSY_GRADE_ORDER_META === $orderby ) {
			$should_sort_by_order = true;
		}
		if ( '' === $orderby && empty( $_GET['orderby'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			// 默认进入列表、用户没选 orderby → 按 Order 升序。
			$should_sort_by_order = true;
			$direction = 1;
		}
	}

	if ( ! $should_sort_by_order ) {
		return $terms;
	}

	// 4. PHP 层 usort（完全同构 linsy_get_ordered_grades() 的规则，前后台一致）。
	usort(
		$terms,
		static function ( $a, $b ) use ( $direction ) {
			$oa = (int) get_term_meta( $a->term_id, LINSY_GRADE_ORDER_META, true );
			$ob = (int) get_term_meta( $b->term_id, LINSY_GRADE_ORDER_META, true );

			if ( $oa <= 0 ) {
				$oa = LINSY_GRADE_ORDER_DEFAULT;
			}
			if ( $ob <= 0 ) {
				$ob = LINSY_GRADE_ORDER_DEFAULT;
			}

			if ( $oa !== $ob ) {
				return $direction * ( $oa <=> $ob );
			}

			// 同 Order 值按名称升序，保证确定性（点击 Order 表头切换 DESC 时也同样用 name 升序当 tie-breaker，符合直觉）。
			return $direction * ( strcasecmp( $a->name, $b->name ) );
		}
	);

	return $terms;
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
