<?php
/**
 * Register Custom Taxonomies for Product CPT
 *
 * 1. Product Shape (product_shape) - e.g., Sheet, Bar, Tube
 * 2. Product Material (product_material) - e.g., Pure Copper, Brass
 * 3. Product Grade (product_grade) - e.g., C11000, C12200
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function linsy_register_product_taxonomies() {

	/**
	 * Taxonomy: Product Shape
	 * Slug: /shape/
	 */
	$labels_shape = array(
		'name'              => _x( 'Shapes', 'taxonomy general name', 'generatepress-child' ),
		'singular_name'     => _x( 'Shape', 'taxonomy singular name', 'generatepress-child' ),
		'search_items'      => __( 'Search Shapes', 'generatepress-child' ),
		'all_items'         => __( 'All Shapes', 'generatepress-child' ),
		'parent_item'       => __( 'Parent Shape', 'generatepress-child' ),
		'parent_item_colon' => __( 'Parent Shape:', 'generatepress-child' ),
		'edit_item'         => __( 'Edit Shape', 'generatepress-child' ),
		'update_item'       => __( 'Update Shape', 'generatepress-child' ),
		'add_new_item'      => __( 'Add New Shape', 'generatepress-child' ),
		'new_item_name'     => __( 'New Shape Name', 'generatepress-child' ),
		'menu_name'         => __( 'Shapes', 'generatepress-child' ),
	);

	register_taxonomy( 'product_shape', array( 'product' ), array(
		'hierarchical'      => true,
		'labels'            => $labels_shape,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'shape',
			'with_front' => false,
		), // /shape/copper-sheet/
		'show_in_rest'      => true, // Enable for Gutenberg/REST API
	) );

	/**
	 * Taxonomy: Product Material
	 * Slug: /material/
	 */
	$labels_material = array(
		'name'              => _x( 'Materials', 'taxonomy general name', 'generatepress-child' ),
		'singular_name'     => _x( 'Material', 'taxonomy singular name', 'generatepress-child' ),
		'search_items'      => __( 'Search Materials', 'generatepress-child' ),
		'all_items'         => __( 'All Materials', 'generatepress-child' ),
		'parent_item'       => __( 'Parent Material', 'generatepress-child' ),
		'parent_item_colon' => __( 'Parent Material:', 'generatepress-child' ),
		'edit_item'         => __( 'Edit Material', 'generatepress-child' ),
		'update_item'       => __( 'Update Material', 'generatepress-child' ),
		'add_new_item'      => __( 'Add New Material', 'generatepress-child' ),
		'new_item_name'     => __( 'New Material Name', 'generatepress-child' ),
		'menu_name'         => __( 'Materials', 'generatepress-child' ),
	);

	register_taxonomy( 'product_material', array( 'product' ), array(
		'hierarchical'      => true,
		'labels'            => $labels_material,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'material',
			'with_front' => false,
		), // /material/brass/
		'show_in_rest'      => true,
	) );

	/**
	 * Taxonomy: Product Grade
	 * Slug: /grade/
	 */
	$labels_grade = array(
		'name'              => _x( 'Grades', 'taxonomy general name', 'generatepress-child' ),
		'singular_name'     => _x( 'Grade', 'taxonomy singular name', 'generatepress-child' ),
		'search_items'      => __( 'Search Grades', 'generatepress-child' ),
		'all_items'         => __( 'All Grades', 'generatepress-child' ),
		'parent_item'       => __( 'Parent Grade', 'generatepress-child' ),
		'parent_item_colon' => __( 'Parent Grade:', 'generatepress-child' ),
		'edit_item'         => __( 'Edit Grade', 'generatepress-child' ),
		'update_item'       => __( 'Update Grade', 'generatepress-child' ),
		'add_new_item'      => __( 'Add New Grade', 'generatepress-child' ),
		'new_item_name'     => __( 'New Grade Name', 'generatepress-child' ),
		'menu_name'         => __( 'Grades', 'generatepress-child' ),
	);

	register_taxonomy( 'product_grade', array( 'product' ), array(
		'hierarchical'      => true,
		'labels'            => $labels_grade,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'grade',
			'with_front' => false,
		), // /grade/c11000/
		'show_in_rest'      => true,
	) );

	/**
	 * Taxonomy: Product Tag (Secondary Filter)
	 * Slug: /product-tag/
	 * Used for: "By Material" vs "By Feature" Tabs
	 */
	$labels_tag = array(
		'name'              => _x( 'Product Tags', 'taxonomy general name', 'generatepress-child' ),
		'singular_name'     => _x( 'Product Tag', 'taxonomy singular name', 'generatepress-child' ),
		'search_items'      => __( 'Search Tags', 'generatepress-child' ),
		'all_items'         => __( 'All Tags', 'generatepress-child' ),
		'parent_item'       => __( 'Parent Tag', 'generatepress-child' ),
		'parent_item_colon' => __( 'Parent Tag:', 'generatepress-child' ),
		'edit_item'         => __( 'Edit Tag', 'generatepress-child' ),
		'update_item'       => __( 'Update Tag', 'generatepress-child' ),
		'add_new_item'      => __( 'Add New Tag', 'generatepress-child' ),
		'new_item_name'     => __( 'New Tag Name', 'generatepress-child' ),
		'menu_name'         => __( 'Product Tags', 'generatepress-child' ),
	);

	register_taxonomy( 'product_tag', array( 'product' ), array(
		'hierarchical'      => true, // Hierarchical allows Parent (Group) -> Child (Tag) structure
		'labels'            => $labels_tag,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'product-tag',
			'with_front' => false,
		),
		'show_in_rest'      => true,
	) );
}
add_action( 'init', 'linsy_register_product_taxonomies' );
