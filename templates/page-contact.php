<?php
/**
 * Template Name: Contact Page
 * Description: Modular contact page template.
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/pages/contact/contact-info' );
get_template_part( 'template-parts/pages/contact/contact-page-form' );
get_template_part( 'template-parts/global/faq' );

get_footer();
