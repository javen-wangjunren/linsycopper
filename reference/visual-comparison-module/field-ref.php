<?php
/**
 * Visual Comparison Module Schema
 * ==========================================================================
 * 文件作用:
 * 定义 Visual Comparison (视觉对比) 模块的 ACF 字段结构。
 * 该模块包含标题、两张对比图片（Before/After）、阶段描述列表和 CTA 按钮。
 *
 * 核心逻辑:
 * 1. 定义字段组 `group_visual_comparison`。
 * 2. 包含 Images, Repeater (Phases), CTA Link 等字段。
 *
 * 架构角色:
 * 这是一个 "Source Group" (源字段组)，通常设置为 `active => false`。
 * 它不直接绑定到页面，而是通过 `clone` 字段在 CPT (如 Surface Finish) 中被复用。
 *
 * 🚨 避坑指南:
 * - 修改此文件会影响所有 clone 了此组的地方。
 * - `return_format` 设为 `id` 是为了在前端通过 `wp_get_attachment_image_url` 获取不同尺寸。
 * ==========================================================================
 * 
 * @package 3D_Printing
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    
    add_action( 'acf/init', function() {
        
        // ==========================================================================
        // I. 字段定义 (Field Definitions)
        // ==========================================================================
        acf_add_local_field_group( array(
            'key' => 'group_visual_comparison',
            'title' => 'Visual Comparison Module',
            'fields' => array(
                
                // 1. Section Title
                array(
                    'key' => 'field_visual_title',
                    'label' => 'Section Title',
                    'name' => 'visual_title',
                    'type' => 'text',
                    'default_value' => 'Surface <span class="text-primary">Transformation</span>',
                ),

                // 2. Images (Before & After)
                // Use return_format => id for flexibility in templates
                array(
                    'key' => 'field_visual_before_img',
                    'label' => 'Before Image (Raw)',
                    'name' => 'visual_before_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'wrapper' => array( 'width' => '50' ),
                ),
                array(
                    'key' => 'field_visual_after_img',
                    'label' => 'After Image (Finished)',
                    'name' => 'visual_after_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'wrapper' => array( 'width' => '50' ),
                ),

                // 3. Phases Repeater (Left Side Info)
                // Describes the transformation steps
                array(
                    'key' => 'field_visual_phases',
                    'label' => 'Process Phases',
                    'name' => 'visual_phases',
                    'type' => 'repeater',
                    'layout' => 'row',
                    'button_label' => 'Add Phase',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_visual_phase_title',
                            'label' => 'Phase Title',
                            'name' => 'phase_title',
                            'type' => 'text',
                            'default_value' => 'PHASE 01 // RAW PRINT',
                        ),
                        array(
                            'key' => 'field_visual_phase_desc',
                            'label' => 'Description',
                            'name' => 'phase_desc',
                            'type' => 'textarea',
                            'rows' => 3,
                            'default_value' => 'Characteristic stair-stepping effects with a roughness index of Ra 6.3μm.',
                        ),
                    ),
                ),

                // 4. CTA Button
                array(
                    'key' => 'field_visual_cta',
                    'label' => 'CTA Link',
                    'name' => 'visual_cta_link',
                    'type' => 'link',
                    'return_format' => 'array',
                ),
            ),
            
            // Set to false because this is a clone source
            'active' => false, 
        ));
    });
}
