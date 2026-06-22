<?php
/**
 * Module: Certifications
 * Path: inc/field/global/certifications.php
 * 
 * Industrial Precision: 
 * - 3:4 Aspect Ratio enforced via instructions.
 * - Flat data structure for seamless rendering.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_home_certifications',
        'title'  => 'Module: Certifications',
        'fields' => array(
            // =================================================================
            // Content Section
            // =================================================================
            array(
                'key' => 'field_cert_title',
                'label' => 'Main Title',
                'name' => 'cert_title',
                'type' => 'text',
                'instructions' => 'Section main heading',
                'default_value' => 'Certifications & Standards',
                'wrapper' => array('width' => '67'),
            ),
            array(
                'key' => 'field_cert_desc',
                'label' => 'Description',
                'name' => 'cert_desc',
                'type' => 'textarea',
                'instructions' => 'Brief introduction about compliance and quality.',
                'rows' => 2,
            ),

            // =================================================================
            // Certificates List (Repeater)
            // =================================================================
            array(
                'key' => 'field_cert_list',
                'label' => 'Certificates',
                'name' => 'cert_list',
                'type' => 'repeater',
                'instructions' => 'Add certificates (Recommended: 3-6 items).',
                'layout' => 'block',
                'button_label' => 'Add Certificate',
                'collapsed' => 'field_cert_image_item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_cert_image_item',
                        'label' => 'Certificate Image',
                        'name' => 'cert_image',
                        'type' => 'image',
                        'instructions' => 'Upload scan (3:4 ratio, e.g., 2380x3360px).',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'wrapper' => array('width' => '100'),
                    ),
                ),
            ),
        ),
        'location' => array(
            // Dummy location: this group is intended to be cloned into an Options Page wrapper.
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'active' => false,
        'description' => 'Source definition for Certifications module (cloned into Global Settings).',
    ) );
});
