<?php
/**
 * Blog Template Functions
 * Path: inc/blog-template-functions.php
 * 
 * Logic:
 * - Dynamic Table of Contents (TOC) generation.
 * - H2 Anchor injection via the_content filter.
 * - Standardized content extraction for blog posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Extract Table of Contents from content
 * Scans for <h2> tags and returns a structured array.
 * 
 * @param string $content Post content HTML.
 * @return array List of TOC items [ 'id' => '', 'title' => '' ].
 */
function lc_get_post_toc( $content ) {
    $toc = array();
    
    // Match all H2 tags
    if ( preg_match_all( '/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches ) ) {
        $titles = $matches[1];
        $slugs  = array();

        foreach ( $titles as $title ) {
            $clean_title = strip_tags( $title );
            $id = sanitize_title( $clean_title );
            
            // Handle duplicate IDs
            $count = 1;
            $original_id = $id;
            while ( in_array( $id, $slugs ) ) {
                $id = $original_id . '-' . $count;
                $count++;
            }
            
            $slugs[] = $id;
            $toc[] = array(
                'id'    => $id,
                'title' => $clean_title,
            );
        }
    }
    
    return $toc;
}

/**
 * Inject IDs into H2 tags for anchor linking
 * 
 * @param string $content Post content HTML.
 * @return string Modified content.
 */
function lc_add_ids_to_h2( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }

    $slugs = array();
    
    $content = preg_replace_callback( 
        '/<h2([^>]*)>(.*?)<\/h2>/is', 
        function( $matches ) use ( &$slugs ) {
            $attrs = $matches[1];
            $title = $matches[2];
            $clean_title = strip_tags( $title );
            $id = sanitize_title( $clean_title );
            
            // Handle duplicate IDs (same logic as toc generation)
            $count = 1;
            $original_id = $id;
            while ( in_array( $id, $slugs ) ) {
                $id = $original_id . '-' . $count;
                $count++;
            }
            $slugs[] = $id;
            
            // Reconstruct H2 with ID
            return sprintf( '<h2 id="%s"%s>%s</h2>', esc_attr( $id ), $attrs, $title );
        }, 
        $content 
    );
    
    return $content;
}

// Hook the ID injection into the_content
add_filter( 'the_content', 'lc_add_ids_to_h2', 20 );

/**
 * Calculate estimated reading time for a post
 * 
 * @param int $post_id Post ID.
 * @return string Reading time string (e.g., '5 min read').
 */
function lc_get_reading_time( $post_id ) {
    $content = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // Assuming 200 words per minute

    return $reading_time . ' min read';
}
