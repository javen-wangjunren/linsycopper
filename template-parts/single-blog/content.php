<?php
/**
 * Single Blog Content
 * Path: template-parts/single-blog/content.php
 * 
 * Logic:
 * - Uses Tailwind Typography (prose) for industrial typesetting.
 * - Handles the_content filters (including our H2 ID injection).
 */

// Define consistent typography classes
$prose_classes = array(
    'prose',
    'prose-lg',
    'max-w-none',
    'text-[#374151]',
    'prose-headings:text-heading',
    'prose-headings:font-bold',
    'prose-headings:tracking-tight',
    'prose-h2:text-3xl',
    'prose-h2:mt-16',
    'prose-h2:mb-8',
    'prose-p:leading-relaxed',
    'prose-p:mb-8',
    'prose-a:text-[#F97C30]',
    'prose-a:font-semibold',
    'prose-a:no-underline',
    'prose-a:border-b',
    'prose-a:border-transparent',
    'hover:prose-a:border-[#F97C30]',
    'prose-strong:text-[#111827]',
    'prose-img:rounded-sm',
    'prose-img:shadow-lg',
    'prose-img:my-12',
    'prose-img:border',
    'prose-img:border-[#E5E7EB]',
    'prose-blockquote:border-l-4',
    'prose-blockquote:border-[#F97C30]',
    'prose-blockquote:bg-[#F8F9FA]',
    'prose-blockquote:py-2',
    'prose-blockquote:px-8',
    'prose-blockquote:rounded-sm',
    'prose-blockquote:italic',
    'prose-blockquote:text-[#4B5563]',
    'prose-li:marker:text-[#F97C30]',
    'prose-table:border',
    'prose-table:border-[#E5E7EB]',
    'prose-th:bg-[#F8F9FA]',
    'prose-th:py-3',
    'prose-th:px-4',
    'prose-td:py-3',
    'prose-td:px-4',
    'prose-td:border-t',
    'prose-td:border-[#E5E7EB]',
);

$prose_class = implode( ' ', $prose_classes );
?>

<article class="blog-content">
    
    <!-- Intro / Excerpt -->
    <?php if ( has_excerpt() ) : ?>
        <div class="mb-12 border-l-4 border-[#F97C30] pl-8 py-2">
            <p class="text-xl md:text-2xl font-medium leading-relaxed text-[#1F2937]">
                <?php echo get_the_excerpt(); ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Main Content Body -->
    <div class="<?php echo esc_attr( $prose_class ); ?>">
        <?php
        // apply_filters('the_content') will trigger our lc_add_ids_to_h2 function
        the_content();
        ?>
    </div>

    <div class="mt-16">
        <?php get_template_part( 'template-parts/single-blog/author-card', null, array( 'variant' => 'footer' ) ); ?>
    </div>

</article>
