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
//   - 最后一个 child 用 "└──" 图标，其余用 "├──" 图标
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
		$total       = count( $child_terms );
		foreach ( array_values( $child_terms ) as $i => $c ) {
			$children[] = array(
				'term' => $c,
				'last' => ( $i === $total - 1 ),
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
 * 约定（和 Shapes / Materials 完全一致的 active 样式）：
 * - inactive:  text-sm / text-gray-500 / hover:bg-gray-50 hover:text-[#0B3570]
 * - active:    border-l-2 border-[#F97C30] + bg-slate-50 + font-bold + text-[#0B3570]
 * 层级区分 ONLY by:
 *   - padding-left 绝对差值（父级 pl-[1.5rem] / 子级 pl-[3rem]）
 *   - 子级 ::before 的 "├──" / "└──" 树形导引线（SVG data-uri，画在 padding 空白里）
 *   不用 font-weight / 语义色区分层级
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

	$base = 'block border-l border-transparent pr-4 py-2 text-sm transition relative ';
	// 层级缩进：父 1.5rem (24px) / 子 3rem (48px)
	// 子级多出来的 1.5rem 空间刚好放 ├── / └── 图标
	$indent = $is_child ? 'lc-grade-nav-child pl-[3rem]' : 'lc-grade-nav-parent pl-[1.5rem]';

	if ( $is_active ) {
		return $base . 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570] ' . $indent;
	}

	return $base . 'text-gray-500 hover:bg-gray-50 hover:text-[#0B3570] ' . $indent;
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
			const base   = 'block border-l border-transparent pr-4 py-2 text-sm transition relative pl-[1.5rem] ';
			if (active) {
				return base + 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570] ';
			}
			return base + 'text-gray-500 hover:bg-gray-50 hover:text-[#0B3570] ';
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
			<div class="space-y-10">
				<div>
				<h3 class="lc-mono-kicker mb-4 block border-b border-gray-100 pb-2 text-[#0B3570]">
					Copper Shapes
				</h3>
				<nav class="flex flex-col border-l border-gray-100">
					<?php
					if ( ! is_wp_error( $shapes ) && ! empty( $shapes ) ) :
						foreach ( $shapes as $s ) :
							$is_active    = ( $current_taxonomy === 'product_shape' && $current_term_id === $s->term_id );
							$active_class = $is_active ? 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570]' : 'text-gray-500 hover:bg-gray-50';
							?>
							<a href="<?php echo esc_url( get_term_link( $s ) ); ?>" class="px-4 py-2 text-sm transition <?php echo $active_class; ?>">
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
				<nav class="flex flex-col border-l border-gray-100">
					<?php
					if ( ! is_wp_error( $materials ) && ! empty( $materials ) ) :
						foreach ( $materials as $m ) :
							$is_active    = ( $current_taxonomy === 'product_material' && $current_term_id === $m->term_id );
							$active_class = $is_active ? 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570]' : 'text-gray-500 hover:bg-gray-50';
							?>
							<a href="<?php echo esc_url( get_term_link( $m ) ); ?>" class="px-4 py-2 text-sm transition <?php echo $active_class; ?>">
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

				<nav x-show="productResults.length > 0" class="lc-mono-meta mb-3 flex flex-col border-l border-gray-100" style="display: none;">
					<template x-for="item in productResults" :key="item.url">
						<a :href="item.url" class="border-l border-transparent pl-[1.5rem] pr-4 py-2 text-sm text-gray-500 transition hover:bg-gray-50 hover:text-[#0B3570]" x-text="item.name"></a>
					</template>
				</nav>

				<nav class="lc-mono-meta flex flex-col border-l border-gray-100">
					<style>
						/* 层级区分：纯靠缩进 + ├──/└── 树形导引线，不用 font-weight / 语义色。
						   SVG 线宽 1.5px，颜色 gray-300；对齐基线（文字行高中点）。
						   ├── 竖线到底、横线连文字；└── 竖线只到横线处（最后一项）。 */
						.lc-grade-nav-child::before {
							content: '';
							position: absolute;
							left: 1.25rem;        /* 刚好在父级 1.5rem padding 起始处，缩进视觉差 1.75rem */
							top: 0;
							bottom: 0;
							width: 1px;
							background-color: transparent;
							background-repeat: no-repeat;
							background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="36" viewBox="0 0 20 36" preserveAspectRatio="none"><path d="M1 0 V36" stroke="%23D1D5DB" stroke-width="1.5" fill="none"/><path d="M1 18 H19" stroke="%23D1D5DB" stroke-width="1.5" fill="none"/></svg>');
							background-size: 100% 100%;
						}
						.lc-grade-nav-child.is-grade-last::before {
							background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="36" viewBox="0 0 20 36" preserveAspectRatio="none"><path d="M1 0 V18 H19" stroke="%23D1D5DB" stroke-width="1.5" fill="none"/></svg>');
						}
					</style>

					<!-- 搜索模式：扁平列表（Alpine x-for），不分层，避免分组漏搜 -->
					<div x-show="searching" style="display: none;">
						<template x-for="grade in filteredGrades" :key="grade.url">
							<a :href="grade.url" :class="gradeSearchClass(grade.id)" x-text="grade.name"></a>
						</template>
					</div>

					<!-- 浏览模式：PHP 服务端直接渲染两级树。
					     x-show="!searching"：搜索时隐藏；Alpine 即使未激活也不影响（默认 display 正常展示）。
					     ├── / └── 导引线条通过 <span class="lc-grade-nav-child" data-last=1> 来区分。
					     不用字体粗细、不用语义色区分层级，只靠缩进 + 导引线。 -->
					<div x-show="!searching">
						<?php
						foreach ( $grade_tree as $node ) :
							$parent = $node['parent'];
							?>
							<a
								href="<?php echo esc_url( get_term_link( $parent ) ); ?>"
								class="<?php echo esc_attr( linsy_grade_sidebar_item_class( $parent, false, $current_term_id, $current_taxonomy ) ); ?>"
							>
								<?php echo esc_html( $parent->name ); ?>
							</a>
							<?php
							if ( ! empty( $node['children'] ) ) :
								foreach ( $node['children'] as $ck => $child_node ) :
									$c        = $child_node['term'];
									$is_last  = (bool) $child_node['last'];
									$classes  = linsy_grade_sidebar_item_class( $c, true, $current_term_id, $current_taxonomy );
									$classes .= $is_last ? ' is-grade-last' : '';
									?>
									<a
										href="<?php echo esc_url( get_term_link( $c ) ); ?>"
										class="<?php echo esc_attr( $classes ); ?>"
									>
										<?php echo esc_html( $c->name ); ?>
									</a>
									<?php
								endforeach;
							endif;
						endforeach;
						?>
					</div>

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
