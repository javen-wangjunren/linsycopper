<?php
/**
 * Template Name: Single Product
 * Description: The template for displaying a single Product CPT.
 * 
 * Logic:
 * This template uses the Modular Block Architecture.
 * Instead of hardcoding HTML here, it calls reusable template parts from template-parts/products/.
 * 
 * Structure:
 * 1. Hero Section (template-parts/products/hero.php)
 * 2. Product Tabs (Description, Specs, etc.)
 * 3. Applications Slider
 * 4. Trust Gallery
 * 5. Consult Form
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// ==========================================
// 1. Product Hero (Render Block)
// ==========================================
// This block handles the main product image, key specs, and CTA buttons.
// Data Source: ACF Group 'group_product_hero' (cloned into CPT)
get_template_part( 'template-parts/cpt/products/hero' );

// ==========================================
// 2. Sticky Navigation
// ==========================================
// Anchor links for Description, Applications, Specs, Manufacturing
get_template_part( 'template-parts/cpt/products/nav' );

// ==========================================
// 3. Product Description (Overview, Features, Sizes)
// ==========================================
// Data Source: ACF Group 'group_product_description' (cloned)
get_template_part( 'template-parts/cpt/products/description' );

// ==========================================
// 4. Product Applications
// ==========================================
// Data Source: ACF Group 'group_product_applications' (cloned)
get_template_part( 'template-parts/cpt/products/applications' );

// ==========================================
// 5. Product Specifications
// ==========================================
// Data Source: ACF Group 'group_product_specifications' (cloned)
get_template_part( 'template-parts/cpt/products/specifications' );

// ==========================================
// 6. Global Module: Why Choose Us
// ==========================================
// Data Source: ACF Options Page (Global Modules)
get_template_part( 'template-parts/global/why-choose-us' );

// ==========================================
// 7. Consult Form
// ==========================================
// Data Source: None (Functional Form)
get_template_part( 'template-parts/global/consult-form' );

// ==========================================
// 8. Placeholder for Future Blocks
// ==========================================
/*
if ( function_exists( '_starter_render_block' ) ) {
	// _starter_render_block( 'blocks/product/applications/render' );
}
*/

get_footer();
