<?php
/**
 * Single Product CPT - Field Definitions
 * 
 * Logic:
 * This file serves as the main controller for all ACF fields attached to the 'product' CPT.
 * Instead of defining fields directly here, it uses ACF's 'clone' feature to pull in
 * modular field groups (like Product Hero, Specs, Applications, etc.).
 * 
 * Architecture:
 * - Module-based: Each section (Hero, Tabs, etc.) is a separate Field Group.
 * - Unified Interface: This group collects them all into one seamless edit screen.
 * 
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_cpt_product_main',
		'title'  => 'Product Hero',
		'fields' => array(
			
			// 1. Hero Section (Cloned from Module)
			array(
				'key' => 'field_cpt_product_hero_clone',
				'label' => 'Hero Section',
				'name' => 'hero_section',
				'type' => 'clone',
				'instructions' => 'Settings for the top hero section (Image, Specs, CTA).',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'clone' => array(
					0 => 'group_product_hero', // References the key in inc/field/module/product-hero.php
				),
				'display' => 'seamless', // Integrate fields directly without a wrapper group
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0, // Keep original field names (e.g., product_hero_gallery)
			),

			// 2. Product Description (Cloned from Module)
			array(
				'key' => 'field_cpt_product_description_clone',
				'label' => 'Product Description',
				'name' => 'description_section',
				'type' => 'clone',
				'instructions' => 'Content for Overview, Features, and Size Matrix.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'clone' => array(
					0 => 'group_product_description', // References inc/field/module/product-description.php
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// 3. Product Applications (Cloned from Module)
			array(
				'key' => 'field_cpt_product_applications_clone',
				'label' => 'Product Applications',
				'name' => 'applications_section',
				'type' => 'clone',
				'instructions' => 'Content for Applications slider.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'clone' => array(
					0 => 'group_product_applications', // References inc/field/module/product-applications.php
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// 4. Product Specifications (Cloned from Module)
			array(
				'key' => 'field_cpt_product_specifications_clone',
				'label' => 'Product Specifications',
				'name' => 'specifications_section',
				'type' => 'clone',
				'instructions' => 'Content for Technical Specs tables.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'clone' => array(
					0 => 'group_product_specifications', // References inc/field/module/product-specifications.php
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// 5. Product FAQ (Cloned from Global Module)
			array(
				'key' => 'field_acc_product_faq_wrapper',
				'label' => 'FAQ',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_cpt_product_faq_clone',
				'label' => 'Product FAQ',
				'name' => 'faq_section',
				'type' => 'clone',
				'instructions' => 'Frequently Asked Questions for this product. Enables FAQ schema for SEO.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'clone' => array(
					0 => 'group_global_faq', // References inc/field/global/faq.php
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),
			array(
				'key' => 'field_acc_product_faq_end',
				'label' => 'End',
				'type' => 'accordion',
				'endpoint' => 1,
			),

			// Future modules can be cloned here...
			// e.g., Specs, Applications, Downloads
			
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal', // Standard meta box position
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			// Optional: Hide standard WP features if ACF replaces them completely
			// 0 => 'the_content',
		),
		'active' => true,
		'description' => 'Main configuration for Product pages.',
	) );

}
