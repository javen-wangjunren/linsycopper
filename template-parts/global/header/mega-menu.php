<?php
/**
 * Mega Menu / Dropdown Template Part
 * 
 * Logic:
 * - Checks if the item has grandchildren (Level 3).
 * - If yes -> Renders Full Width Mega Menu.
 * - If no -> Renders Simple Dropdown.
 * 
 * Context:
 * - $args['item'] or $mega_menu_item must be set.
 * - Depends on Alpine.js state `openMenu`.
 */

// Support both set_query_var and get_template_part args
$item = isset( $args['item'] ) ? $args['item'] : ( isset( $mega_menu_item ) ? $mega_menu_item : null );
$index = isset( $args['index'] ) ? $args['index'] : ( isset( $mega_menu_index ) ? $mega_menu_index : 0 );

if ( ! $item || empty( $item->children ) ) {
	return;
}

// Detect if Mega Menu (Has grandchildren)
$is_mega = false;
foreach ( $item->children as $child ) {
	if ( ! empty( $child->children ) ) {
		$is_mega = true;
		break;
	}
}

// Common Transitions
$transition_classes = "transition-all duration-200 ease-out";
$show_classes = "opacity-100 translate-y-0 pointer-events-auto";
$hide_classes = "opacity-0 -translate-y-2 pointer-events-none";

?>

<?php if ( $is_mega ) : ?>
	<!-- Mega Menu Panel (Full Width) -->
	<div
		x-show="openMenu === <?php echo $index; ?>"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 -translate-y-2"
		x-transition:enter-end="opacity-100 translate-y-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 translate-y-0"
		x-transition:leave-end="opacity-0 -translate-y-2"
		class="lc-mega-menu-scope fixed left-0 right-0 z-40 top-[60px]" 
		@mouseenter="openMenu = <?php echo $index; ?>"
		@mouseleave="openMenu = null"
	>
		<div class="w-full bg-white border-b border-border shadow-[0_12px_32px_rgba(11,53,112,0.12)]">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				
				<!-- Panel Header -->
				<div class="flex items-center justify-between py-3 border-b border-border">
					<div class="flex items-center gap-2">
						<span class="w-1 h-4 bg-action-copper rounded-sm inline-block"></span>
						<span class="text-xs font-semibold text-primary-blue">
							Shop <?php echo esc_html( $item->title ); ?>
						</span>
					</div>
					<a href="<?php echo esc_url( $item->url ); ?>" class="lc-mega-viewall flex items-center gap-1 text-xs font-semibold text-action-copper hover:text-[#e06b20] transition-colors">
						View all <?php echo esc_html( $item->title ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				</div>

				<!-- Columns -->
				<div class="grid py-6 gap-x-6 grid-cols-<?php echo count( $item->children ); ?>">
					<?php foreach ( $item->children as $col ) : ?>
						<div class="flex flex-col gap-2">
							<!-- Column Heading -->
							<a href="<?php echo esc_url( $col->url ); ?>" class="lc-mega-l2 text-sm font-semibold text-primary-blue hover:text-action-copper transition-colors pb-2 border-b border-border">
								<?php echo esc_html( $col->title ); ?>
							</a>
							
							<!-- Sub Items -->
							<?php if ( ! empty( $col->children ) ) : ?>
								<ul class="flex flex-col gap-1 list-none m-0 p-0">
									<?php foreach ( $col->children as $sub ) : ?>
										<li>
											<a href="<?php echo esc_url( $sub->url ); ?>" class="lc-mega-l3 text-sm text-body hover:text-action-copper transition-colors leading-relaxed block py-0.5 font-mono">
												<?php echo esc_html( $sub->title ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
	</div>

<?php else : ?>
	<!-- Simple Dropdown -->
	<div
		x-show="openMenu === <?php echo $index; ?>"
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 -translate-y-2"
		x-transition:enter-end="opacity-100 translate-y-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 translate-y-0"
		x-transition:leave-end="opacity-0 -translate-y-2"
		class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-56 z-40"
		@mouseenter="openMenu = <?php echo $index; ?>"
		@mouseleave="openMenu = null"
	>
		<div class="bg-white border border-border rounded-sm shadow-[0_8px_24px_rgba(11,53,112,0.12)] overflow-hidden py-1">
			<?php foreach ( $item->children as $child ) : ?>
				<a href="<?php echo esc_url( $child->url ); ?>" class="flex items-center gap-2 px-4 py-2.5 text-sm text-primary-blue hover:bg-bg-section hover:text-action-copper transition-colors">
					<?php echo esc_html( $child->title ); ?>
				</a>
			<?php endforeach; ?>
			
			<div class="border-t border-border mt-1 pt-1">
				<a href="<?php echo esc_url( $item->url ); ?>" class="flex items-center gap-1 px-4 py-2 text-xs font-semibold text-action-copper hover:bg-bg-section transition-colors">
					All <?php echo esc_html( $item->title ); ?>
					<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>
