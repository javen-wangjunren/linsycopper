<?php
/**
 * Module: Home Hero Fields
 * 
 * Description:
 * Configuration for the main homepage banner.
 * Features: Background Image, Certifications, Rich Headline, Dual CTAs, Trust Stats.
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
			array(
				'key' => 'field_home_hero_highlight_headline',
				'label' => 'Highlight Headline',
				'name' => 'hero_highlight_headline',
				'type' => 'text',
				'instructions' => 'Orange highlighted part of the headline (line 2).',
				'required' => 0,
				'wrapper' => array(
					'width' => '67',
				),
			),

			// Field: Description
			array(
				'key' => 'field_home_hero_desc',
				'label' => 'Description',
				'name' => 'home_hero_desc',
				'type' => 'textarea',
				'instructions' => 'Short intro text below the headline.',
				'required' => 0,
				'rows' => 3,
				'new_lines' => 'br',
			),

			// Field: Certifications (Repeater)
			array(
				'key' => 'field_home_hero_certs',
				'label' => 'Top Certifications',
				'name' => 'home_hero_certs',
				'type' => 'repeater',
				'instructions' => 'Small tags above the headline (e.g., ASTM B152).',
				'layout' => 'table',
				'button_label' => 'Add Cert',
				'sub_fields' => array(
					array(
						'key' => 'field_home_hero_cert_text',
						'label' => 'Cert Text',
						'name' => 'text',
						'type' => 'text',
						'placeholder' => 'ASTM B152',
					),
				),
			),

			// Field: Trust Stats (Repeater)
			array(
				'key' => 'field_home_hero_stats',
				'label' => 'Bottom Stats',
				'name' => 'home_hero_stats',
				'type' => 'repeater',
				'instructions' => 'Key metrics shown at the bottom (Max 4).',
				'layout' => 'table',
				'max' => 4,
				'button_label' => 'Add Stat',
				'sub_fields' => array(
					array(
						'key' => 'field_home_hero_stat_val',
						'label' => 'Value',
						'name' => 'value',
						'type' => 'text',
						'placeholder' => '1,000+',
						'wrapper' => array('width' => '50'),
					),
					array(
						'key' => 'field_home_hero_stat_label',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
						'placeholder' => 'Tons Ready Stock',
						'wrapper' => array('width' => '50'),
					),
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
