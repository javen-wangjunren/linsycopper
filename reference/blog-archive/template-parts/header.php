<?php
/**
 * Template part for displaying the blog archive header.
 */

// Fetch data from query vars or globals if needed, but here we can just rely on context passed or re-fetch.
// Since get_template_part doesn't pass variables natively in older WP, we can use set_query_var or just re-fetch for simplicity as these are light calls.
// However, in modern WP (5.5+), we can pass args to get_template_part.
// Let's assume we pass $args.

$page_for_posts_id = get_option( 'page_for_posts' );
$archive_title     = get_field( 'blog_archive_title', $page_for_posts_id ) ?: 'Manufacturing Knowledge Base';
$archive_desc      = get_field( 'blog_archive_desc', $page_for_posts_id ) ?: 'Expert insights on industrial 3D printing materials, design guidelines, and post-processing techniques.';

// Handle Active Category
$current_cat_slug = get_query_var( 'category_name' );
if ( empty( $current_cat_slug ) && isset( $_GET['category'] ) ) {
	$current_cat_slug = sanitize_text_field( $_GET['category'] );
}
$active_cat = $current_cat_slug ? $current_cat_slug : 'all';
?>

<!-- Header Section: Centered & Focused -->
<div class="mb-16 text-center max-w-4xl mx-auto">
	<h1 class="text-[42px] lg:text-[56px] font-extrabold tracking-[-1.5px] leading-tight text-heading mb-6">
		<?php echo esc_html( $archive_title ); ?>
		<!-- Decorative Underline -->
		<span class="text-primary relative inline-block">
			<svg class="absolute -bottom-2 left-0 w-full h-2 text-primary/10" viewBox="0 0 100 10" preserveAspectRatio="none">
				<path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="4" fill="none" />
			</svg>
		</span>
	</h1>
	<?php if ( $archive_desc ) : ?>
		<p class="text-body text-lg max-w-2xl mx-auto leading-relaxed">
			<?php echo nl2br( esc_html( $archive_desc ) ); ?>
		</p>
	<?php endif; ?>
</div>

<!-- Filter Section: Centered Industrial Tabs -->
<div class="mb-20 flex justify-center">
	<div class="inline-flex flex-wrap justify-center gap-2 bg-panel p-1.5 rounded-xl border border-border shadow-sm">
		
		<!-- 'ALL' Button -->
		<a href="<?php echo esc_url( get_permalink( $page_for_posts_id ) ); ?>"
		   class="<?php echo 'all' === $active_cat ? 'bg-white text-primary shadow-sm ring-1 ring-border' : 'text-body hover:text-heading hover:bg-white/50'; ?> px-4 py-2 rounded-lg text-[11px] font-mono font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap">
			All
		</a>

		<?php
		$categories = get_categories( array(
			'exclude' => 1,
			'orderby' => 'count',
			'order'   => 'DESC',
			'number'  => 5,
		) );

		foreach ( $categories as $category ) :
			$is_active = ( $active_cat === $category->slug );
			$cat_link  = add_query_arg( 'category', $category->slug, get_permalink( $page_for_posts_id ) );
			?>
			<a href="<?php echo esc_url( $cat_link ); ?>"
			   class="<?php echo $is_active ? 'bg-white text-primary shadow-sm ring-1 ring-border' : 'text-body hover:text-heading hover:bg-white/50'; ?> px-4 py-2 rounded-lg text-[11px] font-mono font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap">
				<?php echo esc_html( $category->name ); ?>
			</a>
		<?php endforeach; ?>

	</div>
</div>
