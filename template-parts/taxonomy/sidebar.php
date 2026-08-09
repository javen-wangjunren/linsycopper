<?php
/**
 * Taxonomy Archive: Sidebar Navigation
 * ==========================================================================
 * Location: template-parts/taxonomy/sidebar.php
 * 
 * Logic:
 * 1. Fetches all Shapes, Materials, and Grades.
 * 2. Highlights the current term.
 * 3. Provides client-side Grade Search via Alpine.js.
 * 4. Grades render as a hierarchical tree (parent → children) and follow
 *    the manual Order set in the admin (inc/grade-order.php).
 * 
 * @package GeneratePress_Child
 */

// Get current term context
// =========================================================================
// TAILWIND v4 CONTENT SCAN HINT (DO NOT REMOVE):
// Tailwind v4 用纯字符串正则扫 class 名。本模板里很多 class 通过 PHP
// 三元字符串和函数返回值动态拼接，扫描器直接扫不到，会导致 class
// 没进入最终 style.css → 页面样式缺失。
// 为了 100% 命中，把所有会用到的 class 在这里作为"死字符串"完整列一遍。
//
//   gap-[2px]
//   text-gray-800
//   hover:bg-[#FDF2E8]    bg-[#FDF2E8]
//   hover:text-[#0B3570]  text-[#0B3570]
//   border-[#F97C30]
// =========================================================================
$term = get_queried_object();
$current_term_id  = $term->term_id;
$current_taxonomy = $term->taxonomy;

// 1. Shapes
$shapes = get_terms( array(
	'taxonomy'   => 'product_shape',
	'hide_empty' => false, 
	'parent'     => 0,
) );

// 2. Materials
$materials = get_terms( array(
	'taxonomy'   => 'product_material',
	'hide_empty' => false,
) );

// 3. Grades (for Search + Tree)
// 按后台 Order 排序；每项带 parent，用于前端组装层级树。
$grades = function_exists( 'linsy_get_ordered_grades' ) ? linsy_get_ordered_grades() : array();
$grades_data = array();
foreach ( $grades as $g ) {
	$grades_data[] = array(
		'id'     => (int) $g->term_id,
		'parent' => (int) $g->parent,
		'name'   => $g->name,
		'url'    => get_term_link( $g ),
	);
}

// 3a. 服务端组装两级树 + 直接输出用的渲染数据（彻底规避 Alpine 未激活导致并排展示）。
// 规则：
//   - roots: parent===0
//   - children: parent===root.id
$grade_tree = array();
if ( ! empty( $grades ) ) {
	$by_id = array();
	foreach ( $grades as $g ) {
		$by_id[ (int) $g->term_id ] = $g;
	}
	$roots = array();
	$kids  = array();
	foreach ( $grades as $g ) {
		$pid = (int) $g->parent;
		if ( 0 === $pid ) {
			$roots[] = $g;
		} else {
			if ( ! isset( $kids[ $pid ] ) ) {
				$kids[ $pid ] = array();
			}
			$kids[ $pid ][] = $g;
		}
	}
	foreach ( $roots as $r ) {
		$child_terms = isset( $kids[ (int) $r->term_id ] ) ? $kids[ (int) $r->term_id ] : array();
		$children    = array();
                foreach ( array_values( $child_terms ) as $c ) {
                        $children[] = array(
                                'term' => $c,
                        );
		}
		$grade_tree[] = array(
			'parent'   => $r,
			'children' => $children,
		);
	}
	unset( $by_id, $roots, $kids, $child_terms, $children );
}

$product_search_api = function_exists( 'rest_url' ) ? rest_url( 'linsy/v1/product-search' ) : '';
?>
<?php
// 预计算 grade 当前 active 上下文：如果当前 taxonomy 是 product_grade，则带上当前 term id。
// 供 Alpine 渲染 grade 树时判断 active 高亮（和 Shapes / Materials 栏行为一致）。
$grade_active_context = array(
	'is_grade' => ( 'product_grade' === $current_taxonomy ),
	'term_id'  => (int) $current_term_id,
);

/**
 * Helper: 输出一条 grade 链接的 class（父级/子级 + 是否 active）
 *
 * 约定：
 * - 基础视觉沿用 .lc-tax-sidebar-item
 * - 层级关系由嵌套 <ul>/<li> 与 child item 的轻缩进表达
 * - active 状态继续复用三栏统一的 is-active 样式
 *
 * @param WP_Term $grade     分类项
 * @param bool    $is_child  是否子级
 * @param int     $current_term_id 当前浏览的 grade 分类项 ID
 * @param string  $current_taxonomy 当前浏览的 taxonomy slug
 * @return string  class 字符串
 */
function linsy_grade_sidebar_item_class( $grade, $is_child, $current_term_id, $current_taxonomy ) {
	$tid       = (int) $grade->term_id;
	$is_active = ( 'product_grade' === $current_taxonomy && (int) $current_term_id === $tid );

        // Grade 与 Shapes / Materials 三栏基线统一为 .lc-tax-sidebar-item。
        // 父/子级只靠语义 class 区分：lc-grade-nav-parent / lc-grade-nav-child。
        // 具体 hover / active / padding 由同文件 scoped style 统一托管。
	$cls = 'lc-tax-sidebar-item';
	$cls .= $is_child ? ' lc-grade-nav-child' : ' lc-grade-nav-parent';
	if ( $is_active ) {
		$cls .= ' is-active';
	}
	return $cls;
}

/**
 * Helper: 返回 grade 链接的 style 属性（padding-left 轻兜底）。
 * 层级关系已经由嵌套 <ul>/<li> 承担，这里只保留 parent/child 文本与边线、marker 的呼吸空间。
 *
 * @param bool $is_child 是否子级
 * @return string style 属性字符串
 */
function linsy_grade_sidebar_item_style( $is_child ) {
        // <a> 只保留最小 padding-left，避免文字贴边。
        // 真正的层级缩进由子级 <li> 的整体位移承担。
	$pl = $is_child ? '6px' : '8px';
	return 'padding-left:' . $pl . ' !important;';
}
?>

<div
	x-data="{
		drawerOpen: false,
		searchQuery: '',
		grades: <?php echo htmlspecialchars( json_encode( $grades_data ), ENT_QUOTES, 'UTF-8' ); ?>,
		gradeActive: <?php echo htmlspecialchars( json_encode( $grade_active_context ), ENT_QUOTES, 'UTF-8' ); ?>,
		productResults: [],
		loading: false,
		_t: null,
		api: <?php echo htmlspecialchars( json_encode( $product_search_api ), ENT_QUOTES, 'UTF-8' ); ?>,
		get searching() {
			return (this.searchQuery || '').trim() !== '';
		},
		isActiveGrade(id) {
			return this.gradeActive && this.gradeActive.is_grade && (this.gradeActive.term_id === id);
		},
		gradeSearchClass(id) {
			const active = this.isActiveGrade(id);
			return 'lc-tax-sidebar-item lc-grade-nav-parent' + (active ? ' is-active' : '');
		},
		gradeSearchStyle() {
			return 'padding-left:16px !important; position:relative;';
		},
		get filteredGrades() {
			const q = (this.searchQuery || '').trim().toLowerCase();
			if (q === '') return this.grades;
			return this.grades.filter((grade) => String(grade.name || '').toLowerCase().includes(q));
		},
		init() {
			this.$watch('searchQuery', () => {
				clearTimeout(this._t);
				this._t = setTimeout(() => this.fetchProducts(), 250);
			});
		},
		async fetchProducts() {
			const q = (this.searchQuery || '').trim();
			if (q.length < 2 || !this.api) {
				this.productResults = [];
				return;
			}
			this.loading = true;
			try {
				const url = this.api + '?q=' + encodeURIComponent(q) + '&limit=10';
				const res = await fetch(url, { credentials: 'same-origin' });
				const json = await res.json();
				this.productResults = (json && Array.isArray(json.items)) ? json.items : [];
			} catch (e) {
				this.productResults = [];
			} finally {
				this.loading = false;
			}
		}
	}"
	@keydown.escape.window="drawerOpen = false"
	x-effect="document.body.style.overflow = drawerOpen ? 'hidden' : ''"
	class="w-full font-sans lg:w-72 flex-shrink-0"
>
	<div class="lc-taxonomy-filter-toggle sticky top-0 z-40 -mx-4 !flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4 lg:hidden">
		<span class="lc-mono-kicker text-[#0B3570]">Filter Catalog</span>
		<button
			@click="drawerOpen = true"
			class="rounded-sm bg-[#0B3570] p-2 text-white"
			aria-label="Open filters"
			type="button"
		>
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
		</button>
	</div>

	<div
		x-show="drawerOpen"
		x-transition:enter="transition-opacity ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		class="lc-taxonomy-filter-backdrop fixed inset-0 z-40 bg-[#0B3570]/60 lg:hidden"
		@click="drawerOpen = false"
		style="display: none;"
	></div>

	<aside
		:class="drawerOpen ? 'is-open' : ''"
		class="lc-taxonomy-filter-drawer fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-white transition-transform lg:static lg:z-auto lg:w-full lg:translate-x-0 lg:bg-transparent lg:shadow-none lg:overflow-visible"
		role="dialog"
		aria-modal="true"
	>
		<div class="lc-taxonomy-filter-drawer-header mb-8 flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4 lg:hidden">
			<span class="text-sm font-bold uppercase text-[#0B3570]">Filters</span>
			<button
				@click="drawerOpen = false"
				class="lc-mono-kicker flex items-center gap-2 !bg-transparent !p-0 !text-gray-400 !shadow-none !border-0 hover:!bg-transparent hover:!text-gray-400 focus:!bg-transparent focus:!text-gray-400"
				type="button"
			>
				CLOSE
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline h-4 w-4 !text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
			</button>
		</div>

		<div class="w-full bg-[#F7F8F9] p-8 lg:bg-transparent lg:p-0">
			<style>
				/* ============================================================
				   Sidebar 三栏 (Shapes / Materials / Grade) 视觉基线统一
				   ============================================================
				   ⚠️ 所有不写死在下面显式 class 的视觉细节，都会因为：
				   1) Tailwind v4 扫 PHP 三元拼接的 class 扫不到
				   2) GeneratePress 全局 a {color:#222} 覆盖 Tailwind text-gray-500
				   导致在用户那边"难看"。所以统一在这里写死显式 CSS 规则，双保险：
				     - 行间呼吸感 gap:2px
				     - 默认文字色 text-gray-800 (#1F2937)
				     - hover 浅铜橙底 #FDF2E8 + 品牌蓝文字 #0B3570
				     - active 铜橙左边线 #F97C30 + bg-slate-50 + 粗体 + 品牌蓝
				   即使 Tailwind utility 没生成，这些规则照样生效。
				*/
				.lc-tax-sidebar-nav         { display:flex; flex-direction:column; gap:2px; }
				.lc-tax-sidebar-item        {
					display:block; border-left:1px solid transparent;
					padding-top:8px; padding-bottom:8px;
					padding-right:16px;
					font-size:14px; line-height:20px;
					transition: background-color 120ms ease, color 120ms ease;
					color:#1F2937;   /* text-gray-800 */
					cursor:pointer; text-decoration:none !important;
				}
				.lc-tax-sidebar-item:hover  { background-color:#FDF2E8; color:#0B3570; }
				.lc-tax-sidebar-item.is-active {
					border-left:2px solid #F97C30;
					background-color:#F8FAFC;  /* bg-slate-50 */
					font-weight:700;
					color:#0B3570;
				}
                                /* Grade 只保留一套层级样式，不再在内层重复写第二份规则。 */
				.lc-grade-nav-parent { padding-left:8px !important; }
				.lc-grade-nav-child  { padding-left:6px !important; }
                                /* Grade 子级：原生 square marker + 轻缩进。
                                   不再混用 SVG、伪元素、双层 scoped style。 */
				.lc-grade-child-list {
                                        margin: 2px 0 0 !important;
                                        padding: 0 !important;
					list-style: none;
				}
				.lc-grade-child-item {
					list-style-type: square !important;
					list-style-position: outside !important;
					list-style-image: none !important;
					position: relative;
					left: 18px;
                                        color: #1F2937;
				}
				.lc-grade-child-item + .lc-grade-child-item { margin-top: 2px; }
				.lc-grade-child-item::marker { color: #9CA3AF; }
			</style>
			<div class="space-y-10">
				<div>
				<h3 class="lc-mono-kicker mb-4 block border-b border-gray-100 pb-2 text-[#0B3570]">
					Copper Shapes
				</h3>
				<nav class="lc-tax-sidebar-nav border-l border-gray-100">
					<?php
					if ( ! is_wp_error( $shapes ) && ! empty( $shapes ) ) :
						foreach ( $shapes as $s ) :
							$is_active    = ( $current_taxonomy === 'product_shape' && $current_term_id === $s->term_id );
							$cls = 'lc-tax-sidebar-item' . ( $is_active ? ' is-active' : '' );
							?>
							<a href="<?php echo esc_url( get_term_link( $s ) ); ?>" class="<?php echo esc_attr( $cls ); ?>" style="padding-left:16px;">
								<?php echo esc_html( $s->name ); ?>
							</a>
						<?php
						endforeach;
					endif;
					?>
				</nav>
				</div>

				<div>
				<h3 class="lc-mono-kicker mb-4 block border-b border-gray-100 pb-2 text-[#0B3570]">
					Copper Material
				</h3>
				<nav class="lc-tax-sidebar-nav border-l border-gray-100">
					<?php
					if ( ! is_wp_error( $materials ) && ! empty( $materials ) ) :
						foreach ( $materials as $m ) :
							$is_active    = ( $current_taxonomy === 'product_material' && $current_term_id === $m->term_id );
							$cls = 'lc-tax-sidebar-item' . ( $is_active ? ' is-active' : '' );
							?>
							<a href="<?php echo esc_url( get_term_link( $m ) ); ?>" class="<?php echo esc_attr( $cls ); ?>" style="padding-left:16px;">
								<?php echo esc_html( $m->name ); ?>
							</a>
						<?php
						endforeach;
					endif;
					?>
				</nav>
				</div>

				<div>
				<div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-2">
					<h3 class="lc-mono-kicker text-[#0B3570]">
						Copper Grade
					</h3>
					<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
				</div>

				<div class="mb-4">
					<input
						type="text"
						x-model="searchQuery"
						placeholder="Search products..."
						class="lc-mono-meta w-full border border-gray-200 bg-[#F2F4F7] px-3 py-2 outline-none transition-colors placeholder:text-gray-400 focus:border-[#F97C30]"
					>
				</div>

				<div x-show="loading" class="lc-mono-meta px-4 py-2 text-gray-400">Searching...</div>

				<nav x-show="productResults.length > 0" class="lc-tax-sidebar-nav lc-mono-meta mb-3 border-l border-gray-100" style="display: none;">
					<template x-for="item in productResults" :key="item.url">
						<a :href="item.url" class="lc-tax-sidebar-item" style="padding-left:16px; position:relative;" x-text="item.name"></a>
					</template>
				</nav>

                                <div class="ml-4">
                                <nav class="lc-tax-sidebar-nav lc-mono-meta border-l border-gray-100">
					<!-- 搜索模式：扁平列表（Alpine x-for），不分层，避免分组漏搜 -->
					<div x-show="searching" style="display: none;">
						<template x-for="grade in filteredGrades" :key="grade.url">
							<a :href="grade.url" :class="gradeSearchClass(grade.id)" :style="gradeSearchStyle()" x-text="grade.name"></a>
						</template>
					</div>

                                        <!-- 浏览模式：原生嵌套列表。父级和子级在一个 <li> 里，结构比“分两个兄弟 <li>”更直接。 -->
					<ul x-show="!searching" class="lc-grade-root-list p-0 m-0 list-none flex flex-col gap-[2px]">
						<?php
						foreach ( $grade_tree as $node ) :
							$parent = $node['parent'];
							?>
							<li class="lc-grade-parent-item list-none">
								<a
									href="<?php echo esc_url( get_term_link( $parent ) ); ?>"
									class="<?php echo esc_attr( linsy_grade_sidebar_item_class( $parent, false, $current_term_id, $current_taxonomy ) ); ?>"
									style="<?php echo esc_attr( linsy_grade_sidebar_item_style( false ) ); ?>"
								>
									<?php echo esc_html( $parent->name ); ?>
								</a>
                                                                <?php if ( ! empty( $node['children'] ) ) : ?>
									<ul class="lc-grade-child-list">
										<?php
										foreach ( $node['children'] as $ck => $child_node ) :
											$c        = $child_node['term'];
											$classes  = linsy_grade_sidebar_item_class( $c, true, $current_term_id, $current_taxonomy );
											?>
											<li class="lc-grade-child-item">
												<a
													href="<?php echo esc_url( get_term_link( $c ) ); ?>"
													class="<?php echo esc_attr( $classes ); ?>"
													style="<?php echo esc_attr( linsy_grade_sidebar_item_style( true ) ); ?>"
												>
													<?php echo esc_html( $c->name ); ?>
												</a>
											</li>
											<?php
										endforeach;
										?>
									</ul>
                                                                <?php endif; ?>
                                                        </li>
                                                        <?php
						endforeach;
						?>
					</ul>

					<div x-show="!loading && searching && productResults.length === 0 && filteredGrades.length === 0" class="px-4 py-4 text-center text-gray-400" style="display: none;">
						<p class="mb-2">No match found</p>
						<a href="/contact-us" class="text-[#F97C30] transition hover:text-[#0B3570]">
							Request Custom Quote &rarr;
						</a>
					</div>
				</nav>
				</div>
			</div>
		</div>
	</aside>
</div>
