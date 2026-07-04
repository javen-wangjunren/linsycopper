<?php
/**
 * Breadcrumb Helpers
 *
 * Product breadcrumb rule:
 * Home > Taxonomy Hub > Term > Product
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the supported product taxonomies in breadcrumb priority order.
 *
 * @return array<string, string>
 */
function linsy_get_product_breadcrumb_taxonomies() {
	return array(
		'product_shape'    => 'Shapes',
		'product_material' => 'Materials',
		'product_grade'    => 'Grades',
	);
}

/**
 * Resolve the hub page for a product taxonomy.
 *
 * @param string $taxonomy Product taxonomy name.
 * @return object|null
 */
function linsy_get_product_taxonomy_hub_page( $taxonomy ) {
	static $cache = array();

	if ( isset( $cache[ $taxonomy ] ) ) {
		return $cache[ $taxonomy ];
	}

	$pages = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => array(
				array(
					'key'   => 'hub_target_taxonomy',
					'value' => $taxonomy,
				),
			),
		)
	);

	$cache[ $taxonomy ] = ! empty( $pages ) ? $pages[0] : null;

	return $cache[ $taxonomy ];
}

/**
 * Resolve the display label for a taxonomy hub page.
 *
 * Prefer the hub hero title so breadcrumb wording matches the actual hub UI.
 *
 * @param object|int $hub_page Hub page object or ID.
 * @return string
 */
function linsy_get_product_taxonomy_hub_label( $hub_page ) {
	$hub_page_id = is_object( $hub_page ) && ! empty( $hub_page->ID ) ? (int) $hub_page->ID : (int) $hub_page;

	if ( $hub_page_id <= 0 ) {
		return '';
	}

	$label = function_exists( 'get_field' ) ? trim( (string) get_field( 'hub_hero_title', $hub_page_id ) ) : '';

	if ( '' !== $label ) {
		return $label;
	}

	return (string) get_the_title( $hub_page_id );
}

/**
 * Resolve the active breadcrumb taxonomy context for a product.
 *
 * @param int $post_id Product post ID.
 * @return array<string, mixed>
 */
function linsy_get_product_breadcrumb_context( $post_id ) {
	$post_id = (int) $post_id;

	if ( $post_id <= 0 || 'product' !== get_post_type( $post_id ) ) {
		return array();
	}

	foreach ( array_keys( linsy_get_product_breadcrumb_taxonomies() ) as $taxonomy ) {
		$terms = wp_get_post_terms(
			$post_id,
			$taxonomy,
			array(
				'orderby' => 'name',
				'order'   => 'ASC',
			)
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			continue;
		}

		return array(
			'taxonomy' => $taxonomy,
			'term'     => $terms[0],
			'hub_page' => linsy_get_product_taxonomy_hub_page( $taxonomy ),
		);
	}

	return array();
}

/**
 * Build breadcrumb items for a single product page.
 *
 * @param int $post_id Product post ID.
 * @return array<int, array<string, string>>
 */
function linsy_get_product_breadcrumb_items( $post_id ) {
	$post_id = (int) $post_id;

	if ( $post_id <= 0 ) {
		$post_id = get_the_ID();
	}

	$context = linsy_get_product_breadcrumb_context( $post_id );

	if ( empty( $context['term'] ) || ! is_object( $context['term'] ) || empty( $context['term']->name ) ) {
		return array();
	}

	$items = array(
		array(
			'label' => 'Home',
			'url'   => home_url( '/' ),
		),
	);

	if ( ! empty( $context['hub_page'] ) && is_object( $context['hub_page'] ) ) {
		$hub_url = get_permalink( $context['hub_page'] );
		$hub_label = linsy_get_product_taxonomy_hub_label( $context['hub_page'] );

		if ( $hub_url && $hub_label ) {
			$items[] = array(
				'label' => $hub_label,
				'url'   => $hub_url,
			);
		}
	}

	$term_url = get_term_link( $context['term'] );

	if ( ! is_wp_error( $term_url ) && ! empty( $term_url ) ) {
		$items[] = array(
			'label' => $context['term']->name,
			'url'   => $term_url,
		);
	}

	$items[] = array(
		'label' => get_the_title( $post_id ),
		'url'   => '',
	);

	return array_values(
		array_filter(
			$items,
			static function ( $item ) {
				return ! empty( $item['label'] );
			}
		)
	);
}

/**
 * Render breadcrumbs for a single product page.
 *
 * @param int $post_id Product post ID.
 * @return void
 */
function linsy_render_product_breadcrumbs( $post_id = 0 ) {
	$items = linsy_get_product_breadcrumb_items( $post_id );

	if ( count( $items ) < 3 ) {
		return;
	}
	?>
	<div class="lc-breadcrumb-scope mb-3">
		<nav aria-label="Breadcrumb" class="text-sm text-gray-500 sm:text-[15px]">
			<ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
				<?php foreach ( $items as $index => $item ) : ?>
					<?php $is_last = $index === array_key_last( $items ); ?>
					<li class="flex items-center gap-x-2">
						<?php if ( ! empty( $item['url'] ) && ! $is_last ) : ?>
							<a href="<?php echo esc_url( $item['url'] ); ?>" class="transition-colors hover:text-[#0B3570]">
								<?php echo esc_html( $item['label'] ); ?>
							</a>
						<?php else : ?>
							<span class="<?php echo $is_last ? 'font-medium text-[#0B3570]' : ''; ?>">
								<?php echo esc_html( $item['label'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! $is_last ) : ?>
							<span aria-hidden="true" class="text-gray-300">/</span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</nav>
	</div>
	<?php
}

/**
 * Build breadcrumb items for a taxonomy archive page.
 *
 * Taxonomy rule:
 * Home > Taxonomy Hub > Term
 *
 * @param WP_Term|object|null $term Taxonomy term object. Defaults to current queried term.
 * @return array<int, array<string, string>>
 */
function linsy_get_taxonomy_breadcrumb_items( $term = null ) {
	if ( ! $term ) {
		$term = get_queried_object();
	}

	if ( ! is_object( $term ) || empty( $term->taxonomy ) || empty( $term->name ) ) {
		return array();
	}

	$items = array(
		array(
			'label' => 'Home',
			'url'   => home_url( '/' ),
		),
	);

	$hub_page = linsy_get_product_taxonomy_hub_page( $term->taxonomy );

	if ( $hub_page && is_object( $hub_page ) ) {
		$hub_url   = get_permalink( $hub_page );
		$hub_label = linsy_get_product_taxonomy_hub_label( $hub_page );

		if ( $hub_url && $hub_label ) {
			$items[] = array(
				'label' => $hub_label,
				'url'   => $hub_url,
			);
		}
	}

	$items[] = array(
		'label' => $term->name,
		'url'   => '',
	);

	return array_values(
		array_filter(
			$items,
			static function ( $item ) {
				return ! empty( $item['label'] );
			}
		)
	);
}
