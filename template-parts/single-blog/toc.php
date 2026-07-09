<?php
/**
 * Single Blog Table Of Contents
 * Path: template-parts/single-blog/toc.php
 */

$content = get_the_content();
$toc     = lc_get_post_toc( $content );

if ( empty( $toc ) ) {
	return;
}
?>

<div class="lc-blog-toc border border-[#E5E7EB] rounded-sm p-6 bg-[#F8F9FA]">
	<div class="flex items-center justify-between gap-4 mb-6">
		<div class="font-mono text-[11px] tracking-wider text-[#6B7280] uppercase">Table Of Contents</div>
		<div class="font-mono text-[11px] tracking-wider text-[#6B7280]"><?php echo esc_html( str_pad( (string) count( $toc ), 2, '0', STR_PAD_LEFT ) ); ?></div>
	</div>
	<nav class="space-y-2" aria-label="Table of Contents">
		<?php foreach ( $toc as $index => $item ) : ?>
			<a href="#<?php echo esc_attr( $item['id'] ); ?>" class="lc-blog-toc__link flex items-center justify-between gap-4 py-2 px-3 rounded-sm hover:bg-white transition-colors group">
				<span class="text-[13px] font-semibold text-[#1F2937] group-hover:text-[#0B3570] transition-colors">
					<?php echo esc_html( $item['title'] ); ?>
				</span>
				<span class="font-mono text-[11px] text-[#6B7280]">
					<?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?>
				</span>
			</a>
		<?php endforeach; ?>
	</nav>
</div>
