<?php
/**
 * Module: Factory Slider
 *
 * Path: inc/field/pages/about/factory-slider.php
 *
 * Design: Final visual evidence section with centered title and gallery slider.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_factory_slider',
        'title'  => 'Module: Factory Slider',
        'fields' => array(
            array(
                'key'       => 'field_factory_slider_tab_content',
                'label'     => 'Content',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'      => 'field_factory_slider_title',
                'label'    => 'Title',
                'name'     => 'factory_slider_title',
                'type'     => 'text',
                'required' => 1,
            ),
            array(
                'key'           => 'field_factory_slider_images',
                'label'         => 'Factory Images',
                'name'          => 'factory_slider_images',
                'type'          => 'gallery',
                'instructions'  => 'Upload factory and workshop images for the final slider section.',
                'preview_size'  => 'medium',
                'insert'        => 'append',
                'library'       => 'all',
                'return_format' => 'id',
                'min'           => 1,
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
