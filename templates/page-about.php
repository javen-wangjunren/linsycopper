<?php
/**
 * Template Name: About Page
 * Description: Modular about page template.
 * 
 * Logic:
 * Assembles the About page using modular blocks.
 * 1. Mission & Values
 * 2. Company Timeline
 * 3. Our Team
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * 1. Mission & Values
 */
get_template_part( 'template-parts/pages/about/mission' );

/**
 * 2. Company Timeline
 */
get_template_part( 'template-parts/pages/about/timeline' );

/**
 * 3. Our Team
 */
get_template_part( 'template-parts/pages/about/team' );

/**
 * 4. Certifications (Global)
 */
get_template_part( 'template-parts/global/certifications' );

/**
 * 5. Brand Trust
 */
get_template_part( 'template-parts/pages/about/brand-trust' );

/**
 * 6. Consult Form (Global)
 */
get_template_part( 'template-parts/global/consult-form' );

get_footer();
