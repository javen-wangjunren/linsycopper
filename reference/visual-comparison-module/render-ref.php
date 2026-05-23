<?php
/**
 * Visual Comparison Block Render Template
 * ==========================================================================
 * 文件作用:
 * 渲染“视觉对比”模块，展示 3D 打印表面处理前后的对比效果。
 * 包含左侧的阶段描述列表和右侧的交互式滑动对比图。
 *
 * 核心逻辑:
 * 1. 接收 ACF 数据（标题、前后对比图、阶段描述、CTA）。
 * 2. 使用 Alpine.js (`x-data`) 管理滑块位置 (`position`)。
 * 3. 使用 CSS `clip-path` 实现高性能的图片裁剪对比效果。
 *
 * 架构角色:
 * 这是一个 Global Block 的渲染模版，被多个 CPT (如 Surface Finish) 复用。
 * 由于采用了 "Seamless & No-Prefix" 策略，所有上下文中的字段名均一致。
 *
 * 🚨 避坑指南:
 * - 图片裁剪依赖 `clip-path: inset(...)`，无需 JS 计算容器宽度，性能更佳。
 * ==========================================================================
 * 
 * @package 3D_Printing
 */

// ==========================================================================
// I. 初始化 (Initialization)
// ==========================================================================

// 获取扁平化字段 (Flattened fields)
// 使用 get_flat_field 替代 get_field 以获得更好的兜底支持和代码简洁性
$title      = get_flat_field('visual_title', $block, 'Surface <br> <span class="text-primary">Transformation</span>');
$raw_img_id = get_flat_field('visual_before_image', $block);
$fin_img_id = get_flat_field('visual_after_image', $block);
$phases     = get_flat_field('visual_phases', $block, array());
$cta_link   = get_flat_field('visual_cta_link', $block);

// ==========================================================================
// III. 数据预处理 (Data Preprocessing)
// ==========================================================================

// 图片回退 (Image Fallbacks)
// 如果未设置图片，使用 Unsplash 占位符用于演示
$raw_url = $raw_img_id 
    ? wp_get_attachment_image_url($raw_img_id, 'full') 
    : 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=2000';

$fin_url = $fin_img_id 
    ? wp_get_attachment_image_url($fin_img_id, 'full') 
    : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2000';

?>

<!-- 
    ==========================================================================
    IV. 视图渲染 (View Rendering)
    ==========================================================================
-->
<section class="pt-[90px] pb-24 bg-white relative">
    
    <div class="max-w-container mx-auto px-container">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center">
            
            <!-- Left: Content Cluster (Span 5) -->
            <div class="lg:col-span-5 flex flex-col gap-10">
                
                <!-- 1. Title -->
                <h2 class="text-heading text-3xl md:text-4xl font-bold leading-tight">
                    <?php echo wp_kses_post($title); ?>
                </h2>

                <!-- 2. Phases Repeater -->
                <?php if ( ! empty($phases) ) : ?>
                <div class="space-y-8 border-l-[3px] border-border pl-8 py-2">
                    <?php foreach ( $phases as $phase ) : 
                        $p_title = isset($phase['phase_title']) ? $phase['phase_title'] : '';
                        $p_desc  = isset($phase['phase_desc']) ? $phase['phase_desc'] : '';
                    ?>
                        <div class="flex flex-col gap-3">
                            <!-- Phase Title -->
                            <?php if ($p_title): ?>
                                <span class="font-mono text-primary font-bold text-sm tracking-wide uppercase">
                                    <?php echo esc_html($p_title); ?>
                                </span>
                            <?php endif; ?>
                            
                            <!-- Phase Description -->
                            <?php if ($p_desc): ?>
                                <p class="text-body text-base leading-relaxed text-gray-600">
                                    <?php echo wp_kses_post($p_desc); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- 3. CTA Button -->
                <?php if ( $cta_link && isset($cta_link['url']) && $cta_link['url'] ) : 
                    $link_url    = $cta_link['url'];
                    $link_title  = $cta_link['title'] ? $cta_link['title'] : 'VIEW FINISHING SPECS';
                    $link_target = $cta_link['target'] ? $cta_link['target'] : '_self';
                ?>
                <div class="pt-2">
                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="inline-flex items-center justify-center gap-3 bg-primary text-white font-mono text-sm font-bold px-8 py-4 rounded-lg hover:bg-primary-hover transition-colors group">
                        <?php echo esc_html($link_title); ?>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right: Visual Comparison Slider (Span 7) -->
            <div class="lg:col-span-7 w-full">
                <!-- 
                    Alpine Component:
                    - x-data="{ position: 50 }": 初始化滑块位置在中间
                    - aspect-[4/3]: 锁定图片比例
                    - clip-path: 使用 CSS 裁剪实现遮罩，性能最优
                -->
                <div x-data="{ position: 50 }" 
                     class="relative aspect-[4/3] w-full rounded-2xl overflow-hidden bg-gray-100 border border-border shadow-sm select-none group touch-none">
                    
                    <!-- 1. After Image (Base Layer - Full) -->
                    <div class="absolute inset-0 w-full h-full">
                        <img src="<?php echo esc_url($fin_url); ?>" 
                             class="w-full h-full object-cover" 
                             alt="Finished Surface">
                        
                        <!-- Label: Finished -->
                        <div class="absolute top-4 right-4 bg-black/60 backdrop-blur-md text-white text-xs font-mono px-3 py-1 rounded-full uppercase tracking-wider z-20 pointer-events-none">
                            Finished
                        </div>
                    </div>

                    <!-- 2. Before Image (Overlay Layer - Clipped) -->
                    <!-- Using clip-path to reveal only the left part based on position -->
                    <div class="absolute inset-0 w-full h-full z-10"
                         :style="`clip-path: inset(0 ${100 - position}% 0 0)`">
                        <img src="<?php echo esc_url($raw_url); ?>" 
                             class="w-full h-full object-cover grayscale-[20%]" 
                             alt="Raw Surface">
                             
                        <!-- Label: Raw -->
                        <div class="absolute top-4 left-4 bg-primary/90 backdrop-blur-md text-white text-xs font-mono px-3 py-1 rounded-full uppercase tracking-wider z-20 pointer-events-none">
                            Raw
                        </div>
                    </div>

                    <!-- 3. Slider Handle -->
                    <div class="absolute inset-y-0 z-30 w-1 bg-white cursor-ew-resize hover:bg-white/80 transition-colors shadow-[0_0_10px_rgba(0,0,0,0.2)]"
                         :style="`left: ${position}%`">
                        
                        <!-- Knob -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-primary rounded-full border-[3px] border-white shadow-lg flex items-center justify-center transform group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l-3 3 3 3m8-6l3 3-3 3"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- 4. Interaction Layer (Range Input) -->
                    <input type="range" min="0" max="100" step="0.1"
                           x-model="position"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-ew-resize z-40"
                           aria-label="Comparison slider">
                </div>
            </div>

        </div>
    </div>
</section>
