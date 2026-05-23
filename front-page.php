<?php
/**
 * Template Name: Home
 * Description: The homepage template.
 * 
 * Logic:
 * 1. Loads 'Home Hero' (template-parts/pages/home/hero.php).
 * 2. Loads 'Material Grid' (template-parts/pages/home/material-grid.php).
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// 1. Home Hero
get_template_part( 'template-parts/pages/home/hero' );

// 2. Material Grid (Browse by Type)
get_template_part( 'template-parts/pages/home/material-grid' );

// 3. Industry Slider
get_template_part( 'template-parts/pages/home/industry-slider' );

// 4. Shape Grid (Browse by Form)
get_template_part( 'template-parts/pages/home/shape-grid' );

// 6. Grade Grid (Popular Materials)
get_template_part( 'template-parts/pages/home/grade-grid' );

// 7. Why Choose Us (Advantages)
get_template_part( 'template-parts/pages/home/why-choose-us' );

// 8. Certifications (Global)
get_template_part( 'template-parts/global/certifications' );

// 9. Review (Testimonials)
get_template_part( 'template-parts/pages/home/review' );

// 10. Blog List (Technical Resources)
get_template_part( 'template-parts/pages/home/blog-list' );

get_footer();
