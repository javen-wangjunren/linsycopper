<?php
/**
 * Product Specifications Block Template
 * ==========================================================================
 * 文件作用:
 * 展示技术参数表 (Technical Specifications)
 * 
 * 核心逻辑:
 * 1. 数据源: ACF Repeater (product_spec_tables)
 * 2. 表格渲染: 
 *    - 外部循环渲染不同的表格 (如 Chemical, Mechanical)
 *    - 内部循环渲染表格行 (Row 1 = <thead>, Others = <tbody>)
 *    - 自动添加序号 (01, 02...)
 * 3. 智能高亮: 自动检测列名 (如 "Value") 并应用橙色高亮。
 * 
 * 架构角色:
 * Product CPT 的标准模块之一，通常位于 Applications 之后。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

// ==========================================================================
// I. 数据获取 (Data Retrieval)
// ==========================================================================
$title    = get_flat_field( 'product_spec_title', [], 'Technical Specifications' );
$subtitle = get_flat_field( 'product_spec_subtitle', [], 'Precision data for engineering decisions.' );
$tables   = get_flat_field( 'product_spec_tables', [], [] );
$available_grades = get_flat_field( 'product_spec_available_grades', [], [] );

if ( empty( $tables ) && empty( $available_grades ) ) {
	return; 
}
?>

<section id="specifications" class="bg-white py-16">
	<div class="mx-auto max-w-7xl px-4">
		
		<!-- ========================================================================== -->
		<!-- II. 模块头部 (Section Header) -->
		<!-- ========================================================================== -->
		<div class="mb-12 text-center">
			<h2 class="lc-h2-section text-heading">
				<?php echo esc_html( $title ); ?>
			</h2>
			<?php if ( $subtitle ) : ?>
				<p class="lc-body-meta mt-3 max-w-2xl !mx-auto !text-center text-sm">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>
		</div>

		<!-- ========================================================================== -->
		<!-- III. 表格循环 (Tables Loop) -->
		<!-- ========================================================================== -->
		<?php 
		$table_index = 1;
		if ( ! empty( $tables ) ) :
			foreach ( $tables as $table ) : 
				$table_name = isset( $table['spec_table_name'] ) ? $table['spec_table_name'] : '';
				$rows = isset( $table['spec_table_data'] ) ? $table['spec_table_data'] : [];
				
				if ( empty( $rows ) ) continue;

				// 格式化序号 (01, 02...)
				$index_str = str_pad( $table_index, 2, '0', STR_PAD_LEFT );
		?>
			<div class="mb-12 last:mb-0">
				
				<!-- 3.1 Table Title -->
				<h3 class="lc-h3-feature mb-4 flex items-center text-[#0B3570]">
					<span class="lc-mono-chip inline-flex items-center justify-center w-8 h-8 rounded bg-[#0B3570] mr-3 text-white text-sm">
						<?php echo esc_html( $index_str ); ?>
					</span>
					<?php echo esc_html( $table_name ); ?>
				</h3>

				<!-- 3.2 Table Container (Overflow handled) -->
				<div class="overflow-x-auto rounded border border-[#E5E7EB]">
					<table class="product_spec_table w-full text-left border-collapse !m-0">
						
						<?php 
						// 拆分表头 (Row 1) 和 表体 (Body)
						$header_row = array_shift( $rows ); // Removes and returns first element
						
						// 智能高亮逻辑: 预扫描表头，确定哪一列是 "Value"
						$highlight_cols = [];
						if ( $header_row ) {
							for( $i = 1; $i <= 4; $i++ ) {
								$col_key = 'col_' . $i;
								if ( ! empty( $header_row[ $col_key ] ) ) {
									$h_text = strtolower( trim( $header_row[ $col_key ] ) );
									// 如果表头包含 'value' 或 'min' 或 'max'，标记为需要高亮
									// React 设计稿中 Mechanical/Physical 的 'Value' 列是橙色的
									if ( $h_text === 'value' ) {
										$highlight_cols[$i] = true;
									}
								}
							}
						}
						?>

						<!-- 3.3 Thead -->
						<?php if ( $header_row ) : ?>
							<thead class="bg-[#0B3570] text-white">
								<tr>
									<?php for( $i = 1; $i <= 4; $i++ ) : 
										$col_key = 'col_' . $i;
										if ( ! empty( $header_row[ $col_key ] ) ) :
									?>
										<th class="px-6 py-3 text-sm font-semibold whitespace-nowrap">
											<?php echo esc_html( $header_row[ $col_key ] ); ?>
										</th>
									<?php endif; endfor; ?>
								</tr>
							</thead>
						<?php endif; ?>

						<!-- 3.4 Tbody -->
						<tbody class="divide-y divide-[#E5E7EB]">
							<?php
							$body_row_index = 0;
							foreach ( $rows as $row ) :
								$has_any_value = false;
								for ( $i = 1; $i <= 4; $i++ ) {
									if ( empty( $header_row['col_' . $i] ) ) {
										continue;
									}

									$col_key  = 'col_' . $i;
									$cell_val = isset( $row[ $col_key ] ) ? trim( (string) $row[ $col_key ] ) : '';
									if ( $cell_val !== '' ) {
										$has_any_value = true;
										break;
									}
								}

								if ( ! $has_any_value ) {
									continue;
								}

								$bg_class = ( $body_row_index % 2 === 0 ) ? 'bg-white' : 'bg-[#F8FAFC]';
							?>
								<tr class="<?php echo esc_attr( $bg_class ); ?>">
									<?php for( $i = 1; $i <= 4; $i++ ) : 
										$col_key = 'col_' . $i;
										// 仅渲染有表头的列，保持结构对齐
										if ( ! empty( $header_row['col_' . $i] ) ) :
											$cell_val = isset( $row[ $col_key ] ) ? $row[ $col_key ] : '';
											
											// === 单元格样式逻辑 (Visual First) ===
											// 默认: 灰色, Mono字体, 小号
											$cell_class = 'text-[#6B7280]'; 
											$font_class = 'lc-mono-meta text-sm'; 
											
											// 规则 A: 第一列 (Label) -> 深色, Sans, 加粗
											if ( $i === 1 ) {
												$cell_class = 'text-[#1F2937] font-semibold font-sans';
												$font_class = '';
											} 
											// 规则 B: 智能高亮列 (Value) -> 橙色 (#F97C30), 加粗
											elseif ( isset( $highlight_cols[$i] ) ) {
												$cell_class = 'text-[#F97C30] font-semibold';
											}
											// 规则 C: 最后一列 (Note/Standard) -> 更小的字体 (React design: text-xs)
											// 简单判断: 如果是第4列，或者第3列且总列数为3
											// 这里简单粗暴一点，只要是第4列就变小
											elseif ( $i === 4 ) {
												$font_class = 'lc-mono-chip text-xs';
											}
									?>
										<td class="px-6 py-3 <?php echo $font_class . ' ' . $cell_class; ?> whitespace-nowrap">
											<?php echo esc_html( $cell_val ); ?>
										</td>
									<?php endif; endfor; ?>
								</tr>
							<?php
								$body_row_index++;
							endforeach;
							?>
						</tbody>

					</table>
				</div>
			</div>
		<?php 
			$table_index++;
			endforeach; 
		endif;
		?>

		<?php if ( ! empty( $available_grades ) && is_array( $available_grades ) ) : ?>
			<?php
			$grade_items = array();
			foreach ( $available_grades as $g ) {
				$grade_label = isset( $g['grade_label'] ) ? trim( (string) $g['grade_label'] ) : '';
				$grade_pid   = isset( $g['grade_product_id'] ) ? (int) $g['grade_product_id'] : 0;

				if ( $grade_label === '' && $grade_pid <= 0 ) {
					continue;
				}

				$grade_url = $grade_pid > 0 ? get_permalink( $grade_pid ) : '';
				$grade_items[] = array(
					'label' => $grade_label,
					'url'   => $grade_url,
				);
			}
			?>

			<?php if ( ! empty( $grade_items ) ) : ?>
				<?php $index_str = str_pad( $table_index, 2, '0', STR_PAD_LEFT ); ?>
				<div class="mb-12 last:mb-0">
					<h3 class="lc-h3-feature mb-4 flex items-center text-[#0B3570]">
						<span class="lc-mono-chip inline-flex items-center justify-center w-8 h-8 rounded bg-[#0B3570] mr-3 text-white text-sm">
							<?php echo esc_html( $index_str ); ?>
						</span>
						<?php echo esc_html( 'Available Grades' ); ?>
					</h3>

					<div class="lc-grade-chip-wrap">
						<?php foreach ( $grade_items as $gi ) : ?>
							<?php if ( ! empty( $gi['url'] ) ) : ?>
								<a href="<?php echo esc_url( $gi['url'] ); ?>" class="lc-grade-chip">
									<?php echo esc_html( $gi['label'] ); ?>
								</a>
							<?php else : ?>
								<span class="lc-grade-chip lc-grade-chip--disabled">
									<?php echo esc_html( $gi['label'] ); ?>
								</span>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>
</section>
