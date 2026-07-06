<?php
/**
 * Module: Brand Trust
 *
 * Path: inc/field/pages/about/brand-trust.php
 */

add_action( 'acf/init', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_about_brand_trust',
		'title'  => 'Module: Brand Trust',
		'fields' => array(
			array(
				'key'       => 'field_brand_trust_tab_content',
				'label'     => 'Content',
				'type'      => 'tab',
				'placement' => 'top',
				'endpoint'  => 0,
			),
			array(
				'key'      => 'field_brand_trust_title',
				'label'    => 'Title',
				'name'     => 'brand_trust_title',
				'type'     => 'text',
				'required' => 0,
			),
			array(
				'key'          => 'field_brand_trust_logos',
				'label'        => 'Logos',
				'name'         => 'brand_trust_logos',
				'type'         => 'repeater',
				'instructions' => 'Optional. If empty, the template will fall back to the built-in static logo set.',
				'layout'       => 'block',
				'button_label' => 'Add Logo',
				'collapsed'    => 'field_brand_trust_logo_name',
				'sub_fields'   => array(
					array(
						'key'           => 'field_brand_trust_logo_image',
						'label'         => 'Logo Image',
						'name'          => 'logo_image',
						'type'          => 'image',
						'required'      => 1,
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'wrapper'       => array( 'width' => '60' ),
					),
					array(
						'key'      => 'field_brand_trust_logo_name',
						'label'    => 'Name',
						'name'     => 'logo_name',
						'type'     => 'text',
						'required' => 0,
						'wrapper'  => array( 'width' => '40' ),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'acf-options-about',
				),
			),
		),
		'active' => true,
	) );
} );

