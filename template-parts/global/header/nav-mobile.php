<?php
/**
 * Mobile Navigation Template Part
 * 
 * Context:
 * - $args['menu_tree'] must be passed.
 * - Depends on Alpine.js state `mobileOpen`.
 */

$menu_tree = isset( $args['menu_tree'] ) ? $args['menu_tree'] : ( isset( $menu_tree ) ? $menu_tree : [] );

if ( empty( $menu_tree ) ) {
	return;
}
?>

<!-- Mobile Menu Drawer -->
<div
	x-cloak
	x-show="mobileOpen"
	class="fixed inset-0 z-50 flex justify-end"
	role="dialog"
	aria-modal="true"
	style="display: none;"
>
	<!-- Backdrop -->
	<div
		x-cloak
		x-show="mobileOpen"
		x-transition:enter="transition-opacity ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		class="fixed inset-0 bg-black/60 backdrop-blur-sm"
		@click="mobileOpen = false"
	></div>

	<!-- Drawer Panel -->
	<div
		x-cloak
		x-show="mobileOpen"
		x-transition:enter="transition ease-out duration-300"
		x-transition:enter-start="translate-x-full"
		x-transition:enter-end="translate-x-0"
		x-transition:leave="transition ease-in duration-200"
		x-transition:leave-start="translate-x-0"
		x-transition:leave-end="translate-x-full"
		class="lc-mobile-menu-scope relative w-full max-w-sm bg-primary-blue h-full shadow-2xl overflow-y-auto"
	>
		<!-- Header -->
		<div class="flex items-center justify-between p-4 border-b border-white/10">
			<span class="text-white font-bold text-lg">Menu</span>
			<button
				@click="mobileOpen = false"
				class="p-2 text-white rounded-sm transition-colors"
				aria-label="Close menu"
			>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
			</button>
		</div>

		<!-- Menu Items -->
		<nav class="p-4 flex flex-col">
			<?php foreach ( $menu_tree as $item ) : ?>
				<?php 
				$has_children = ! empty( $item->children );
				?>
				<div class="border-b border-white/10" x-data="{ open: false }">
					<?php if ( $has_children ) : ?>
						<button
							@click="open = !open"
							class="lc-mobile-nav-trigger flex items-center justify-between w-full py-3.5 text-sm font-semibold text-white transition-colors"
							:aria-expanded="open"
						>
							<?php echo esc_html( $item->title ); ?>
							<svg 
								xmlns="http://www.w3.org/2000/svg" 
								width="16" 
								height="16" 
								viewBox="0 0 24 24" 
								fill="none" 
								stroke="currentColor" 
								stroke-width="2" 
								stroke-linecap="round" 
								stroke-linejoin="round"
								class="transition-transform duration-200"
								:class="open ? 'rotate-180' : ''"
							>
								<path d="m6 9 6 6 6-6"/>
							</svg>
						</button>

						<!-- Accordion Body -->
						<div
							x-cloak
							x-show="open"
							x-collapse
							class="overflow-hidden"
							style="display: none;"
						>
							<div class="pb-4 pl-3 flex flex-col gap-3 border-l-2 border-action-copper/40 ml-1 mb-1">
								<?php foreach ( $item->children as $child ) : ?>
									<div class="flex flex-col gap-1">
										<!-- L2 Heading -->
										<a href="<?php echo esc_url( $child->url ); ?>" @click="mobileOpen = false" class="lc-mobile-nav-l2 mt-1 text-xs font-semibold text-accent-gold">
											<?php echo esc_html( $child->title ); ?>
										</a>
										
										<!-- L3 Items -->
										<?php if ( ! empty( $child->children ) ) : ?>
											<?php foreach ( $child->children as $grandchild ) : ?>
												<a href="<?php echo esc_url( $grandchild->url ); ?>" @click="mobileOpen = false" class="lc-mobile-nav-l3 text-sm text-white/65 transition-colors py-0.5 font-mono">
													<?php echo esc_html( $grandchild->title ); ?>
												</a>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
								
								<!-- Parent Link -->
								<a href="<?php echo esc_url( $item->url ); ?>" @click="mobileOpen = false" class="lc-mobile-nav-viewall flex items-center gap-1 text-xs font-semibold text-action-copper mt-1">
									View all <?php echo esc_html( $item->title ); ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
								</a>
							</div>
						</div>
					<?php else : ?>
						<a
							href="<?php echo esc_url( $item->url ); ?>"
							@click="mobileOpen = false"
							class="lc-mobile-nav-link flex items-center justify-between py-3.5 text-sm font-semibold text-white transition-colors"
						>
							<?php echo esc_html( $item->title ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</nav>
	</div>
</div>
