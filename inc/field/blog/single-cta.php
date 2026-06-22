<?php
/**
 * Blog Single CTA Fields
 * Location: Global Settings > Global Modules
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    acf_add_local_field_group( array(
        'key'    => 'group_blog_single_cta_settings',
        'title'  => 'Blog Single CTA',
        'fields' => array(
            array(
                'key'           => 'field_blog_single_cta_title',
                'label'         => 'CTA Title',
                'name'          => 'blog_single_cta_title',
                'type'          => 'text',
                'default_value' => 'Ready for a Technical Quote?',
            ),
            array(
                'key'           => 'field_blog_single_cta_desc',
                'label'         => 'CTA Description',
                'name'          => 'blog_single_cta_desc',
                'type'          => 'textarea',
                'rows'          => 3,
                'new_lines'     => 'wpautop',
                'default_value' => 'Connect with our material specialists for specific alloy data or high-volume pricing.',
            ),
            array(
                'key'           => 'field_blog_single_cta_button_text',
                'label'         => 'Button Text',
                'name'          => 'blog_single_cta_button_text',
                'type'          => 'text',
                'default_value' => 'Get Expert Consultation',
            ),
            array(
                'key'           => 'field_blog_single_cta_button_link',
                'label'         => 'Button Link',
                'name'          => 'blog_single_cta_button_link',
                'type'          => 'link',
                'return_format' => 'url',
                'default_value' => '/contact/',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'theme-global-modules',
                ),
            ),
        ),
        'menu_order'            => 90,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ) );
}
