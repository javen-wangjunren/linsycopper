<?php
/**
 * Global Module: Available Sizes
 *
 * Location: Global Settings > Global Modules
 *
 * @package GeneratePress_Child
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_global_available_sizes',
		'title'  => 'Module: Available Sizes',
		'fields' => array(
			array(
				'key'           => 'field_global_available_sizes_title',
				'label'         => 'Section Title',
				'name'          => 'global_available_sizes_title',
				'type'          => 'text',
				'default_value' => 'Available Sizes',
				'instructions'  => 'Section heading displayed above the size table.',
			),
			array(
				'key'           => 'field_global_available_sizes_matrix',
				'label'         => 'Size Data Matrix',
				'name'          => 'global_available_sizes_matrix',
				'type'          => 'repeater',
				'layout'        => 'table',
				'button_label'  => 'Add Row',
				'instructions'  => 'IMPORTANT: The FIRST ROW will be used as the Table Header (THEAD). Subsequent rows are data (TBODY).',
				'sub_fields'    => array(
					array(
						'key'     => 'field_global_available_sizes_col_1',
						'label'   => 'Col 1',
						'name'    => 'col_1',
						'type'    => 'text',
						'wrapper' => array(
							'width' => '20',
						),
					),
					array(
						'key'     => 'field_global_available_sizes_col_2',
						'label'   => 'Col 2',
						'name'    => 'col_2',
						'type'    => 'text',
						'wrapper' => array(
							'width' => '20',
						),
					),
					array(
						'key'     => 'field_global_available_sizes_col_3',
						'label'   => 'Col 3',
						'name'    => 'col_3',
						'type'    => 'text',
						'wrapper' => array(
							'width' => '20',
						),
					),
					array(
						'key'     => 'field_global_available_sizes_col_4',
						'label'   => 'Col 4',
						'name'    => 'col_4',
						'type'    => 'text',
						'wrapper' => array(
							'width' => '20',
						),
					),
					array(
						'key'     => 'field_global_available_sizes_col_5',
						'label'   => 'Col 5',
						'name'    => 'col_5',
						'type'    => 'text',
						'wrapper' => array(
							'width' => '20',
						),
					),
				),
			),
			array(
				'key'           => 'field_global_available_sizes_note',
				'label'         => 'Table Note',
				'name'          => 'global_available_sizes_note',
				'type'          => 'textarea',
				'rows'          => 2,
				'new_lines'     => 'br',
				'default_value' => '* Custom sizes available upon request. Contact our sales team for special requirements.',
				'instructions'  => 'Optional note displayed below the size table.',
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
}
