<?php
/**
 * Module: Factory Advantages
 *
 * Path: inc/field/pages/about/factory-advantages.php
 *
 * Design: Eight-card operational proof grid with a closing CTA.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_factory_advantages',
        'title'  => 'Module: Factory Advantages',
        'fields' => array(
            array(
                'key'       => 'field_factory_advantages_tab_content',
                'label'     => 'Content',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_factory_advantages_title',
                'label'        => 'Title',
                'name'         => 'factory_advantages_title',
                'type'         => 'text',
                'required'     => 1,
            ),
            array(
                'key'          => 'field_factory_advantages_desc',
                'label'        => 'Description',
                'name'         => 'factory_advantages_desc',
                'type'         => 'textarea',
                'rows'         => 4,
                'instructions' => 'Short supporting text below the title.',
            ),
            array(
                'key'       => 'field_factory_advantages_tab_items',
                'label'     => 'Advantages',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_factory_advantages_items',
                'label'        => 'Advantages List',
                'name'         => 'factory_advantages_items',
                'type'         => 'repeater',
                'instructions' => 'Add 8 advantage items for the grid.',
                'layout'       => 'block',
                'button_label' => 'Add Advantage',
                'collapsed'    => 'field_factory_advantages_item_title',
                'sub_fields'   => array(
                    array(
                        'key'           => 'field_factory_advantages_item_icon_key',
                        'label'         => 'Icon Key',
                        'name'          => 'item_icon_key',
                        'type'          => 'select',
                        'required'      => 1,
                        'choices'       => array(
                            'quality'     => 'Quality Control',
                            'cut_to_size' => 'Cut To Size',
                            'stock'       => 'Stock Planning',
                            'spec'        => 'Specification Alignment',
                            'support'     => 'Project Support',
                            'delivery'    => 'Delivery Flow',
                            'supply'      => 'Long-Term Supply',
                            'improvement' => 'Process Improvement',
                        ),
                        'default_value' => 'quality',
                        'ui'            => 1,
                        'wrapper'       => array( 'width' => '30' ),
                    ),
                    array(
                        'key'      => 'field_factory_advantages_item_title',
                        'label'    => 'Title',
                        'name'     => 'item_title',
                        'type'     => 'text',
                        'required' => 1,
                        'wrapper'  => array( 'width' => '70' ),
                    ),
                    array(
                        'key'      => 'field_factory_advantages_item_desc',
                        'label'    => 'Description',
                        'name'     => 'item_description',
                        'type'     => 'textarea',
                        'required' => 1,
                        'rows'     => 3,
                    ),
                ),
            ),
            array(
                'key'       => 'field_factory_advantages_tab_cta',
                'label'     => 'CTA',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'      => 'field_factory_advantages_cta_text',
                'label'    => 'CTA Text',
                'name'     => 'factory_advantages_cta_text',
                'type'     => 'text',
                'wrapper'  => array( 'width' => '50' ),
            ),
            array(
                'key'      => 'field_factory_advantages_cta_url',
                'label'    => 'CTA URL',
                'name'     => 'factory_advantages_cta_url',
                'type'     => 'url',
                'wrapper'  => array( 'width' => '50' ),
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
