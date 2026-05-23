<?php
/**
 * Page Fields: Taxonomy Hub
 * ==========================================================================
 * Location: Page Template == 'Taxonomy Hub'
 * 
 * Fields:
 * 1. hub_target_taxonomy (Select)
 * 2. Hero Section (Title, Desc, CTA)
 * 3. Bottom CTA Section (Title, Desc, Link)
 * 
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

acf_add_local_field_group(array(
	'key' => 'group_page_hub',
	'title' => 'Taxonomy Hub Settings',
	'fields' => array(
		// Tab 1: Configuration
		array(
			'key' => 'field_hub_tab_config',
			'label' => 'Settings',
			'type' => 'tab',
		),
		array(
			'key' => 'field_hub_target_taxonomy',
			'label' => 'Target Taxonomy',
			'name' => 'hub_target_taxonomy',
			'type' => 'select',
			'instructions' => 'Select which taxonomy terms to display on this page.',
			'required' => 1,
			'choices' => array(
				'product_shape' => 'Product Shapes',
				'product_material' => 'Product Materials',
				'product_grade' => 'Product Grades',
			),
			'default_value' => 'product_shape',
			'return_format' => 'value',
		),

		// Tab 2: Hero
		array(
			'key' => 'field_hub_tab_hero',
			'label' => 'Hero Section',
			'type' => 'tab',
		),
		array(
			'key' => 'field_hub_hero_title',
			'label' => 'Custom H1 Title',
			'name' => 'hub_hero_title',
			'type' => 'text',
			'instructions' => 'Leave empty to use Page Title. Supports HTML.',
			'wrapper' => array( 'width' => '50' ),
		),
		array(
			'key' => 'field_hub_hero_desc',
			'label' => 'Description',
			'name' => 'hub_hero_desc',
			'type' => 'textarea',
			'rows' => 3,
			'wrapper' => array( 'width' => '100' ),
		),
		array(
			'key' => 'field_hub_hero_cta_text',
			'label' => 'Hero CTA Text',
			'name' => 'hub_hero_cta_text',
			'type' => 'text',
			'default_value' => 'Contact Us',
			'wrapper' => array( 'width' => '50' ),
		),
		array(
			'key' => 'field_hub_hero_cta_link',
			'label' => 'Hero CTA Link',
			'name' => 'hub_hero_cta_link',
			'type' => 'text', // Allow anchors
			'default_value' => '#contact',
			'wrapper' => array( 'width' => '50' ),
		),

		// Tab 3: Bottom CTA
		array(
			'key' => 'field_hub_tab_cta',
			'label' => 'Bottom CTA',
			'type' => 'tab',
		),
		array(
			'key' => 'field_hub_bottom_cta_title',
			'label' => 'CTA Title',
			'name' => 'hub_bottom_cta_title',
			'type' => 'text',
			'default_value' => "Can't Find the Shape You Need?",
			'wrapper' => array( 'width' => '100' ),
		),
		array(
			'key' => 'field_hub_bottom_cta_desc',
			'label' => 'CTA Description',
			'name' => 'hub_bottom_cta_desc',
			'type' => 'textarea',
			'default_value' => 'Our technical team can help you find the right material and shape for your specific application.',
			'rows' => 2,
		),
		array(
			'key' => 'field_hub_bottom_cta_btn_text',
			'label' => 'Button Text',
			'name' => 'hub_bottom_cta_btn_text',
			'type' => 'text',
			'default_value' => 'Contact Sales Team',
			'wrapper' => array( 'width' => '50' ),
		),
		array(
			'key' => 'field_hub_bottom_cta_btn_link',
			'label' => 'Button Link',
			'name' => 'hub_bottom_cta_btn_link',
			'type' => 'text',
			'default_value' => '/contact',
			'wrapper' => array( 'width' => '50' ),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'templates/page-hub.php',
			),
		),
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-hub.php',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content', // Hide default editor
	),
	'active' => true,
));

endif;
