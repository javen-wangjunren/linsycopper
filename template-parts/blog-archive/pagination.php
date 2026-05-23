<?php
/**
 * Blog Archive: Pagination Section
 * Path: template-parts/blog-archive/pagination.php
 * 
 * Logic:
 * - Uses WordPress native paginate_links() with custom styling.
 * - Adheres to industrial design standards: rounded-sm (2px), font-mono.
 * - Copper UI branding: Navy active state, Copper hover state.
 */

global $wp_query;

// Only show pagination if there's more than 1 page
if ( $wp_query->max_num_pages <= 1 ) {
    return;
}

// 1. Configure Pagination Args
$pagination_args = array(
    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'format'       => '?paged=%#%',
    'current'      => max( 1, get_query_var( 'paged' ) ),
    'total'        => $wp_query->max_num_pages,
    'type'         => 'array',
    'prev_text'    => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>',
    'next_text'    => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>',
    'end_size'     => 1,
    'mid_size'     => 2,
);

$pages = paginate_links( $pagination_args );

if ( is_array( $pages ) ) : ?>
    <nav class="flex justify-center items-center gap-2 md:gap-3 py-12 md:py-16 border-t border-[#F2F4F7]" aria-label="Blog navigation">
        
        <?php foreach ( $pages as $page ) : 
            // Determine active/inactive status based on presence of 'current' class
            $is_current = strpos( $page, 'current' ) !== false;
            
            // Clean up the output to inject our industrial Tailwind classes
            if ( $is_current ) : ?>
                <span class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-sm bg-[#0B3570] text-white font-mono text-xs md:text-sm font-bold shadow-md ring-2 ring-[#0B3570]/10 border border-[#0B3570]">
                    <?php echo strip_tags( $page ); ?>
                </span>
            <?php else : ?>
                <?php
                // Inject classes into the link tag
                $page_link = str_replace( 
                    'page-numbers', 
                    'w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-sm bg-white border border-[#E5E7EB] text-[#4B5563] font-mono text-xs md:text-sm font-medium transition-all duration-300 hover:border-[#F97C30] hover:text-[#0B3570] hover:bg-[#F8F9FA] shadow-sm active:scale-95 group', 
                    $page 
                );
                echo $page_link;
                ?>
            <?php endif; ?>
        <?php endforeach; ?>

    </nav>
<?php endif; ?>
