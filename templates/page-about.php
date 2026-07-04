<?php
/**
 * Template Name: About Page
 * Description: Modular about page template.
 * 
 * Logic:
 * Assembles the About page using modular blocks.
 * 1. About Hero
 * 2. Founder Message
 * 3. Factory Advantages
 * 4. Factory And Workshop Environment
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * 1. About Hero
 */
get_template_part( 'template-parts/pages/about/about-hero' );

/**
 * 2. Founder Message
 */
get_template_part( 'template-parts/pages/about/founder-message' );

/**
 * 3. Factory Advantages
 */
get_template_part( 'template-parts/pages/about/factory-advantages' );

/**
 * 4. Factory And Workshop Environment
 */
get_template_part( 'template-parts/pages/about/factory-slider' );

/**
 * 5. Certifications (Global)
 */
get_template_part( 'template-parts/global/certifications' );

/**
 * 6. Brand Trust
 */
get_template_part( 'template-parts/pages/about/brand-trust' );

/**
 * 7. Consult Form (Global)
 */
get_template_part( 'template-parts/global/consult-form' );

get_footer();
