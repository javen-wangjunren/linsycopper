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

// 3. Grades (for Search)
$grades = get_terms( array(
	'taxonomy'   => 'product_grade',
	'hide_empty' => false,
) );
$grades_data = array();
if ( ! is_wp_error( $grades ) && ! empty( $grades ) ) {
	foreach ( $grades as $g ) {
		$grades_data[] = array(
			'name' => $g->name,
			'url'  => get_term_link( $g ),
		);
	}
}

$product_search_api = function_exists( 'rest_url' ) ? rest_url( 'linsy/v1/product-search' ) : '';
?>

<div
	class="relative w-full font-sans lg:w-72 shrink-0"
	x-data="{
		drawerOpen: false,
		searchQuery: '',
		grades: <?php echo htmlspecialchars( wp_json_encode( $grades_data ), ENT_QUOTES, 'UTF-8' ); ?>,
		results: [],
		loading: false,
		_t: null,
		api: <?php echo htmlspecialchars( wp_json_encode( esc_url_raw( $product_search_api ) ), ENT_QUOTES, 'UTF-8' ); ?>,
		async fetchProducts() {
			const q = (this.searchQuery || '').trim();
			if (q.length < 2 || !this.api) {
				this.results = [];
				return;
			}
			this.loading = true;
			try {
				const res = await fetch(`${this.api}?q=${encodeURIComponent(q)}&limit=10`, { credentials: 'same-origin' });
				const json = await res.json();
				this.results = Array.isArray(json?.items) ? json.items : [];
			} catch (e) {
				this.results = [];
			} finally {
				this.loading = false;
			}
		},
		init() {
			this.$watch('searchQuery', () => {
				clearTimeout(this._t);
				this._t = setTimeout(() => this.fetchProducts(), 250);
			});
		},
		get listItems() {
			const q = (this.searchQuery || '').trim();
			return q === '' ? this.grades : this.results;
		}
	}"
>
	<div class="lc-taxonomy-filter-toggle sticky top-0 z-40 -mx-4 !flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4 lg:hidden">
		<span class="text-sm font-semibold text-[#0B3570]">Filter Materials</span>
		<button @click="drawerOpen = true" class="rounded-sm bg-[#0B3570] p-2 text-white" aria-label="Open filters" type="button">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
		</button>
	</div>

	<div x-show="drawerOpen" x-transition.opacity class="lc-taxonomy-filter-backdrop fixed inset-0 z-40 bg-black/40 lg:hidden" @click="drawerOpen = false" style="display: none;"></div>

	<aside
		:class="drawerOpen ? 'is-open' : ''"
		@keydown.escape.window="drawerOpen = false"
		class="lc-taxonomy-filter-drawer fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-white transition-transform lg:static lg:z-auto lg:w-full lg:bg-transparent lg:shadow-none lg:overflow-visible"
		role="dialog"
		aria-modal="true"
	>
		<div class="lc-taxonomy-filter-drawer-header mb-8 flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4 lg:hidden">
			<span class="text-sm font-semibold text-[#0B3570]">Filters</span>
			<button @click="drawerOpen = false" class="lc-btn-reset inline-flex items-center gap-2 text-sm font-semibold !text-gray-500 hover:!text-[#0B3570] !bg-transparent !p-0 !shadow-none !border-0" type="button">
				Close
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline h-4 w-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
			</button>
		</div>

		<div class="w-full bg-[#F7F8F9] p-8 lg:bg-transparent lg:p-0">
			<div class="space-y-10">
				<div>
					<h3 class="mb-4 block border-b border-gray-100 pb-2 text-xs font-bold uppercase text-[#0B3570]">
						Copper Shapes
					</h3>
					<nav class="flex flex-col border-l border-gray-100">
						<?php
						if ( ! is_wp_error( $shapes ) && ! empty( $shapes ) ) :
							foreach ( $shapes as $s ) :
								$is_active    = ( $current_taxonomy === 'product_shape' && $current_term_id === $s->term_id );
								$active_class = $is_active ? 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570]' : 'text-gray-500 hover:bg-gray-50';
								?>
								<a href="<?php echo esc_url( get_term_link( $s ) ); ?>" class="px-4 py-2 text-sm transition <?php echo esc_attr( $active_class ); ?>">
									<?php echo esc_html( $s->name ); ?>
								</a>
								<?php
							endforeach;
						endif;
						?>
					</nav>
				</div>

				<div>
					<h3 class="mb-4 block border-b border-gray-100 pb-2 text-xs font-bold uppercase text-[#0B3570]">
						Copper Material
					</h3>
					<nav class="flex flex-col border-l border-gray-100">
						<?php
						if ( ! is_wp_error( $materials ) && ! empty( $materials ) ) :
							foreach ( $materials as $m ) :
								$is_active    = ( $current_taxonomy === 'product_material' && $current_term_id === $m->term_id );
								$active_class = $is_active ? 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570]' : 'text-gray-500 hover:bg-gray-50';
								?>
								<a href="<?php echo esc_url( get_term_link( $m ) ); ?>" class="px-4 py-2 text-sm transition <?php echo esc_attr( $active_class ); ?>">
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
						<h3 class="text-xs font-bold uppercase text-[#0B3570]">
							Copper Grade
						</h3>
						<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
					</div>

					<div class="mb-4">
						<input
							type="text"
							x-model="searchQuery"
							placeholder="Search products..."
							class="w-full border border-gray-200 bg-[#F2F4F7] px-3 py-2 font-mono text-[12px] outline-none transition-colors placeholder:text-gray-400 focus:border-[#F97C30]"
						>
					</div>

					<nav class="flex flex-col border-l border-gray-100 font-mono text-[12px]">
						<template x-for="item in listItems" :key="item.url">
							<a :href="item.url" class="border-l border-transparent px-4 py-2 text-gray-500 transition hover:bg-gray-50 hover:text-[#0B3570]" x-text="item.name"></a>
						</template>

						<div x-show="loading" class="px-4 py-2 text-gray-400" style="display: none;">Searching...</div>

						<div x-show="!loading && searchQuery.trim() !== '' && listItems.length === 0" class="px-4 py-4 text-center text-gray-400" style="display: none;">
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
