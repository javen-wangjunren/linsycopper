<?php
/**
 * Module: Home Shape Grid Fields
 *
 * Description:
 * Configuration for the "Browse by Shape" section on the homepage.
 * Features:
 * - Section Title, Subtitle & Description
 * - Shape Selection (Taxonomy Selection: pulls hero_image and name)
 * - View All CTA Button
 *
 * @package GeneratePress_Child
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_home_shape_grid',
		'title'  => 'Home Shape Grid Module',
		'fields' => array(
			
			// Tab: Content
			array(
				'key' => 'field_home_shape_grid_tab_content',
				'label' => 'Content',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),

			// Title (Find Copper Materials by Form)
			array(
				'key' => 'field_home_shape_grid_title',
				'label' => 'Headline',
				'name' => 'home_shape_grid_title',
				'type' => 'text',
				'instructions' => 'Main section title.',
				'required' => 0,
				'default_value' => 'Find Copper Materials by Form',
				'wrapper' => array(
					'width' => '100',
				),
			),

			// Description
			array(
				'key' => 'field_home_shape_grid_desc',
				'label' => 'Description',
				'name' => 'home_shape_grid_desc',
				'type' => 'textarea',
				'instructions' => 'Short text below the headline.',
				'required' => 0,
				'default_value' => 'Every form factor available in our complete inventory. Select your preferred shape to browse available grades and specifications.',
				'rows' => 2,
				'wrapper' => array(
					'width' => '100',
				),
			),

			// Shape Selection
			array(
				'key' => 'field_home_shape_grid_items',
				'label' => 'Select Shapes',
				'name' => 'home_shape_grid_items',
				'type' => 'taxonomy',
				'instructions' => '请选择需要展示的 Shape（建议 3 或 6 个）。图片将自动调用对应 Term 的 "Hero Image" 字段，标题调用 Term 名称。',
				'taxonomy' => 'product_shape', // Ensure this matches your registered taxonomy name
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'add_term' => 0,
				'save_terms' => 0,
				'load_terms' => 0,
				'return_format' => 'object',
				'multiple' => 1,
				'wrapper' => array(
					'width' => '100',
				),
			),

			// Tab: CTA
			array(
				'key' => 'field_home_shape_grid_tab_cta',
				'label' => 'CTA',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),

			// View All Text
			array(
				'key' => 'field_home_shape_grid_cta_text',
				'label' => 'CTA Button Text',
				'name' => 'home_shape_grid_cta_text',
				'type' => 'text',
				'instructions' => 'Label for the "View All" button.',
				'required' => 0,
				'default_value' => 'View All Shapes',
				'wrapper' => array(
					'width' => '50',
				),
			),

			// View All Link
			array(
				'key' => 'field_home_shape_grid_cta_link',
				'label' => 'CTA Button Link',
				'name' => 'home_shape_grid_cta_link',
				'type' => 'url',
				'instructions' => 'URL for the "View All" button.',
				'required' => 0,
				'default_value' => '#',
				'wrapper' => array(
					'width' => '50',
				),
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post', // Dummy, will be cloned
				),
			),
		),
		'menu_order' => 10,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => false, // Must be cloned to use
	) );
} );
