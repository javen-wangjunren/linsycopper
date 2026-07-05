<?php
/**
 * Module: About Hero
 *
 * Path: inc/field/pages/about/about-hero.php
 *
 * Design: Approved About page opening module with intro copy and 5 proof items.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_hero',
        'title'  => 'Module: About Hero',
        'fields' => array(
            array(
                'key'       => 'field_about_hero_tab_content',
                'label'     => 'Content',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_about_hero_title',
                'label'        => 'Title',
                'name'         => 'about_hero_title',
                'type'         => 'text',
                'required'     => 1,
                'instructions' => 'Main H2 heading for the About hero section.',
            ),
            array(
                'key'          => 'field_about_hero_intro',
                'label'        => 'Intro Copy',
                'name'         => 'about_hero_intro',
                'type'         => 'textarea',
                'required'     => 1,
                'rows'         => 5,
                'instructions' => 'Main intro copy shown on the right side. Separate paragraphs with blank lines if needed.',
            ),
            array(
                'key'           => 'field_about_hero_band_bg_image',
                'label'         => 'Advantages Band Background',
                'name'          => 'about_hero_band_bg_image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Factory image used behind the lower deep-blue proof band.',
            ),
            array(
                'key'       => 'field_about_hero_tab_advantages',
                'label'     => 'Advantages',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_about_hero_advantages',
                'label'        => 'Advantages List',
                'name'         => 'about_hero_advantages',
                'type'         => 'repeater',
                'instructions' => 'Add 5 proof items for the lower blue band.',
                'layout'       => 'block',
                'button_label' => 'Add Advantage',
                'collapsed'    => 'field_about_hero_advantage_title',
                'sub_fields'   => array(
                    array(
                        'key'      => 'field_about_hero_advantage_title',
                        'label'    => 'Title',
                        'name'     => 'item_title',
                        'type'     => 'text',
                        'required' => 1,
                        'wrapper'  => array( 'width' => '100' ),
                    ),
                    array(
                        'key'      => 'field_about_hero_advantage_desc',
                        'label'    => 'Description',
                        'name'     => 'item_description',
                        'type'     => 'textarea',
                        'required' => 1,
                        'rows'     => 3,
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
