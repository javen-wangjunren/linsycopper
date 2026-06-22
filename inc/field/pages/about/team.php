<?php
/**
 * Module: Our Team
 * 
 * Path: inc/field/pages/about/team.php
 * 
 * Design: 4-column grid for leadership and technical experts.
 */

add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_about_team',
        'title'  => 'Module: Our Team',
        'fields' => array(
            // =================================================================
            // Tab: Content
            // =================================================================
            array(
                'key'   => 'field_team_tab_content',
                'label' => 'Content',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_team_title',
                'label'        => 'Title',
                'name'         => 'team_title',
                'type'          => 'text',
                'instructions' => 'Main heading for the section.',
                'wrapper'      => array( 'width' => '100' ),
            ),
            array(
                'key'          => 'field_team_desc',
                'label'        => 'Description',
                'name'         => 'team_desc',
                'type'          => 'textarea',
                'instructions' => 'Brief team overview under the title.',
                'rows'         => 2,
            ),

            // =================================================================
            // Tab: Members
            // =================================================================
            array(
                'key'   => 'field_team_tab_members',
                'label' => 'Members',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'          => 'field_team_list',
                'label'        => 'Team List',
                'name'         => 'team_list',
                'type'          => 'repeater',
                'instructions' => 'Add individual team members.',
                'layout'       => 'block',
                'button_label' => 'Add Member',
                'collapsed'    => 'field_team_member_name',
                'sub_fields'   => array(
                    array(
                        'key'          => 'field_team_member_avatar',
                        'label'        => 'Avatar',
                        'name'         => 'member_avatar',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'wrapper'      => array( 'width' => '33' ),
                    ),
                    array(
                        'key'          => 'field_team_member_name',
                        'label'        => 'Name',
                        'name'         => 'member_name',
                        'type'          => 'text',
                        'required'     => 1,
                        'wrapper'      => array( 'width' => '33' ),
                    ),
                    array(
                        'key'          => 'field_team_member_position',
                        'label'        => 'Position',
                        'name'         => 'member_position',
                        'type'          => 'text',
                        'instructions' => 'e.g. Founder & CEO',
                        'wrapper'      => array( 'width' => '34' ),
                    ),
                    array(
                        'key'          => 'field_team_member_bio',
                        'label'        => 'Short Bio',
                        'name'         => 'member_bio',
                        'type'          => 'textarea',
                        'rows'         => 2,
                    ),
                    array(
                        'key'          => 'field_team_member_linkedin',
                        'label'        => 'LinkedIn URL',
                        'name'         => 'member_linkedin',
                        'type'          => 'url',
                        'wrapper'      => array( 'width' => '50' ),
                    ),
                    array(
                        'key'          => 'field_team_member_email',
                        'label'        => 'Email Address',
                        'name'         => 'member_email',
                        'type'          => 'text',
                        'wrapper'      => array( 'width' => '50' ),
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
