<?php
/**
 * User Profile: Blog Author Extra Fields
 * Path: inc/field/blog/author.php
 * 
 * Industrial Precision: 
 * - Semantic naming for user metadata.
 * - Image ID return format.
 * - Structured layout for user profile edit screen.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'                   => 'group_user_blog_author',
        'title'                 => 'User Profile: Blog Author Info',
        'fields'                => array(
            // =================================================================
            // Author Identity
            // =================================================================
            array(
                'key'               => 'field_user_author_image',
                'label'             => 'Author Photo',
                'name'              => 'user_author_image',
                'type'              => 'image',
                'instructions'      => 'Upload author photo (Recommended: Square 400x400px).',
                'required'          => 0,
                'wrapper'           => array(
                    'width' => '33',
                ),
                'return_format'      => 'id',
                'preview_size'       => 'thumbnail',
                'library'            => 'all',
            ),
            array(
                'key'               => 'field_user_author_job',
                'label'             => 'Job Title / Position',
                'name'              => 'user_author_job',
                'type'              => 'text',
                'instructions'      => 'e.g., Technical Specialist, Lead Engineer',
                'required'          => 0,
                'wrapper'           => array(
                    'width' => '33',
                ),
            ),
            array(
                'key'               => 'field_user_author_linkedin',
                'label'             => 'LinkedIn Profile',
                'name'              => 'user_author_linkedin',
                'type'              => 'url',
                'instructions'      => 'Full LinkedIn URL for the author card.',
                'required'          => 0,
                'wrapper'           => array(
                    'width' => '34',
                ),
                'placeholder'       => 'https://linkedin.com/in/...',
            ),

            // =================================================================
            // Author Bio
            // =================================================================
            array(
                'key'               => 'field_user_author_bio',
                'label'             => 'Short Bio',
                'name'              => 'user_author_bio',
                'type'              => 'textarea',
                'instructions'      => 'Brief professional bio (max 2-3 sentences).',
                'required'          => 0,
                'rows'              => 3,
                'new_lines'         => 'wpautop', // Preserve line breaks for rendering
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'user_form',
                    'operator' => '==',
                    'value'    => 'all',
                ),
            ),
        ),
        'menu_order'            => 10,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
        'description'           => 'Enhanced author metadata for blog posts.',
    ) );
});
