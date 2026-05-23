<?php
/**
 * Home Module: Blog List (Technical Resources)
 * Path: inc/field/pages/home/blog-list.php
 * 
 * Industrial Aesthetic:
 * - Simple text inputs for section headers.
 * - Relationship field for selecting featured blog posts.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_home_blog_list',
        'title'  => 'Home Module: Blog List',
        'fields' => array(
            // =================================================================
            // Section Header
            // =================================================================
            array(
                'key'               => 'field_home_blog_list_title',
                'label'             => 'Section Title',
                'name'              => 'blog_list_title',
                'type'              => 'text',
                'instructions'      => 'e.g., Technical Resources & Insights',
                'required'          => 0,
                'wrapper'           => array(
                    'width' => '50',
                ),
                'default_value'     => 'Technical Resources & Insights',
            ),

            // =================================================================
            // Blog Selection
            // =================================================================
            array(
                'key'               => 'field_home_blog_list_posts',
                'label'             => 'Select Blog Posts',
                'name'              => 'blog_list_posts',
                'type'              => 'relationship',
                'instructions'      => 'Select the blog posts you want to display on the home page (Recommended: 3 posts).',
                'required'          => 0,
                'post_type'         => array(
                    0 => 'post',
                ),
                'taxonomy'          => '',
                'filters'           => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ),
                'elements'          => array(
                    0 => 'featured_image',
                ),
                'min'               => '',
                'max'               => 6, // Limit for layout stability
                'return_format'     => 'id',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'acf-options-home-page', // Example options page, but this will be cloned into home page group
                ),
            ),
        ),
        'active'                => true,
        'description'           => 'Featured blog posts for the homepage.',
    ) );
});
