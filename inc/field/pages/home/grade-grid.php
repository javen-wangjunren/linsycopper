<?php
/**
 * ACF Field Definition: Grade Grid (Popular Materials)
 * Path: inc/field/pages/home/grade-grid.php
 */

if ( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key' => 'group_home_grade_grid',
        'title' => 'Module: Grade Grid',
        'fields' => array(
            array(
                'key' => 'field_grade_grid_tab_content',
                'label' => 'Content',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_grade_grid_title',
                'label' => 'Title',
                'name' => 'grade_grid_title',
                'type' => 'text',
                'default_value' => 'Best-Selling Copper Grades',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_grade_grid_subtitle',
                'label' => 'Subtitle',
                'name' => 'grade_grid_subtitle',
                'type' => 'text',
                'default_value' => 'Fast shipping on our most requested alloys',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_grade_grid_items',
                'label' => 'Grades List',
                'name' => 'grade_grid_items',
                'type' => 'repeater',
                'instructions' => 'Add popular copper grades and their international equivalents.',
                'collapsed' => 'field_grade_code',
                'layout' => 'block',
                'button_label' => 'Add Grade Card',
                'sub_fields' => array(
                    array(
                        'key' => 'field_grade_code',
                        'label' => 'Main Grade Code',
                        'name' => 'grade_code',
                        'type' => 'text',
                        'instructions' => 'e.g. C11000',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_grade_name',
                        'label' => 'Description Name',
                        'name' => 'grade_name',
                        'type' => 'text',
                        'instructions' => 'e.g. Electrolytic Tough Pitch',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_stock_status',
                        'label' => 'Stock Status',
                        'name' => 'stock_status',
                        'type' => 'select',
                        'choices' => array(
                            'In Stock' => 'In Stock',
                            'Ready to Ship' => 'Ready to Ship',
                        ),
                        'default_value' => 'In Stock',
                        'wrapper' => array('width' => '33'),
                    ),
                    array(
                        'key' => 'field_grade_equivalents',
                        'label' => 'International Equivalents',
                        'name' => 'equivalents',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'instructions' => 'Comparison table for different standards (EN, JIS, etc.)',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_equiv_standard',
                                'label' => 'Standard',
                                'name' => 'standard',
                                'type' => 'text',
                                'placeholder' => 'EN / JIS / ASTM',
                            ),
                            array(
                                'key' => 'field_equiv_code',
                                'label' => 'Code',
                                'name' => 'code',
                                'type' => 'text',
                                'placeholder' => 'e.g. Cu-ETP',
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_grade_link',
                        'label' => 'Technical Specs Link',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-home', // Default for modules
                ),
            ),
        ),
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
