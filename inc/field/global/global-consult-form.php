<?php
/**
 * Global Consult Form Fields (Options Page)
 *
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group(
		array(
			'key'    => 'group_global_consult_form',
			'title'  => 'Global Consult Form',
			'fields' => array(
				array(
					'key'           => 'field_global_consult_form_bg',
					'label'         => 'Form Section Background',
					'name'          => 'consult_form_bg',
					'type'          => 'image',
					'instructions'  => 'Upload a high-res image (e.g., copper texture) to replace the default blue stripes for all consult form sections.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
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
		)
	);
}
