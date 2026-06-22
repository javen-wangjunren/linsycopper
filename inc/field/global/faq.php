<?php
/**
 * Module: FAQ
 *
 * Path: inc/field/global/faq.php
 *
 * Design: Accordion FAQ list with section header.
 */

add_action( 'acf/init', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_global_faq',
		'title'  => 'Module: FAQ',
		'fields' => array(
			array(
				'key'          => 'field_contact_faq_title',
				'label'        => 'Title',
				'name'         => 'contact_faq_title',
				'type'         => 'text',
				'instructions' => 'Section heading (e.g., Frequently Asked Questions).',
				'required'     => 0,
				'default_value' => 'Frequently Asked Questions',
				'wrapper'      => array(
					'width' => '50',
				),
			),
			array(
				'key'          => 'field_contact_faq_desc',
				'label'        => 'Description',
				'name'         => 'contact_faq_desc',
				'type'         => 'textarea',
				'instructions' => 'Short intro under the title.',
				'required'     => 0,
				'default_value' => 'Find answers to common questions about our products, services, and ordering process',
				'rows'         => 2,
				'wrapper'      => array(
					'width' => '50',
				),
			),
			array(
				'key'          => 'field_contact_faq_list',
				'label'        => 'FAQ List',
				'name'         => 'contact_faq_list',
				'type'         => 'repeater',
				'instructions' => 'Add Q&A items.',
				'required'     => 0,
				'layout'       => 'block',
				'button_label' => 'Add FAQ',
				'collapsed'    => 'field_contact_faq_question',
				'sub_fields'   => array(
					array(
						'key'          => 'field_contact_faq_question',
						'label'        => 'Question',
						'name'         => 'contact_faq_question',
						'type'         => 'text',
						'instructions' => 'One question per item.',
						'required'     => 0,
						'wrapper'      => array(
							'width' => '50',
						),
					),
					array(
						'key'          => 'field_contact_faq_answer',
						'label'        => 'Answer',
						'name'         => 'contact_faq_answer',
						'type'         => 'textarea',
						'instructions' => 'Plain text answer.',
						'required'     => 0,
						'rows'         => 3,
						'wrapper'      => array(
							'width' => '50',
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => false,
	) );
} );
