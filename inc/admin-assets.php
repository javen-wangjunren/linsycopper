<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
		return;
	}

	$css_file = 'assets/css/admin-acf.css';
	$css_path = get_stylesheet_directory() . '/' . $css_file;
	$css_uri  = get_stylesheet_directory_uri() . '/' . $css_file;

	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'lc-admin-acf',
			$css_uri,
			[],
			filemtime( $css_path )
		);
	}
} );

