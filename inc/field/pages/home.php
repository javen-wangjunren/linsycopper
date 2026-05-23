<?php
/**
 * Page Template: Home - Field Definitions
 * 
 * Logic:
 * This is the main field controller for the Homepage.
 * It uses the 'clone' strategy to import modular field groups.
 * 
 * Layout Strategy (Industrial Precision):
 * - Uses a single "Overview" Tab as the main container.
 * - Each module is wrapped in its own Accordion for clean separation.
 * - Modules are cloned seamlessly inside their respective accordions.
 * 
 * Modules:
 * 1. Hero (inc/field/pages/home/hero.php)
 * 2. Material Grid (inc/field/pages/home/material-grid.php)
 * 3. Certifications (inc/field/pages/home/certifications.php)
 * 4. Review (inc/field/pages/home/review.php)
 * 
 * @package GeneratePress_Child
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_page_home_main',
		'title'  => 'Home Page Modules',
		'fields' => array(
			
			// =================================================================
			// Tab: Overview (Main Container)
			// =================================================================
			array(
				'key' => 'field_tab_home_overview',
				'label' => 'Overview',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),

			// =================================================================
			// Accordion: Hero Banner
			// =================================================================
			array(
				'key' => 'field_acc_home_hero_wrapper',
				'label' => 'Hero Banner',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_hero_clone',
				'label' => 'Hero Section',
				'name' => 'hero_section',
				'type' => 'clone',
				'instructions' => 'Main banner configuration.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_hero', // References inc/field/pages/home/hero.php
				),
				'display' => 'seamless', // Flat structure
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Material Grid
			// =================================================================
			array(
				'key' => 'field_acc_home_mat_wrapper',
				'label' => 'Material Grid',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_mat_clone',
				'label' => 'Material Grid',
				'name' => 'material_grid_section',
				'type' => 'clone',
				'instructions' => 'Browse by Material Type configuration.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_material_grid', // References inc/field/pages/home/material-grid.php
				),
				'display' => 'seamless', // Flat structure
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Shape Grid
			// =================================================================
			array(
				'key' => 'field_acc_home_shape_grid_wrapper',
				'label' => 'Shape Grid',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_shape_grid_clone',
				'label' => 'Shape Grid',
				'name' => 'shape_grid_section',
				'type' => 'clone',
				'instructions' => 'Browse by Shape configuration.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_shape_grid', // References inc/field/pages/home/shape-grid.php
				),
				'display' => 'seamless', // Flat structure
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			array(
				'key' => 'field_acc_home_industry_slider_wrapper',
				'label' => 'Industry Slider',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_industry_slider_clone',
				'label' => 'Industry Slider',
				'name' => 'industry_slider_section',
				'type' => 'clone',
				'instructions' => 'Industry slider content (immersive design).',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_industry_slider_immersive',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Grade Grid
			// =================================================================
			array(
				'key' => 'field_acc_home_grade_grid_wrapper',
				'label' => 'Grade Grid',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_grade_grid_clone',
				'label' => 'Grade Grid',
				'name' => 'grade_grid_section',
				'type' => 'clone',
				'instructions' => 'Best-selling grades and international equivalents.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_grade_grid',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Why Choose Us
			// =================================================================
			array(
				'key' => 'field_acc_home_why_us_wrapper',
				'label' => 'Why Choose Us',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_why_us_clone',
				'label' => 'Why Choose Us',
				'name' => 'why_us_section',
				'type' => 'clone',
				'instructions' => 'Company advantages and stats dashboard.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_why_us',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Review
			// =================================================================
			array(
				'key' => 'field_acc_home_review_wrapper',
				'label' => 'Review',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_review_clone',
				'label' => 'Review Section',
				'name' => 'review_section',
				'type' => 'clone',
				'instructions' => 'Customer testimonials configuration.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_review',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Blog List
			// =================================================================
			array(
				'key' => 'field_acc_home_blog_list_wrapper',
				'label' => 'Blog List',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_home_blog_list_clone',
				'label' => 'Blog List',
				'name' => 'blog_list_section',
				'type' => 'clone',
				'instructions' => 'Featured blog posts selection.',
				'required' => 0,
				'clone' => array(
					0 => 'group_home_blog_list',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// Close the last accordion to be safe (though not strictly required at end of group)
			array(
				'key' => 'field_acc_home_end',
				'label' => 'End',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// Future modules will be added here...

		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'front-page.php', // Matches Template Name: Home (file: front-page.php)
				),
			),
			array(
				array(
					'param' => 'page_type',
					'operator' => '==',
					'value' => 'front_page', // Matches if set as Static Homepage in Settings > Reading
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
		'description' => 'Main configuration for the Homepage.',
	) );

} );
