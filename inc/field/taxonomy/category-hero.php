<?php
/**
 * Taxonomy Fields: Category Hero
 * 
 * Logic:
 * Registers ACF fields for product taxonomies (Shape, Material, Grade).
 * Used to configure the hero banner on category archive pages.
 * 
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_taxonomy_hero',
		'title'  => 'Category Hero Settings',
		'fields' => array(
			
			// 1. Accordion: Hero Content
			array(
				'key' => 'field_tax_hero_accordion',
				'label' => 'Hero Banner Configuration',
				'name' => '',
				'type' => 'accordion',
				'instructions' => 'Configure the top banner image and text for this category.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			),

			// 2. Hero Image
			array(
				'key' => 'field_hero_image',
				'label' => 'Hero Image',
				'name' => 'hero_image',
				'type' => 'image',
				'instructions' => 'Right-side banner image. Will be forced to 4:3 aspect ratio (e.g. 800x600px).',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'id', // Integer ID for performance
				'preview_size' => 'medium',
				'library' => 'all',
			),

			// 3. Custom Title
			array(
				'key' => 'field_hero_title',
				'label' => 'Custom H1 Title',
				'name' => 'hero_title',
				'type' => 'text',
				'instructions' => 'Override the default category name. Supports HTML (e.g., Copper <span class="text-[#F4BD5D]">Sheet</span>).',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'Copper <span class="text-[#F4BD5D]">Sheet</span>',
			),

			// 4. Description
			array(
				'key' => 'field_hero_description',
				'label' => 'Description',
				'name' => 'hero_description',
				'type' => 'textarea',
				'instructions' => 'Short introductory text below the title.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '100',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'rows' => 3,
			),

			// 5. CTA Text
			array(
				'key' => 'field_hero_cta_text',
				'label' => 'CTA Text',
				'name' => 'hero_cta_text',
				'type' => 'text',
				'instructions' => 'Button label.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'Request a Quote',
			),

			// 6. CTA Link
			array(
				'key' => 'field_hero_cta_link',
				'label' => 'CTA Link',
				'name' => 'hero_cta_link',
				'type' => 'text', // Using Text instead of URL to allow anchor links (#contact-form)
				'instructions' => 'Button destination URL or Anchor ID.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#contact-form',
			),
			
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_shape',
				),
			),
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_material',
				),
			),
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_grade',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => 'Hero banner settings for product categories.',
	) );

}
