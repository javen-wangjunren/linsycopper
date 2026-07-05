<?php
/**
 * Module: Founder Message
 *
 * Path: inc/field/pages/about/founder-message.php
 *
 * Design: Founder portrait plus message block used as the second trust section.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_founder_message',
        'title'  => 'Module: Founder Message',
        'fields' => array(
            array(
                'key'       => 'field_founder_message_tab_content',
                'label'     => 'Content',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_founder_message_title',
                'label'        => 'Title',
                'name'         => 'founder_message_title',
                'type'         => 'text',
                'required'     => 1,
                'instructions' => 'Main title shown above the founder quote.',
            ),
            array(
                'key'          => 'field_founder_message_body',
                'label'        => 'Message Body',
                'name'         => 'founder_message_body',
                'type'         => 'textarea',
                'required'     => 1,
                'rows'         => 6,
                'instructions' => 'Founder message body. Separate paragraphs with blank lines.',
            ),
            array(
                'key'           => 'field_founder_message_portrait',
                'label'         => 'Founder Portrait',
                'name'          => 'founder_message_portrait',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Portrait image displayed on the left side.',
                'wrapper'       => array( 'width' => '50' ),
            ),
            array(
                'key'           => 'field_founder_signature_image',
                'label'         => 'Founder Signature Image',
                'name'          => 'founder_signature_image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Transparent PNG recommended. Suggested upload size: 960 x 320 px.',
                'wrapper'       => array( 'width' => '50' ),
            ),
            array(
                'key'       => 'field_founder_name',
                'label'     => 'Founder Name',
                'name'      => 'founder_name',
                'type'      => 'text',
                'required'  => 1,
                'instructions' => 'Used as fallback when no signature image is uploaded.',
                'wrapper'   => array( 'width' => '50' ),
            ),
            array(
                'key'       => 'field_founder_role',
                'label'     => 'Founder Role',
                'name'      => 'founder_role',
                'type'      => 'text',
                'required'  => 1,
                'wrapper'   => array( 'width' => '50' ),
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
