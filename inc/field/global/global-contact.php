<?php
/**
 * Global Contact Section Fields (Options Page)
 * ==========================================================================
 * Location: Options Page (Global Options) -> Tab: Contact Section
 * 
 * Fields:
 * 1. global_contact_title (Text)
 * 2. global_contact_desc (Textarea)
 * 3. global_contact_bg (Image ID)
 * 4. global_contact_strengths (Repeater)
 *    - strength_value (Text)
 *    - strength_label (Text)
 * 
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

acf_add_local_field_group(array(
	'key' => 'group_global_contact_section',
	'title' => 'Global Contact Section',
	'fields' => array(
		array(
			'key' => 'field_global_contact_title',
			'label' => 'Section Title',
			'name' => 'global_contact_title',
			'type' => 'text',
			'instructions' => 'e.g., Consult Our Experts',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Consult Our Experts',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_global_contact_bg',
			'label' => 'Background Image',
			'name' => 'global_contact_bg',
			'type' => 'image',
			'instructions' => 'Background image with blue overlay applied via CSS.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_global_contact_desc',
			'label' => 'Description',
			'name' => 'global_contact_desc',
			'type' => 'textarea', // Changed to Wysiwyg for link support if needed, but Textarea requested. Sticking to Textarea.
			'instructions' => 'Intro text below title. HTML allowed for links.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Give us a call at <a href="tel:3462305191" class="font-bold text-white underline transition hover:text-[#F97C30]">346.230.5191</a> or leave us a message below.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 3,
			'new_lines' => '', // No auto-br to allow manual HTML control
		),
		array(
			'key' => 'field_global_contact_strengths',
			'label' => 'Key Strengths (Data Points)',
			'name' => 'global_contact_strengths',
			'type' => 'repeater',
			'instructions' => '4 data points displayed at bottom left.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_strength_value',
			'min' => 4,
			'max' => 4,
			'layout' => 'table',
			'button_label' => 'Add Strength',
			'sub_fields' => array(
				array(
					'key' => 'field_strength_value',
					'label' => 'Value',
					'name' => 'strength_value',
					'type' => 'text',
					'instructions' => 'e.g. 1,000+ TONS',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_strength_label',
					'label' => 'Label',
					'name' => 'strength_label',
					'type' => 'text',
					'instructions' => 'e.g. Ready Stock',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 10,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => false,
	'description' => 'Global settings for the Contact / Consult form section.',
));

endif;
