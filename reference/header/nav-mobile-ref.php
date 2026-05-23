<?php
/**
 * Template part for displaying the mobile navigation (drawer).
 *
 * @package GeneratePress
 */

// Fetch ACF Data
$header_capabilities_parent_link = function_exists( 'get_field' ) ? get_field( 'header_capabilities_link', 'option' ) : null;
$header_materials_parent_link = function_exists( 'get_field' ) ? get_field( 'header_materials_link', 'option' ) : null;

$header_capabilities = function_exists( 'get_field' ) ? get_field( 'header_capabilities_items', 'option' ) : null;
$header_material_columns = function_exists( 'get_field' ) ? get_field( 'header_material_columns', 'option' ) : null;
$header_company_items = function_exists( 'get_field' ) ? get_field( 'header_company_items', 'option' ) : null;
$header_cta = function_exists( 'get_field' ) ? get_field( 'header_brand_global', 'option' )['cta_button'] ?? null : null;

?>

<!-- 4. Mobile Menu Toggle (Hamburger) -->
<button type="button" class="lg:hidden bg-transparent border-none p-0 focus:outline-none" @click="mobileOpen = ! mobileOpen" aria-label="Toggle navigation">
	<svg class="h-6 w-6 text-heading" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
		<path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
		<path x-show="mobileOpen" x-cloak d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
	</svg>
</button>

<!-- ==========================================================================
		IV. 移动端菜单 (Mobile Menu Drawer)
		========================================================================== -->
<div x-show="mobileOpen" x-cloak
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 -translate-y-2"
		x-transition:enter-end="opacity-100 translate-y-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 translate-y-0"
		x-transition:leave-end="opacity-0 -translate-y-2"
		class="absolute top-full left-0 w-full bg-white border-t border-border lg:hidden max-h-[calc(100vh-80px)] overflow-y-auto">
	<div class="px-container py-6 space-y-6">
		
		<!-- 4.1 Mobile Capabilities -->
		<div>
			<?php if ( ! empty( $header_capabilities_parent_link['url'] ) ) : ?>
				<a href="<?php echo esc_url( $header_capabilities_parent_link['url'] ); ?>" class="mb-3 block text-xs font-semibold tracking-[-0.01em] text-muted hover:text-primary transition-colors">Capabilities →</a>
			<?php else : ?>
				<h3 class="mb-3 text-xs font-semibold tracking-[-0.01em] text-muted">Capabilities</h3>
			<?php endif; ?>
			<div class="grid gap-2">
				<?php if ( ! empty( $header_capabilities ) && is_array( $header_capabilities ) ) : ?>
					<?php foreach ( $header_capabilities as $item ) : ?>
						<?php
							$tech_name = isset( $item['tech_name'] ) ? $item['tech_name'] : '';
							$link = isset( $item['link'] ) ? $item['link'] : null;
							$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" class="block rounded-lg px-3 py-2 text-sm font-semibold text-heading hover:bg-gray-50 hover:text-primary">
							<?php echo esc_html( $tech_name ); ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- 4.2 Mobile Materials -->
		<div>
			<?php if ( ! empty( $header_materials_parent_link['url'] ) ) : ?>
				<a href="<?php echo esc_url( $header_materials_parent_link['url'] ); ?>" class="mb-3 block text-xs font-semibold tracking-[-0.01em] text-muted hover:text-primary transition-colors">Materials →</a>
			<?php else : ?>
				<h3 class="mb-3 text-xs font-semibold tracking-[-0.01em] text-muted">Materials</h3>
			<?php endif; ?>
			<div class="space-y-4">
				<?php if ( ! empty( $header_material_columns ) && is_array( $header_material_columns ) ) : ?>
					<?php foreach ( $header_material_columns as $column ) : ?>
						<?php
							$column_title = isset( $column['title'] ) ? $column['title'] : '';
							$links = isset( $column['links'] ) ? $column['links'] : null;
						?>
						<div>
							<div class="mb-2 text-[11px] font-bold text-gray-400 pl-3"><?php echo esc_html( $column_title ); ?></div>
							<?php if ( ! empty( $links ) && is_array( $links ) ) : ?>
								<div class="grid gap-1 border-l-2 border-gray-100 ml-3 pl-3">
									<?php foreach ( $links as $link_item ) : ?>
										<?php
											$material_id = isset( $link_item['material_id'] ) ? $link_item['material_id'] : null;
											$label = ! empty( $link_item['label'] ) ? $link_item['label'] : ( $material_id ? get_the_title( $material_id ) : '' );
											$url = $material_id ? get_permalink( $material_id ) : '';
										?>
										<a href="<?php echo esc_url( $url ); ?>" class="block py-1 text-sm text-heading hover:text-primary"><?php echo esc_html( $label ); ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- 4.3 Mobile Company -->
		<div>
			<h3 class="mb-3 text-xs font-semibold tracking-[-0.01em] text-muted">Company</h3>
			<div class="grid gap-2">
				<?php if ( ! empty( $header_company_items ) && is_array( $header_company_items ) ) : ?>
					<?php foreach ( $header_company_items as $item ) : ?>
						<?php
							$title = isset( $item['title'] ) ? $item['title'] : '';
							$link = isset( $item['link'] ) ? $item['link'] : null;
							$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" class="block rounded-lg px-3 py-2 text-sm font-semibold text-heading hover:bg-gray-50 hover:text-primary"><?php echo esc_html( $title ); ?></a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- 4.4 Mobile CTA -->
		<?php if ( is_array( $header_cta ) && ! empty( $header_cta['url'] ) ) : ?>
			<div class="pt-4 border-t border-gray-100">
				<?php
					$cta_url = $header_cta['url'];
					$cta_title = isset( $header_cta['title'] ) ? esc_html( $header_cta['title'] ) : '';
				?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white transition hover:bg-primary-hover">
					<span><?php echo $cta_title ? $cta_title : esc_html__( 'Get Instant Quote', 'generatepress' ); ?></span>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>