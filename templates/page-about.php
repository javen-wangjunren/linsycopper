<?php
/**
 * Template Name: About Page
 * Description: Modular about page template.
 * 
 * Logic:
 * Assembles the About page using modular blocks.
 * 1. Hero (reused from home)
 * 2. Mission & Values
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * 1. About Hero
 * Reuses the home hero module logic.
 */
get_template_part( 'template-parts/pages/home/hero' );

/**
 * 2. Mission & Values
 */
get_template_part( 'template-parts/pages/about/mission' );

/**
 * 3. Company Timeline
 */
get_template_part( 'template-parts/pages/about/timeline' );

/**
 * 5. Our Team
 */
get_template_part( 'template-parts/pages/about/team' );

/**
 * 6. Certifications (Global)
 */
get_template_part( 'template-parts/global/certifications' );

/**
 * 7. Consult Form (Global)
 */
get_template_part( 'template-parts/global/consult-form' );

get_footer();
