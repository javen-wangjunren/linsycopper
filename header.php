<?php
/**
 * The header for our theme.
 *
 * @package GeneratePressChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Get Menu Tree
$menu_tree = get_primary_menu_tree();

// Get ACF Data
$cta_text = get_field( 'header_cta_text', 'option' );
$cta_link = get_field( 'header_cta_link', 'option' );

// Defaults
if ( ! $cta_text ) $cta_text = 'Get A Quote';
if ( ! $cta_link ) $cta_link = '/contact';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<!-- Preconnect & Preload -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!-- Header Container with Alpine.js State -->
	<header
		x-data="{ openMenu: null, mobileOpen: false }" 
		class="lc-header-scope sticky top-0 z-50 bg-primary-blue shadow-[0_2px_16px_rgba(11,53,112,0.3)]"
		@mouseleave="openMenu = null"
	>
		<nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" aria-label="Main navigation">
			<div class="flex h-[60px] items-center justify-between gap-8">
				
				<!-- 1. Logo -->
				<?php get_template_part( 'template-parts/global/header/logo' ); ?>

				<!-- 2. Desktop Navigation -->
				<div class="hidden lg:flex items-center gap-0.5 flex-1 justify-center">
					<?php foreach ( $menu_tree as $index => $item ) : ?>
						<?php 
						$has_children = ! empty( $item->children ); 
						// Determine if Mega Menu (has grandchildren)
						$is_mega = false;
						if ( $has_children ) {
							foreach ( $item->children as $child ) {
								if ( ! empty( $child->children ) ) {
									$is_mega = true;
									break;
								}
							}
						}
						?>
						<div 
							class="relative"
							@mouseenter="openMenu = <?php echo $index; ?>"
							@mouseleave="openMenu = null"
						>
							<!-- Bridge for Mega Menu -->
							<?php if ( $is_mega ) : ?>
								<div x-show="openMenu === <?php echo $index; ?>" class="absolute left-0 right-0 top-full h-3 z-50" style="display: none;"></div>
							<?php endif; ?>

							<a
								href="<?php echo esc_url( $item->url ); ?>"
								class="lc-header-nav-link relative z-10 flex items-center gap-1 px-3 py-2 text-[14px] font-semibold transition-colors rounded-sm text-white hover:text-white hover:bg-white/10"
								:class="{ 'bg-white/10 text-white': openMenu === <?php echo $index; ?> }"
							>
								<?php echo esc_html( $item->title ); ?>
								<?php if ( $has_children ) : ?>
									<svg 
										xmlns="http://www.w3.org/2000/svg" 
										width="14" 
										height="14" 
										viewBox="0 0 24 24" 
										fill="none" 
										stroke="currentColor" 
										stroke-width="2" 
										stroke-linecap="round" 
										stroke-linejoin="round"
										class="transition-transform duration-200 opacity-70"
										:class="{ 'rotate-180': openMenu === <?php echo $index; ?> }"
									>
										<path d="m6 9 6 6 6-6"/>
									</svg>
								<?php endif; ?>
							</a>

							<!-- Mega Menu / Dropdown Panel -->
							<?php 
							if ( $has_children ) {
								set_query_var( 'mega_menu_item', $item );
								set_query_var( 'mega_menu_index', $index );
								get_template_part( 'template-parts/global/header/mega-menu' ); 
							}
							?>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- 3. Actions (Quote & Mobile Toggle) -->
				<div class="flex items-center gap-4">
					<!-- Quote Button -->
					<a
						href="<?php echo esc_url( $cta_link ); ?>"
						class="lc-header-cta hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-action-copper hover:bg-[#e06b20] transition-all rounded-sm shadow-sm"
					>
						<?php echo esc_html( $cta_text ); ?>
					</a>

					<!-- Mobile Toggle -->
					<button
						@click="mobileOpen = true"
						class="lg:hidden p-2 text-white hover:bg-white/10 rounded-sm transition-colors"
						aria-label="Open menu"
					>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
					</button>
				</div>
			</div>
		</nav>

		<!-- Mobile Menu Drawer -->
		<?php 
		set_query_var( 'menu_tree', $menu_tree );
		get_template_part( 'template-parts/global/header/nav-mobile' ); 
		?>
	</header>

	<div id="page" class="site">
