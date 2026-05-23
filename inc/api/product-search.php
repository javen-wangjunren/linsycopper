<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'rest_api_init', function() {
	register_rest_route( 'linsy/v1', '/product-search', array(
		'methods'             => WP_REST_Server::READABLE,
		'permission_callback' => '__return_true',
		'args'                => array(
			'q'     => array(
				'required'          => true,
				'sanitize_callback' => 'sanitize_text_field',
			),
			'limit' => array(
				'required'          => false,
				'default'           => 10,
				'sanitize_callback' => 'absint',
			),
		),
		'callback'            => function( WP_REST_Request $request ) {
			$q     = (string) $request->get_param( 'q' );
			$limit = (int) $request->get_param( 'limit' );
			$limit = max( 1, min( 20, $limit ) );

			$query = new WP_Query( array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'      => $limit,
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
				's'                   => $q,
			) );

			$items = array();
			foreach ( $query->posts as $post ) {
				$items[] = array(
					'name' => get_the_title( $post ),
					'url'  => get_permalink( $post ),
				);
			}

			return rest_ensure_response( array(
				'items' => $items,
			) );
		},
	) );
} );

