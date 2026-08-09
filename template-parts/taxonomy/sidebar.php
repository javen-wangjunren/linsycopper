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

$product_search_api = function_exists( 'rest_url' ) ? rest_url( 'linsy/v1/product-search' ) : '';
?>
<?php
// 预计算 grade 当前 active 上下文：如果当前 taxonomy 是 product_grade，则带上当前 term id。
// 供 Alpine 渲染 grade 树时判断 active 高亮（和 Shapes / Materials 栏行为一致）。
$grade_active_context = array(
	'is_grade' => ( 'product_grade' === $current_taxonomy ),
	'term_id'  => (int) $current_term_id,
);
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
		get gradeTree() {
			const nodes = new Map(this.grades.map((g) => [g.id, { ...g, children: [] }]));
			const roots = [];
			for (const g of nodes.values()) {
				const parent = nodes.get(g.parent);
				if (parent) parent.children.push(g);
				else roots.push(g);
			}
			return roots;
		},
		isActiveGrade(id) {
			return this.gradeActive && this.gradeActive.is_grade && (this.gradeActive.term_id === id);
		},
		gradeClass(id, isChild) {
			const active = this.isActiveGrade(id);
			const indent = isChild ? 'pl-10' : 'pl-4';
			const base = 'block pr-4 py-2 text-sm transition border-l border-transparent ';
			if (active) {
				return base + 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570] ' + indent;
			}
			return base + 'text-gray-500 hover:bg-gray-50 hover:text-[#0B3570] ' + indent;
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

				<nav x-show="productResults.length > 0" class="lc-mono-meta mb-3 flex flex-col border-l border-gray-100">
					<template x-for="item in productResults" :key="item.url">
						<a :href="item.url" class="border-l border-transparent px-4 py-2 text-gray-500 transition hover:bg-gray-50 hover:text-[#0B3570]" x-text="item.name"></a>
					</template>
				</nav>

				<nav class="lc-mono-meta flex flex-col border-l border-gray-100">
					<!-- 搜索模式: 扁平筛选结果（不分级，避免被父分组漏掉） -->
					<template x-if="searching">
						<div>
							<template x-for="grade in filteredGrades" :key="grade.url">
								<a :href="grade.url" :class="gradeClass(grade.id, false)" x-text="grade.name"></a>
							</template>
						</div>
					</template>

					<!-- 浏览模式: 纯缩进层级树（父级 pl-4 / 子级 pl-10，步长 24px）。
					     不用 font-weight、不用语义色区分级；全部同字号同颜色，只靠左边线 + 缩进分级。 -->
					<template x-if="!searching">
						<div>
							<template x-for="group in gradeTree" :key="group.url">
								<div>
									<a :href="group.url" :class="gradeClass(group.id, false)" x-text="group.name"></a>
									<template x-if="group.children.length > 0">
										<div>
											<template x-for="child in group.children" :key="child.url">
												<a :href="child.url" :class="gradeClass(child.id, true)" x-text="child.name"></a>
											</template>
										</div>
									</template>
								</div>
							</template>
						</div>
					</template>

					<div x-show="!loading && searching && productResults.length === 0 && filteredGrades.length === 0" class="px-4 py-4 text-center text-gray-400">
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
