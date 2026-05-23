<?php
/**
 * Blog Archive: Field Definitions
 * Path: inc/field/pages/blog-archive.php
 * 
 * Logic:
 * This group provides custom content for the main Blog Archive (Posts Page).
 * It allows editing the header title, description, and background image.
 */

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_page_blog_archive',
		'title'  => 'Page: Blog Archive (Header)',
		'fields' => array(
			// =================================================================
			// Header Content
			// =================================================================
			array(
				'key' => 'field_blog_archive_subtitle',
				'label' => 'Subtitle',
				'name' => 'archive_subtitle',
				'type' => 'text',
				'instructions' => 'Small label above the heading (e.g., Insights & News).',
				'default_value' => 'Insights & News',
				'wrapper' => array( 'width' => '33' ),
			),
			array(
				'key' => 'field_blog_archive_title',
				'label' => 'Main Title',
				'name' => 'archive_title',
				'type' => 'text',
				'instructions' => 'The main heading of the blog page.',
				'default_value' => 'Material Science & Industry Updates',
				'wrapper' => array( 'width' => '67' ),
			),
			array(
				'key' => 'field_blog_archive_description',
				'label' => 'Description',
				'name' => 'archive_description',
				'type' => 'textarea',
				'instructions' => 'Brief overview of what the blog covers.',
				'default_value' => 'Explore the latest technical guides, material breakthroughs, and industry case studies from our specialists.',
				'rows' => 2,
			),
			array(
				'key' => 'field_blog_archive_bg',
				'label' => 'Header Background Image',
				'name' => 'archive_bg_image',
				'type' => 'image',
				'instructions' => 'Optional background image for the blog header (1920x600px recommended).',
				'return_format' => 'id',
				'preview_size' => 'medium',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_type',
					'operator' => '==',
					'value' => 'posts_page',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	) );

} );
