<?php
/**
 * Module: Home Material Grid Fields
 *
 * Description:
 * Configuration for the "Browse by Material Type" section on the homepage.
 * Features:
 * - Section Title & Description
 * - Material Selection (Taxonomy Relationship)
 *
 * @package GeneratePress_Child
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_home_material_grid',
		'title'  => 'Home Material Grid Module',
		'fields' => array(
			
			// Field: Headline
			array(
				'key' => 'field_home_mat_title',
				'label' => 'Headline',
				'name' => 'home_mat_title',
				'type' => 'text',
				'instructions' => 'Main section title.',
				'required' => 0,
				'default_value' => 'Browse by Material Type',
				'wrapper' => array(
					'width' => '50',
				),
			),

			// Field: Material Taxonomy Selection
			array(
				'key' => 'field_home_mat_items',
				'label' => 'Select Materials',
				'name' => 'home_mat_items',
				'type' => 'taxonomy',
				'instructions' => '请选择 3 个 Material（将显示 3 张卡片）。图片将从对应 Term 的 “Hero Image” 字段拉取。',
				'taxonomy' => 'product_material',
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'add_term' => 0,
				'save_terms' => 0,
				'load_terms' => 0,
				'return_format' => 'object',
				'multiple' => 1,
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
		'menu_order' => 1, // After Hero
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => false, // Disabled directly, must be cloned
	) );

	add_filter( 'acf/validate_value/key=field_home_mat_items', function ( $valid, $value ) {
		if ( $valid !== true ) {
			return $valid;
		}

		if ( is_array( $value ) ) {
			$count = count( array_filter( $value ) );
		} elseif ( empty( $value ) ) {
			$count = 0;
		} else {
			$count = 1;
		}

		if ( $count !== 0 && $count !== 3 ) {
			return '为保证布局一致：不选则留空；如需展示请仅选择 3 个 Material。';
		}

		return true;
	}, 10, 2 );
} );
