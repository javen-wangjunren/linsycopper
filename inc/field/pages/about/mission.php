<?php
/**
 * Module: Mission & Values
 * 
 * Path: inc/field/pages/about/mission.php
 * 
 * Design: Three-column grid for company mission, vision, and values.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_mission',
        'title'  => 'Module: Mission & Values',
        'fields' => array(
            array(
                'key'          => 'field_about_mission_list',
                'label'        => 'Mission & Values List',
                'name'         => 'mission_list',
                'type'          => 'repeater',
                'instructions' => 'Add core company principles (typically 3 items).',
                'layout'       => 'block',
                'button_label' => 'Add Principle',
                'collapsed'    => 'field_about_mission_item_title',
                'sub_fields'   => array(
                    array(
                        'key'          => 'field_about_mission_item_icon',
                        'label'        => 'Icon',
                        'name'         => 'item_icon',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'thumbnail',
                        'wrapper'      => array( 'width' => '25' ),
                    ),
                    array(
                        'key'          => 'field_about_mission_item_title',
                        'label'        => 'Title',
                        'name'         => 'item_title',
                        'type'          => 'text',
                        'required'     => 1,
                        'wrapper'      => array( 'width' => '75' ),
                    ),
                    array(
                        'key'          => 'field_about_mission_item_desc',
                        'label'        => 'Description',
                        'name'         => 'item_description',
                        'type'          => 'textarea',
                        'required'     => 1,
                        'rows'         => 3,
                    ),
                ),
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
