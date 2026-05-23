<?php
/**
 * Template Part: Single Blog Header
 * Location: template-parts/single-blog/header.php
 */

$post_id    = get_the_ID();
$categories = get_the_category();
$cat_name   = ! empty( $categories ) ? $categories[0]->name : 'Article';
$date       = get_the_date( 'M j, Y' );
?>

<header class="bg-white border-b border-border">
	<div class="w-[90%] lg:w-[80%] mx-auto max-w-[1440px] py-16">
		<?php if ( function_exists( 'custom_breadcrumbs' ) ) : ?>
			<?php
			custom_breadcrumbs( array(
				'nav_class'     => 'flex items-center gap-2 font-mono text-[11px] tracking-wider text-body/70',
				'link_class'    => 'hover:text-heading transition-colors',
				'current_class' => 'text-heading font-medium',
				'sep_html'      => '<span class="text-body/40">/</span>',
			) );
			?>
		<?php endif; ?>

		<div class="mt-8 flex flex-wrap items-center justify-between gap-6">
			<div class="min-w-0">
				<div class="flex flex-wrap items-center gap-3 mb-5">
					<span class="inline-flex items-center gap-2 bg-panel border border-border px-3 py-1 rounded-button font-mono text-[11px] font-bold tracking-wider text-primary uppercase">
						<?php echo esc_html( $cat_name ); ?>
					</span>
					<span class="font-mono text-[11px] tracking-wider text-body/70"><?php echo esc_html( $date ); ?></span>
				</div>
				<h1 class="text-[36px] lg:text-[52px] font-extrabold leading-tight tracking-[-1.5px] max-w-4xl text-heading">
					<?php the_title(); ?>
				</h1>
			</div>
		</div>
	</div>
</header>
