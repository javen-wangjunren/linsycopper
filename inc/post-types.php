<?php
/**
 * Custom Post Types Registration
 *
 * Registers custom CPTs for the catalog and marketing content.
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function() {
	
	/**
	 * CPT: Product
	 * URL: /products/c11000-copper-sheet/
	 */
	register_post_type( 'product', array(
		'labels' => array(
			'name'               => 'Products',
			'singular_name'      => 'Product',
			'menu_name'          => 'Products',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Product',
			'edit_item'          => 'Edit Product',
			'new_item'           => 'New Product',
			'view_item'          => 'View Product',
			'search_items'       => 'Search Products',
			'not_found'          => 'No products found',
			'not_found_in_trash' => 'No products found in Trash',
		),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'products', 'with_front' => false ),
		'capability_type'     => 'post',
		'has_archive'         => false,
		'hierarchical'        => false,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-products', // Use appropriate Dashicon
		'supports'            => array( 'title', 'thumbnail', 'excerpt', 'revisions' ),
		'show_in_rest'        => true, // Enable Gutenberg editor (optional, set false if pure ACF)
	) );

	/**
	 * CPT: Industry
	 * URL: /industries/aerospace-defense/
	 */
	register_post_type( 'industry', array(
		'labels' => array(
			'name'               => 'Industries',
			'singular_name'      => 'Industry',
			'menu_name'          => 'Industries',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Industry',
			'edit_item'          => 'Edit Industry',
			'new_item'           => 'New Industry',
			'view_item'          => 'View Industry',
			'search_items'       => 'Search Industries',
			'not_found'          => 'No industries found',
			'not_found_in_trash' => 'No industries found in Trash',
		),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'industries', 'with_front' => false ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-admin-multisite',
		'supports'            => array( 'title', 'thumbnail', 'excerpt', 'revisions' ),
		'show_in_rest'        => true,
	) );

} );
