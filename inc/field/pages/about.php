<?php
/**
 * Page Template: About - Field Definitions
 * 
 * Logic:
 * Uses the clone strategy to import modular field groups for the About page.
 * Backend UX rule: keep the editor flat and sequential. Do not use empty tabs
 * or nested tab groups that make unrelated fields appear inside another module.
 * 
 * Modules:
 * 1. About Hero (inc/field/pages/about/about-hero.php)
 * 2. Founder Message (inc/field/pages/about/founder-message.php)
 * 3. Factory Advantages (inc/field/pages/about/factory-advantages.php)
 * 4. Factory Slider (inc/field/pages/about/factory-slider.php)
 * 5. Brand Trust (inc/field/pages/about/brand-trust.php)
 * 
 * @package GeneratePress_Child
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_page_about_main',
		'title'  => 'About Page Modules',
		'fields' => array(
			// =================================================================
			// Accordion: About Hero
			// =================================================================
			array(
				'key' => 'field_acc_about_hero_wrapper',
				'label' => 'About Hero',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_hero_clone',
				'label' => 'About Hero Fields',
				'name' => 'about_hero_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_hero',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Founder Message
			// =================================================================
			array(
				'key' => 'field_acc_about_founder_message_wrapper',
				'label' => 'Founder Message',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_founder_message_clone',
				'label' => 'Founder Message Fields',
				'name' => 'founder_message_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_founder_message',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Factory Advantages
			// =================================================================
			array(
				'key' => 'field_acc_about_factory_advantages_wrapper',
				'label' => 'Factory Advantages',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_factory_advantages_clone',
				'label' => 'Factory Advantages Fields',
				'name' => 'factory_advantages_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_factory_advantages',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Factory Slider
			// =================================================================
			array(
				'key' => 'field_acc_about_factory_slider_wrapper',
				'label' => 'Factory And Workshop Environment',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_factory_slider_clone',
				'label' => 'Factory Slider Fields',
				'name' => 'factory_slider_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_factory_slider',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Brand Trust
			// =================================================================
			array(
				'key' => 'field_acc_about_brand_trust_wrapper',
				'label' => 'Brand Trust',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_brand_trust_clone',
				'label' => 'Brand Trust Fields',
				'name' => 'brand_trust_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_brand_trust',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			array(
				'key' => 'field_acc_about_brand_trust_end',
				'label' => 'End Brand Trust',
				'type' => 'accordion',
				'endpoint' => 1,
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/page-about.php',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	) );

} );
