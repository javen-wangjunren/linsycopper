<?php
/**
 * Page Template: About - Field Definitions
 * 
 * Logic:
 * Uses the 'clone' strategy to import modular field groups for the About page.
 * 
 * Modules:
 * 1. Mission & Values (inc/field/pages/about/mission.php)
 * 2. Timeline (inc/field/pages/about/timeline.php)
 * 3. Team (inc/field/pages/about/team.php)
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
			// Tab: Overview
			// =================================================================
			array(
				'key' => 'field_tab_about_overview',
				'label' => 'Overview',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),

			// =================================================================
			// Accordion: Mission & Values
			// =================================================================
			array(
				'key' => 'field_acc_about_mission_wrapper',
				'label' => 'Mission & Values',
				'type' => 'accordion',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_mission_clone',
				'label' => 'Mission Section',
				'name' => 'mission_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_mission',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Timeline
			// =================================================================
			array(
				'key' => 'field_acc_about_timeline_wrapper',
				'label' => 'Company Timeline',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_timeline_clone',
				'label' => 'Timeline Section',
				'name' => 'timeline_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_timeline',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Accordion: Team
			// =================================================================
			array(
				'key' => 'field_acc_about_team_wrapper',
				'label' => 'Our Team',
				'type' => 'accordion',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_team_clone',
				'label' => 'Team Section',
				'name' => 'team_section',
				'type' => 'clone',
				'clone' => array(
					0 => 'group_about_team',
				),
				'display' => 'seamless',
				'layout' => 'block',
				'prefix_label' => 0,
				'prefix_name' => 0,
			),

			// =================================================================
			// Tab: Consult Form
			// =================================================================
			array(
				'key' => 'field_tab_about_consult',
				'label' => 'Consult Form',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_about_consult_form_bg',
				'label' => 'Form Section Background',
				'name' => 'consult_form_bg',
				'type' => 'image',
				'instructions' => 'Upload a high-res image (e.g., copper texture) to replace the default blue stripes.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
			),

			// Close accordion
			array(
				'key' => 'field_acc_about_end',
				'label' => 'End',
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
