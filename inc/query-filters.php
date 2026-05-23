<?php
/**
 * Query Filters & Modifications
 * ==========================================================================
 * Handle `pre_get_posts` logic to customize main queries without touching templates.
 * 
 * Logic:
 * 1. Product Taxonomies (Shape, Material, Grade) -> 6 posts per page.
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'pre_get_posts', function( $query ) {
    
    // Only modify main query on frontend
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Target Product Taxonomies
    if ( is_tax( array( 'product_shape', 'product_material', 'product_grade' ) ) ) {
        
        // Set posts per page to 6
        $query->set( 'posts_per_page', 6 );
        
        // Ensure ordering is consistent
        $query->set( 'orderby', 'menu_order title' );
        $query->set( 'order', 'ASC' );

    }

} );
