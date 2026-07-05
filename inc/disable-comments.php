<?php
/**
 * Disable Comments Site-Wide
 * ==========================================================================
 * 文件作用:
 * 统一关闭站点的评论功能，包括前台评论能力、后台评论入口和管理栏入口。
 *
 * 适用场景:
 * - 企业官网
 * - 产品目录站
 * - 不需要用户评论互动的站点
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove comment and trackback support from all post types.
 */
function linsy_disable_comments_support() {
	foreach ( get_post_types_by_support( 'comments' ) as $post_type ) {
		remove_post_type_support( $post_type, 'comments' );
		remove_post_type_support( $post_type, 'trackbacks' );
	}
}
add_action( 'admin_init', 'linsy_disable_comments_support' );

/**
 * Force comments and pings closed on the frontend.
 *
 * @return false
 */
function linsy_force_comments_closed() {
	return false;
}
add_filter( 'comments_open', 'linsy_force_comments_closed', 20, 2 );
add_filter( 'pings_open', 'linsy_force_comments_closed', 20, 2 );

/**
 * Hide existing comments output.
 *
 * @return array
 */
function linsy_hide_existing_comments() {
	return array();
}
add_filter( 'comments_array', 'linsy_hide_existing_comments', 10, 2 );

/**
 * Remove comments menu from WP Admin.
 */
function linsy_remove_comments_admin_menu() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'linsy_remove_comments_admin_menu' );

/**
 * Redirect direct access to the comments admin screen.
 */
function linsy_redirect_comments_admin_page() {
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
}
add_action( 'admin_init', 'linsy_redirect_comments_admin_page' );

/**
 * Remove comments node from the admin bar.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
 */
function linsy_remove_comments_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'comments' );
}
add_action( 'admin_bar_menu', 'linsy_remove_comments_admin_bar', 999 );
