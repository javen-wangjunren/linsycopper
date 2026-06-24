<?php
/**
 * Module: Home Hero Fields
 * 
 * Description:
 * Configuration for the main homepage banner.
 * Features: Background Image, Rich Headline, Dual CTAs.
 * 
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_home_hero',
		'title'  => 'Home Hero Module',
		'fields' => array(
			
			// Field: Background Image
			array(
				'key' => 'field_home_hero_bg',
				'label' => 'Background Image',
				'name' => 'home_hero_bg',
				'type' => 'image',
				'instructions' => 'High-res warehouse or copper texture image (1920x1080px+).',
				'required' => 0,
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
				'wrapper' => array(
					'width' => '33',
				),
			),

			array(
				'key' => 'field_home_hero_headline',
				'label' => 'Headline',
				'name' => 'hero_headline',
				'type' => 'text',
				'instructions' => 'White part of the main headline (line 1).',
				'required' => 0,
				'wrapper' => array(
					'width' => '67',
				),
			),

			// Field: Primary CTA
			array(
				'key' => 'field_home_hero_cta_primary',
				'label' => 'Primary Button (Orange)',
				'name' => 'home_hero_cta_primary',
				'type' => 'link',
				'return_format' => 'array',
				'wrapper' => array('width' => '50'),
			),

			// Field: Secondary CTA
			array(
				'key' => 'field_home_hero_cta_secondary',
				'label' => 'Secondary Button (Outline)',
				'name' => 'home_hero_cta_secondary',
				'type' => 'link',
				'return_format' => 'array',
				'wrapper' => array('width' => '50'),
			),

		),
		'location' => array(
			// Logic: Not active by default, intended to be cloned
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post', // Dummy location, will be hidden
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => false, // Disabled directly, must be cloned
		'description' => 'Source definition for Home Hero module.',
	) );

}
