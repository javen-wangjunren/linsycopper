<?php
/**
 * Module: Review (Testimonials)
 * 
 * Path: inc/field/pages/home/review.php
 * 
 * Design: Industrial B2B style with author profile and quote.
 * UX: Uses Tabs for functional separation and block-layout Repeater for readability.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_home_review',
        'title'  => 'Module: Review',
        'fields' => array(
            // =================================================================
            // Tab: Content
            // =================================================================
            array(
                'key'   => 'field_review_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_review_title',
                'label'        => 'Title',
                'name'         => 'review_title',
                'type'          => 'text',
                'instructions' => 'Main heading for the section.',
                'wrapper'      => array( 'width' => '100' ),
            ),
            array(
                'key'          => 'field_review_desc',
                'label'        => 'Description',
                'name'         => 'review_desc',
                'type'          => 'textarea',
                'instructions' => 'Introductory text under the title.',
                'rows'         => 2,
            ),

            // =================================================================
            // Tab: Reviews
            // =================================================================
            array(
                'key'   => 'field_review_tab_list',
                'label' => 'Reviews',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_review_list',
                'label'        => 'Review List',
                'name'         => 'review_list',
                'type'          => 'repeater',
                'instructions' => 'Add individual customer reviews.',
                'layout'       => 'block', // Better readability for long quotes
                'button_label' => 'Add Review',
                'collapsed'    => 'field_review_author_name', // Keep admin clean
                'sub_fields'   => array(
                    array(
                        'key'          => 'field_review_content',
                        'label'        => 'Quote',
                        'name'         => 'review_content',
                        'type'          => 'textarea',
                        'instructions' => 'The customer testimonial text.',
                        'required'     => 0,
                        'rows'         => 3,
                    ),
                    array(
                        'key'          => 'field_review_author_image',
                        'label'        => 'Author Image',
                        'name'         => 'author_image',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'wrapper'      => array( 'width' => '25' ),
                    ),
                    array(
                        'key'          => 'field_review_author_name',
                        'label'        => 'Author Name',
                        'name'         => 'author_name',
                        'type'          => 'text',
                        'wrapper'      => array( 'width' => '37.5' ),
                    ),
                    array(
                        'key'          => 'field_review_author_role',
                        'label'        => 'Author Role',
                        'name'         => 'author_role',
                        'type'          => 'text',
                        'instructions' => 'e.g. Chief Procurement Officer',
                        'wrapper'      => array( 'width' => '37.5' ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'acf-options-home', // Default for modules
                ),
            ),
        ),
        'active' => true,
    ) );
} );
