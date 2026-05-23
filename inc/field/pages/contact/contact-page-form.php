<?php

add_action( 'acf/init', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_contact_page_form',
		'title'  => 'Module: Contact Page Form',
		'fields' => array(
			array(
				'key'       => 'field_contact_page_form_tab_content',
				'label'     => 'Content',
				'type'      => 'tab',
				'placement' => 'top',
				'endpoint'  => 0,
			),
			array(
				'key'           => 'field_contact_form_title',
				'label'         => 'Form Title',
				'name'          => 'contact_form_title',
				'type'          => 'text',
				'instructions'  => 'Heading above the form (left side).',
				'required'      => 0,
				'default_value' => 'Send us Your Inquiry',
				'wrapper'       => array(
					'width' => '50',
				),
			),
			array(
				'key'           => 'field_contact_form_desc',
				'label'         => 'Form Description',
				'name'          => 'contact_form_desc',
				'type'          => 'textarea',
				'instructions'  => 'Short copy under the form title.',
				'required'      => 0,
				'default_value' => 'Fill out the form below and our sales team will get back to you within 24 hours.',
				'rows'          => 2,
				'wrapper'       => array(
					'width' => '50',
				),
			),

			array(
				'key'       => 'field_contact_page_form_tab_sidebar',
				'label'     => 'Sidebar Cards',
				'type'      => 'tab',
				'placement' => 'top',
				'endpoint'  => 0,
			),

			array(
				'key'           => 'field_contact_sidebar_fast_title',
				'label'         => 'Fast Response: Title',
				'name'          => 'contact_sidebar_fast_title',
				'type'          => 'text',
				'instructions'  => 'Card title in the sidebar.',
				'required'      => 0,
				'default_value' => 'Fast Response',
				'wrapper'       => array(
					'width' => '33',
				),
			),
			array(
				'key'           => 'field_contact_sidebar_fast_highlight',
				'label'         => 'Fast Response: Highlight',
				'name'          => 'contact_sidebar_fast_highlight',
				'type'          => 'text',
				'instructions'  => 'Highlighted phrase inside the description (e.g., 24 hours).',
				'required'      => 0,
				'default_value' => '24 hours',
				'wrapper'       => array(
					'width' => '33',
				),
			),
			array(
				'key'           => 'field_contact_sidebar_fast_desc',
				'label'         => 'Fast Response: Description',
				'name'          => 'contact_sidebar_fast_desc',
				'type'          => 'textarea',
				'instructions'  => 'Use {highlight} placeholder to mark the highlighted phrase.',
				'required'      => 0,
				'default_value' => 'Our sales team responds within {highlight} to all inquiries.',
				'rows'          => 2,
				'wrapper'       => array(
					'width' => '34',
				),
			),

			array(
				'key'           => 'field_contact_sidebar_commitments_title',
				'label'         => 'Commitments: Title',
				'name'          => 'contact_sidebar_commitments_title',
				'type'          => 'text',
				'instructions'  => 'Card title in the sidebar.',
				'required'      => 0,
				'default_value' => 'Our Commitments',
				'wrapper'       => array(
					'width' => '100',
				),
			),
			array(
				'key'          => 'field_contact_sidebar_commitments_list',
				'label'        => 'Commitments: List',
				'name'         => 'contact_sidebar_commitments_list',
				'type'          => 'repeater',
				'instructions' => 'Bullet list of commitments.',
				'required'     => 0,
				'layout'       => 'block',
				'button_label' => 'Add Commitment',
				'collapsed'    => 'field_contact_sidebar_commitment_item',
				'sub_fields'   => array(
					array(
						'key'          => 'field_contact_sidebar_commitment_item',
						'label'        => 'Item',
						'name'         => 'contact_sidebar_commitment_item',
						'type'          => 'text',
						'instructions' => 'One line per item.',
						'required'     => 0,
					),
				),
			),

			array(
				'key'          => 'field_contact_sidebar_review_quote',
				'label'        => 'Review: Quote',
				'name'         => 'contact_sidebar_review_quote',
				'type'          => 'textarea',
				'instructions' => 'Short testimonial quote.',
				'required'     => 0,
				'rows'         => 3,
				'wrapper'      => array(
					'width' => '100',
				),
			),
			array(
				'key'          => 'field_contact_sidebar_review_name',
				'label'        => 'Review: Name',
				'name'         => 'contact_sidebar_review_name',
				'type'          => 'text',
				'instructions' => 'Person name shown under the quote.',
				'required'     => 0,
				'wrapper'      => array(
					'width' => '50',
				),
			),
			array(
				'key'          => 'field_contact_sidebar_review_company',
				'label'        => 'Review: Company',
				'name'         => 'contact_sidebar_review_company',
				'type'          => 'text',
				'instructions' => 'Company shown under the name.',
				'required'     => 0,
				'wrapper'      => array(
					'width' => '50',
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'acf-options-contact',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => true,
	) );
} );
