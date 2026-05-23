<?php
/**
 * Blog Archive (Posts Page)
 * Path: home.php
 * 
 * Logic:
 * - Serves as the main index for all blog posts.
 * - Integrates modular template parts: Header (Hero), Grid (Posts), and Pagination.
 * - Adheres to industrial design standards (vertical rhythm, container spacing).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="bg-white font-sans antialiased text-[#1F2937]">

    <?php
    /**
     * I. Blog Header (Hero Section)
     * - Fetches content from ACF fields assigned to the 'Posts Page'.
     * - Includes category filters (tabs).
     */
    get_template_part( 'template-parts/blog-archive/header' );
    ?>

    <!-- Main Content Area: Post Grid + Sidebar (if needed) -->
    <main class="pt-[100px] pb-[100px]">
        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
            
            <?php
            /**
             * II. Post Grid
             * - Standard WordPress Loop to render post cards.
             * - Uses 3-column layout on desktop.
             */
            get_template_part( 'template-parts/blog-archive/grid' );

            /**
             * III. Pagination
             * - Styled pagination buttons (Copper UI standard).
             */
            get_template_part( 'template-parts/blog-archive/pagination' );
            ?>

        </div>
    </main>

</div>

<?php
get_footer();
