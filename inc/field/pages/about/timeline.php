<?php
/**
 * Module: Company Timeline
 * 
 * Path: inc/field/pages/about/timeline.php
 * 
 * Design: Alternating vertical timeline for company milestones.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_timeline',
        'title'  => 'Module: Timeline',
        'fields' => array(
            // =================================================================
            // Tab: Content
            // =================================================================
            array(
                'key'   => 'field_timeline_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_timeline_title',
                'label'        => 'Title',
                'name'         => 'timeline_title',
                'type'          => 'text',
                'instructions' => 'Main heading for the section.',
                'wrapper'      => array( 'width' => '100' ),
            ),
            array(
                'key'          => 'field_timeline_desc',
                'label'        => 'Description',
                'name'         => 'timeline_desc',
                'type'          => 'textarea',
                'instructions' => 'Introductory text under the title.',
                'rows'         => 2,
            ),

            // =================================================================
            // Tab: Milestones
            // =================================================================
            array(
                'key'   => 'field_timeline_tab_list',
                'label' => 'Milestones',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_timeline_list',
                'label'        => 'Milestone List',
                'name'         => 'timeline_list',
                'type'          => 'repeater',
                'instructions' => 'Add company milestones in chronological order.',
                'layout'       => 'block',
                'button_label' => 'Add Milestone',
                'collapsed'    => 'field_timeline_item_year',
                'sub_fields'   => array(
                    array(
                        'key'          => 'field_timeline_item_year',
                        'label'        => 'Year',
                        'name'         => 'year',
                        'type'          => 'text',
                        'required'     => 1,
                        'wrapper'      => array( 'width' => '25' ),
                    ),
                    array(
                        'key'          => 'field_timeline_item_title',
                        'label'        => 'Title',
                        'name'         => 'title',
                        'type'          => 'text',
                        'required'     => 1,
                        'wrapper'      => array( 'width' => '75' ),
                    ),
                    array(
                        'key'          => 'field_timeline_item_image',
                        'label'        => 'Milestone Image',
                        'name'         => 'image',
                        'type'          => 'image',
                        'instructions' => 'Visual reference for this event (Historical photo, facility build, etc.).',
                        'required' => 0,
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key'          => 'field_timeline_item_mobile_image',
                        'label'        => 'Mobile Image (Optional)',
                        'name'         => 'mobile_image',
                        'type'          => 'image',
                        'instructions' => 'Specific crop for mobile devices.',
                        'required' => 0,
                        'return_format' => 'id',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key'          => 'field_timeline_item_desc',
                        'label'        => 'Description',
                        'name'         => 'description',
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
