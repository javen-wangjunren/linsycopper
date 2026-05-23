# Taxonomy Hub Page Architecture (Aggregation Page)

This document outlines the architecture for the Taxonomy Aggregation Pages (e.g., `/shape/`, `/material/`). These pages serve as "Hubs" to list all terms within a specific taxonomy.

## 1. Core Logic

*   **Template Type**: Custom Page Template (`page-hub.php`).
*   **Usage**: Assigned to specific Pages (e.g., "Copper Shapes", "Copper Materials").
*   **Dynamic Data**: The page selects a "Target Taxonomy" via ACF, and the template automatically fetches and renders all terms from that taxonomy.

## 2. Module Breakdown

### A. Hero Section (Text Only)
*   **Module**: `template-parts/hub/hero.php`
*   **Design**: Minimalist, Text-only (No background image).
*   **Fields (ACF on Page)**:
    *   `hub_hero_title` (H1)
    *   `hub_hero_desc` (Intro Text)
    *   `hub_hero_cta` (Optional Button)
*   **Breadcrumb**: Static parent structure (Home / Catalog / Page Title).

### B. Taxonomy Grid (Term List)
*   **Module**: `template-parts/hub/grid.php`
*   **Logic**:
    1.  Get `target_taxonomy` from Page ACF.
    2.  `get_terms()` for that taxonomy.
    3.  Loop through terms and render cards.
*   **Card Content**:
    *   **Image**: `hero_image` (Reused from Term Meta `group_taxonomy_hero`).
    *   **Title**: Term Name.
    *   **Desc**: Term Description (Standard WP `description`).
    *   **Link**: `get_term_link()`.
    *   **Exclusions**: No "Best Selling Grade", No "Icon" (as per user request).

### C. Bottom CTA
*   **Module**: `template-parts/hub/cta.php`
*   **Design**: Blue/Gradient Box "Can't Find the Shape You Need?".
*   **Fields (ACF on Page)**:
    *   `hub_cta_title`
    *   `hub_cta_text`
    *   `hub_cta_button_text`
    *   `hub_cta_button_link`

## 3. Data Schema (ACF)

### Page Fields (`group_page_hub`)
Location: Post Template == 'Taxonomy Hub'

| Field Label | Name | Type | Note |
| :--- | :--- | :--- | :--- |
| **Settings** | | Tab | |
| Target Taxonomy | `hub_target_taxonomy` | Select | Options: `product_shape`, `product_material`, `product_grade` |
| **Hero** | | Tab | |
| Title | `hub_hero_title` | Text | Defaults to Page Title if empty |
| Description | `hub_hero_desc` | Textarea | |
| CTA Text | `hub_hero_cta_text` | Text | |
| CTA Link | `hub_hero_cta_link` | URL | |
| **Bottom CTA** | | Tab | |
| CTA Title | `hub_bottom_cta_title` | Text | |
| CTA Desc | `hub_bottom_cta_desc` | Textarea | |

---

## 4. Implementation Plan

1.  **Register Page Template**: Create `page-hub.php`.
2.  **Register ACF**: Create `inc/field/pages/hub.php`.
3.  **Build Modules**: Create `template-parts/hub/` directory and files.
