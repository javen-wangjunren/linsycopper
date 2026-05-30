<?php
/**
 * Global Module: Why Choose Us (Render)
 * ==========================================================================
 * 文件作用:
 * 渲染全站通用的 "Why Choose Us" (Quality & Manufacturing) 模块。
 * 
 * 核心逻辑:
 * 1. 数据源: ACF Options Page (Global Modules > global_why_choose_us)
 * 2. 布局结构: Bento Grid (混合网格)
 *    - 左侧: 竖向长图卡片 (ISO Cert)
 *    - 右侧: 两个横向图文卡片 (Machine, Logistics)
 * 
 * 架构角色:
 * 全局复用模块，通常用于产品详情页 (Product CPT) 的中部，展示制造实力。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

// ==========================================================================
// I. 数据获取 (Data Retrieval)
// ==========================================================================

// 1. Get Group Data from Options Page
$group_data = get_field( 'global_why_choose_us', 'option' );

// 2. Validate Data
if ( ! $group_data ) return;

// 3. Extract Fields (with fallbacks)
$title    = isset( $group_data['wcu_title'] ) ? $group_data['wcu_title'] : 'Quality & Manufacturing';
$subtitle = isset( $group_data['wcu_subtitle'] ) ? $group_data['wcu_subtitle'] : '';
$cta_link = isset( $group_data['wcu_cta_link'] ) ? $group_data['wcu_cta_link'] : null;

// Card 1: Certification
$cert_img   = isset( $group_data['wcu_cert_image'] ) ? $group_data['wcu_cert_image'] : '';
$cert_img_m = isset( $group_data['wcu_cert_image_mobile'] ) ? $group_data['wcu_cert_image_mobile'] : '';
$cert_title = isset( $group_data['wcu_cert_title'] ) ? $group_data['wcu_cert_title'] : 'Quality Compliance';
$cert_desc  = isset( $group_data['wcu_cert_desc'] ) ? $group_data['wcu_cert_desc'] : '';

// Card 2: Machine
$mach_img   = isset( $group_data['wcu_machine_image'] ) ? $group_data['wcu_machine_image'] : '';
$mach_img_m = isset( $group_data['wcu_machine_image_mobile'] ) ? $group_data['wcu_machine_image_mobile'] : '';
$mach_title = isset( $group_data['wcu_machine_title'] ) ? $group_data['wcu_machine_title'] : 'Precision Machining';
$mach_desc  = isset( $group_data['wcu_machine_desc'] ) ? $group_data['wcu_machine_desc'] : '';

// Card 3: Logistics
$log_img    = isset( $group_data['wcu_logistic_image'] ) ? $group_data['wcu_logistic_image'] : '';
$log_img_m  = isset( $group_data['wcu_logistic_image_mobile'] ) ? $group_data['wcu_logistic_image_mobile'] : '';
$log_title  = isset( $group_data['wcu_logistic_title'] ) ? $group_data['wcu_logistic_title'] : 'Global Logistics';
$log_desc   = isset( $group_data['wcu_logistic_desc'] ) ? $group_data['wcu_logistic_desc'] : '';

?>

<section class="py-24 bg-white">
	<div class="max-w-[1280px] mx-auto px-6">
		
		<!-- ========================================================================== -->
		<!-- II. 模块头部 (Section Header) -->
		<!-- ========================================================================== -->
		<div class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-6">
			<div class="max-w-2xl">
				<h2 class="text-heading text-3xl md:text-4xl font-bold mb-4">
					<?php echo esc_html( $title ); ?>
				</h2>
				<?php if ( $subtitle ) : ?>
					<p class="text-[#6B7280] text-sm leading-relaxed max-w-xl">
						<?php echo esc_html( $subtitle ); ?>
					</p>
				<?php endif; ?>
			</div>
			
			<!-- Desktop CTA -->
			<?php if ( $cta_link ) : ?>
				<div class="hidden md:block">
					<a href="<?php echo esc_url( $cta_link['url'] ); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-[#0B3570] text-[#0B3570] text-xs font-bold tracking-widest hover:bg-[#0B3570] hover:text-white transition-all duration-300 rounded-sm group" target="<?php echo esc_attr( $cta_link['target'] ); ?>">
						<?php echo esc_html( $cta_link['title'] ); ?>
						<svg class="w-3 h-3 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<!-- ========================================================================== -->
		<!-- III. Bento Grid Layout (Cards) -->
		<!-- ========================================================================== -->
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 auto-rows-[minmax(200px,auto)]">
			
			<!-- Card 01: ISO Cert (Left Column - Vertical) -->
			<div class="lg:col-span-4 lg:row-span-2 group relative bg-white border border-[#E5E7EB] hover:border-[#F97C30] transition-all duration-300 flex flex-col rounded-sm hover:shadow-xl overflow-hidden">
				
				<!-- Vertical Image Area -->
				<div class="h-auto md:h-[400px] lg:h-full aspect-[16/9] md:aspect-auto bg-[#F8FAFC] relative border-b lg:border-b-0 lg:border-r border-[#E5E7EB] overflow-hidden p-0 md:p-8 flex items-center justify-center">
					<div class="absolute inset-0 bg-gradient-to-br from-[#0B3570]/5 to-[#0B3570]/10"></div>
					<div class="relative w-full h-full md:hidden">
						<?php $cert_img_mobile = $cert_img_m ? $cert_img_m : $cert_img; ?>
						<?php if ( $cert_img_mobile ) : ?>
							<?php echo wp_get_attachment_image( $cert_img_mobile, 'large', false, ['class' => 'w-full h-full object-cover'] ); ?>
						<?php else: ?>
							<img src="https://placehold.co/800x450/F1F5F9/0B3570?text=Quality+Inspection" class="w-full h-full object-cover" alt="Quality inspection">
						<?php endif; ?>
					</div>
					<div class="relative w-full max-w-[240px] aspect-[3/4] bg-white shadow-lg rotate-0 group-hover:scale-105 transition-transform duration-700 p-2 hidden md:block">
						<?php if ( $cert_img ) : ?>
							<?php echo wp_get_attachment_image( $cert_img, 'medium', false, ['class' => 'w-full h-full object-cover'] ); ?>
						<?php else: ?>
							<img src="https://placehold.co/300x400/F1F5F9/0B3570?text=ISO+Certificate" class="w-full h-full object-cover" alt="ISO Certification">
						<?php endif; ?>
					</div>
					
					<!-- Index -->
					<div class="absolute top-4 left-4 font-mono text-4xl font-bold text-[#0B3570]/10 select-none">01</div>
				</div>

				<!-- Content -->
				<div class="absolute bottom-0 left-0 right-0 bg-white/95 backdrop-blur-sm p-6 border-t border-[#E5E7EB]">
					<h3 class="text-heading text-lg font-bold mb-2 group-hover:text-[#0B3570] transition-colors">
						<?php echo esc_html( $cert_title ); ?>
					</h3>
					<p class="text-xs text-[#6B7280] leading-relaxed line-clamp-3">
						<?php echo nl2br( esc_html( $cert_desc ) ); ?>
					</p>
				</div>
			</div>

			<!-- Card 02: Precision Machining (Right Top - Horizontal) -->
			<div class="lg:col-span-8 group relative bg-white border border-[#E5E7EB] hover:border-[#F97C30] transition-all duration-300 flex flex-col md:flex-row rounded-sm hover:shadow-xl overflow-hidden min-h-[280px]">
				<!-- Image -->
				<div class="md:w-1/2 aspect-[16/9] md:aspect-auto bg-[#F8FAFC] relative overflow-hidden border-b md:border-b-0 md:border-r border-[#E5E7EB]">
					<div class="absolute inset-0 bg-gradient-to-br from-[#0B3570]/5 to-[#0B3570]/10"></div>
					<?php $mach_img_mobile = $mach_img_m ? $mach_img_m : $mach_img; ?>
					<?php if ( $mach_img_mobile ) : ?>
						<?php echo wp_get_attachment_image( $mach_img_mobile, 'large', false, ['class' => 'w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 md:hidden'] ); ?>
					<?php else: ?>
						<img src="https://placehold.co/800x450/F1F5F9/0B3570?text=Manufacturing" class="w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 md:hidden" alt="Manufacturing">
					<?php endif; ?>
					<?php if ( $mach_img ) : ?>
						<?php echo wp_get_attachment_image( $mach_img, 'large', false, ['class' => 'w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 hidden md:block'] ); ?>
					<?php else: ?>
						<img src="https://placehold.co/600x400/F1F5F9/0B3570?text=CNC+Machining" class="w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 hidden md:block" alt="Precision Machining">
					<?php endif; ?>
					<div class="absolute top-4 left-4 font-mono text-4xl font-bold text-[#0B3570]/10 select-none">02</div>
				</div>
				<!-- Content -->
				<div class="p-8 md:w-1/2 flex flex-col justify-center">
					<h3 class="text-heading text-lg font-bold mb-3 group-hover:text-[#0B3570] transition-colors">
						<?php echo esc_html( $mach_title ); ?>
					</h3>
					<p class="text-sm text-[#6B7280] leading-relaxed">
						<?php echo nl2br( esc_html( $mach_desc ) ); ?>
					</p>
				</div>
			</div>

			<!-- Card 03: Global Logistics (Right Bottom - Horizontal) -->
			<div class="lg:col-span-8 group relative bg-white border border-[#E5E7EB] hover:border-[#F97C30] transition-all duration-300 flex flex-col md:flex-row rounded-sm hover:shadow-xl overflow-hidden min-h-[280px]">
				<!-- Image -->
				<div class="md:w-1/2 aspect-[16/9] md:aspect-auto bg-[#F8FAFC] relative overflow-hidden border-b md:border-b-0 md:border-r border-[#E5E7EB]">
						<div class="absolute inset-0 bg-gradient-to-br from-[#0B3570]/5 to-[#0B3570]/10"></div>
					<?php $log_img_mobile = $log_img_m ? $log_img_m : $log_img; ?>
					<?php if ( $log_img_mobile ) : ?>
						<?php echo wp_get_attachment_image( $log_img_mobile, 'large', false, ['class' => 'w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 md:hidden'] ); ?>
					<?php else: ?>
						<img src="https://placehold.co/800x450/F1F5F9/0B3570?text=Logistics" class="w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 md:hidden" alt="Logistics">
					<?php endif; ?>
					<?php if ( $log_img ) : ?>
						<?php echo wp_get_attachment_image( $log_img, 'large', false, ['class' => 'w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 hidden md:block'] ); ?>
					<?php else: ?>
						<img src="https://placehold.co/600x400/F1F5F9/0B3570?text=Global+Logistics" class="w-full h-full object-cover mix-blend-multiply opacity-80 group-hover:scale-105 transition-transform duration-700 hidden md:block" alt="Global Logistics">
					<?php endif; ?>
					<div class="absolute top-4 left-4 font-mono text-4xl font-bold text-[#0B3570]/10 select-none">03</div>
				</div>
				<!-- Content -->
				<div class="p-8 md:w-1/2 flex flex-col justify-center">
					<h3 class="text-heading text-lg font-bold mb-3 group-hover:text-[#0B3570] transition-colors">
						<?php echo esc_html( $log_title ); ?>
					</h3>
					<p class="text-sm text-[#6B7280] leading-relaxed">
						<?php echo nl2br( esc_html( $log_desc ) ); ?>
					</p>
				</div>
			</div>

		</div>

		<!-- Mobile CTA -->
		<?php if ( $cta_link ) : ?>
			<div class="mt-12 text-center md:hidden">
				<a href="<?php echo esc_url( $cta_link['url'] ); ?>" class="inline-flex items-center justify-center px-8 py-4 bg-[#0B3570] text-white text-xs font-bold tracking-widest hover:bg-[#0B3570]/90 transition-all rounded-sm w-full" target="<?php echo esc_attr( $cta_link['target'] ); ?>">
					<?php echo esc_html( $cta_link['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>

	</div>
</section>
