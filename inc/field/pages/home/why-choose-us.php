<?php
/**
 * ACF Field Definition: Why Choose Us (Industrial Dashboard)
 * Path: inc/field/pages/home/why-choose-us.php
 */

if ( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_home_why_us',
        'title' => 'Module: Why Choose Us',
        'fields' => array(
            array(
                'key' => 'field_why_us_tab_content',
                'label' => 'Content',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_why_title',
                'label' => 'Title',
                'name' => 'why_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Why Choose Linsy Copper?',
                'wrapper' => array('width' => '100'),
            ),
            array(
                'key' => 'field_why_desc',
                'label' => 'Description',
                'name' => 'why_desc',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'With over two decades of expertise in copper and alloy distribution, we deliver precision-cut materials with full traceability and unmatched technical support.',
            ),
            array(
                'key' => 'field_why_stats',
                'label' => 'Stats Dashboard',
                'name' => 'why_stats',
                'type' => 'repeater',
                'instructions' => 'Add up to 4 key performance metrics.',
                'max' => 4,
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'field_stat_value',
                        'label' => 'Value',
                        'name' => 'stat_value',
                        'type' => 'text',
                        'placeholder' => 'e.g. 25+',
                    ),
                    array(
                        'key' => 'field_stat_label',
                        'label' => 'Label',
                        'name' => 'stat_label',
                        'type' => 'text',
                        'placeholder' => 'e.g. Years Experience',
                    ),
                ),
            ),
            array(
                'key' => 'field_why_main_image',
                'label' => 'Main Image',
                'name' => 'why_main_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'instructions' => 'Industrial/factory scene suggested.',
            ),
            array(
                'key' => 'field_why_reasons',
                'label' => 'Advantage Cards',
                'name' => 'why_reasons',
                'type' => 'repeater',
                'instructions' => 'Add 3 core reasons why customers choose us.',
                'min' => 3,
                'max' => 3,
                'layout' => 'block',
                'collapsed' => 'field_reason_title',
                'sub_fields' => array(
                    array(
                        'key' => 'field_reason_icon',
                        'label' => 'Index/Icon',
                        'name' => 'reason_icon',
                        'type' => 'text',
                        'default_value' => '01',
                        'wrapper' => array('width' => '20'),
                    ),
                    array(
                        'key' => 'field_reason_title',
                        'label' => 'Title',
                        'name' => 'reason_title',
                        'type' => 'text',
                        'wrapper' => array('width' => '80'),
                    ),
                    array(
                        'key' => 'field_reason_desc',
                        'label' => 'Description',
                        'name' => 'reason_desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-home',
                ),
            ),
        ),
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
