<?php
/**
 * Module: Contact Info Cards
 * 
 * Path: inc/field/pages/contact/contact-info.php
 * 
 * Design: 4-column grid of contact method cards (Phone, Email, Address, Hours).
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_contact_info',
        'title'  => 'Module: Contact Info',
        'fields' => array(
            // =================================================================
            // Tab: Content
            // =================================================================
            array(
                'key'   => 'field_contact_info_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_contact_info_title',
                'label'        => 'Section Title',
                'name'         => 'contact_info_title',
                'type'          => 'text',
                'instructions' => 'Main heading (e.g., Get in Touch).',
                'default_value' => 'Get in Touch',
                'wrapper'      => array( 'width' => '50' ),
            ),
            array(
                'key'          => 'field_contact_info_desc',
                'label'        => 'Description',
                'name'         => 'contact_info_desc',
                'type'          => 'textarea',
                'instructions' => 'Intro text below the title.',
                'default_value' => 'Multiple ways to reach our sales and support team',
                'rows'         => 2,
                'wrapper'      => array( 'width' => '50' ),
            ),

            // =================================================================
            // Tab: Methods
            // =================================================================
            array(
                'key'   => 'field_contact_info_tab_methods',
                'label' => 'Contact Methods',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_contact_methods',
                'label'        => 'Methods List',
                'name'         => 'contact_methods',
                'type'          => 'repeater',
                'instructions' => 'Add contact cards (Phone, Email, etc.).',
                'layout'       => 'block',
                'button_label' => 'Add Method',
                'collapsed'    => 'field_contact_method_label',
                'sub_fields'   => array(
                    array(
                        'key'          => 'field_contact_method_label',
                        'label'        => 'Label',
                        'name'         => 'label',
                        'type'          => 'text',
                        'instructions' => 'e.g., Phone, Email, Address.',
                        'required'     => 1,
                        'wrapper'      => array( 'width' => '30' ),
                    ),
                    array(
                        'key'          => 'field_contact_method_value',
                        'label'        => 'Display Value',
                        'name'         => 'value',
                        'type'          => 'text',
                        'instructions' => 'The text shown on the card.',
                        'required'     => 1,
                        'wrapper'      => array( 'width' => '70' ),
                    ),
                    array(
                        'key'          => 'field_contact_method_link',
                        'label'        => 'Action Link (Optional)',
                        'name'         => 'link',
                        'type'          => 'text',
                        'instructions' => 'e.g., tel:+15551234567 or mailto:sales@linsycopper.com.',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/__never__.php',
                ),
            ),
        ),
        'active' => true,
    ) );
} );
