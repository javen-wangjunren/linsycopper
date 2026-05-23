<?php
/**
 * Template Name: Taxonomy Hub
 * Description: A hub page that aggregates all terms from a specific taxonomy (e.g. Copper Shapes, Materials).
 * 
 * Logic:
 * 1. Loads 'Hero' (Text Only).
 * 2. Loads 'Grid' (Term List based on 'hub_target_taxonomy').
 * 3. Loads 'CTA' (Bottom Call to Action).
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// 1. Hero Section (Text Only)
get_template_part( 'template-parts/pages/hub/hero' );

// 2. Taxonomy Grid (The Core Content)
get_template_part( 'template-parts/pages/hub/grid' );

// 3. Bottom CTA
get_template_part( 'template-parts/pages/hub/cta' );

get_footer();
