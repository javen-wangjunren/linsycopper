<?php
/**
 * Global Available Sizes Module
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title      = get_field( 'global_available_sizes_title', 'option' );
$size_matrix = get_field( 'global_available_sizes_matrix', 'option' );
$note       = get_field( 'global_available_sizes_note', 'option' );

if ( empty( $size_matrix ) || ! is_array( $size_matrix ) ) {
	return;
}

$title = $title ? $title : 'Available Sizes';
$rows  = $size_matrix;

$header_row = array_shift( $rows );
$has_columns = false;

if ( empty( $header_row ) || ! is_array( $header_row ) ) {
	return;
}

for ( $i = 1; $i <= 5; $i++ ) {
	if ( ! empty( $header_row[ 'col_' . $i ] ) ) {
		$has_columns = true;
		break;
	}
}

if ( ! $has_columns ) {
	return;
}
?>

<section id="available-sizes" class="bg-white py-16 border-b border-gray-200">
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<h2 class="lc-h2-section text-heading mb-6">
			<?php echo esc_html( $title ); ?>
		</h2>

		<div class="overflow-x-auto rounded-sm border border-gray-200 shadow-sm">
			<table class="w-full text-left border-collapse !m-0">
				<thead class="bg-primary-blue text-white">
					<tr>
						<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
							<?php $col_val = isset( $header_row[ 'col_' . $i ] ) ? $header_row[ 'col_' . $i ] : ''; ?>
							<?php if ( ! empty( $col_val ) ) : ?>
								<th class="px-6 py-4 text-sm font-semibold whitespace-nowrap border-b border-primary-blue/20">
									<?php echo esc_html( $col_val ); ?>
								</th>
							<?php endif; ?>
						<?php endfor; ?>
					</tr>
				</thead>

				<tbody class="divide-y divide-gray-200 bg-white">
					<?php foreach ( $rows as $index => $row ) : ?>
						<tr class="<?php echo $index % 2 === 0 ? 'bg-white' : 'bg-gray-50'; ?> hover:bg-blue-50/30 transition-colors">
							<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
								<?php $header_val = isset( $header_row[ 'col_' . $i ] ) ? $header_row[ 'col_' . $i ] : ''; ?>
								<?php if ( ! empty( $header_val ) ) : ?>
									<?php $cell_val = isset( $row[ 'col_' . $i ] ) ? $row[ 'col_' . $i ] : ''; ?>
									<?php
									$cell_class = 'text-[#64748B]';
									if ( 1 === $i ) {
										$cell_class = 'text-[#1F2937] font-semibold';
									}
									?>
									<td class="px-6 py-3 text-sm font-sans whitespace-nowrap <?php echo esc_attr( $cell_class ); ?>">
										<?php echo esc_html( $cell_val ); ?>
									</td>
								<?php endif; ?>
							<?php endfor; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<?php if ( $note ) : ?>
			<p class="lc-body-card mt-4 italic text-gray-500">
				<?php echo wp_kses_post( $note ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
