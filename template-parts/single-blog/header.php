<?php
/**
 * Single Blog Header
 * Path: template-parts/single-blog/header.php
 */

$author_id      = (int) get_the_author_meta( 'ID' );
$author_profile = function_exists( 'linsy_get_blog_author_profile' ) ? linsy_get_blog_author_profile( $author_id ) : array();
$author_name    = ! empty( $author_profile['name'] ) ? $author_profile['name'] : get_the_author();
$posts_page_id  = (int) get_option( 'page_for_posts' );
$blogs_url      = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/blog/' );
$published_date = get_the_date( 'M j, Y' );
$updated_date   = get_the_modified_date( 'M j, Y' );
$author_avatar  = function_exists( 'linsy_get_blog_author_avatar_html' )
    ? linsy_get_blog_author_avatar_html( $author_id, 64, 'w-full h-full object-cover' )
    : get_avatar( $author_id, 64, '', $author_name, array( 'class' => 'w-full h-full object-cover' ) );

$text_column_classes = has_post_thumbnail() ? 'lg:col-span-7' : 'lg:col-span-12';
?>

<header class="relative bg-[#F8F9FA] border-b border-[#E5E7EB] overflow-hidden">
    <!-- Copper UI: Industrial Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
         style="background-image: radial-gradient(#0B3570 1px, transparent 1px); background-size: 24px 24px;"></div>

    <div class="relative z-10 mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8 py-14 md:py-18">
        <div class="lc-breadcrumb-scope mb-3">
            <nav aria-label="Breadcrumb" class="text-sm text-gray-500 sm:text-[15px]">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                    <li class="flex items-center gap-x-2">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="transition-colors hover:text-[#0B3570]">
                            Home
                        </a>
                        <span aria-hidden="true" class="text-gray-300">/</span>
                    </li>
                    <li class="flex items-center gap-x-2">
                        <a href="<?php echo esc_url( $blogs_url ); ?>" class="transition-colors hover:text-[#0B3570]">
                            Blogs
                        </a>
                        <span aria-hidden="true" class="text-gray-300">/</span>
                    </li>
                    <li class="flex items-center gap-x-2">
                        <span class="font-medium text-[#0B3570]">
                            <?php the_title(); ?>
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            <div class="<?php echo esc_attr( $text_column_classes ); ?>">
                <h1 class="text-[#1F2937] text-4xl md:text-5xl lg:text-[56px] font-bold leading-[1.08] tracking-tight">
                    <?php the_title(); ?>
                </h1>

                <div class="mt-8 flex flex-wrap items-center gap-5 text-sm text-[#4B5563]">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full overflow-hidden border border-[#E5E7EB] bg-white shrink-0">
                            <?php echo $author_avatar; ?>
                        </div>
                        <div>
                            <div class="font-semibold text-[#1F2937]"><?php echo esc_html( $author_name ); ?></div>
                        </div>
                    </div>
                    <div class="h-10 w-px bg-[#E5E7EB] hidden sm:block"></div>
                    <div class="font-medium">
                        <span class="text-[#1F2937]">Published Date:</span>
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $published_date ); ?></time>
                    </div>
                    <div class="font-medium">
                        <span class="text-[#1F2937]">Updated Date:</span>
                        <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( $updated_date ); ?></time>
                    </div>
                </div>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="lg:col-span-5">
                    <div class="overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-2 shadow-lg">
                        <div class="aspect-[4/3] overflow-hidden rounded-sm">
                            <?php the_post_thumbnail( 'full', array( 'class' => 'h-full w-full object-cover' ) ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
