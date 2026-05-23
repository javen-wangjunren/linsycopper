# 📋 Project Scope Card: Linsy Copper

> **One-Liner Goal**: Build a high-performance B2B catalog site for procurement managers and engineers to easily navigate copper products by Shape, Material, or Grade, and request quotes (Get A Quote).

## 🎯 Core Objectives (Success Criteria)
1.  **Industrial Authority**: Visuals must convey "Industrial Material Realism" (Stock, Warehouse, Specs).
2.  **Navigation Clarity**: Users must be able to find products via multiple paths (Shape vs. Material vs. Grade).
3.  **Conversion Focused**: Every product/category page must lead to a "Get A Quote" action.
4.  **Structured Data**: Products are defined by rigorous specs (Grade, Tempers, Dimensions), not just text.

## ✅ In Scope (MVP - Phase 1)
*   **Core Pages**:
    *   [ ] **Home**: Hero + Stock Finder + Core Categories Entry.
    *   [ ] **Primary Category (Level 1)**: Template shared by "By Shape", "By Material", "By Grade". Aggregation page.
    *   [ ] **Secondary Category (Level 2)**: Template shared by specific categories (e.g., "Copper Sheet", "Brass", "Bronze Grades"). Lists specific products/sub-types.
    *   [ ] **Single Product**: Template shared by all leaf products (e.g., "C11000 Sheet", "Brass Tube"). Contains Tabbed Specs, Chemistry, Tolerance.
    *   [ ] **Contact Us**: Quote form & contact info.
    *   [ ] **About Us**: Company history & capability overview.

## 🔜 Phase 2 (Planned)
*   **Content Marketing**: Blog Archive & Single Post.
*   **Services**: Service Archive (CNC, Fabrication) & Single Service Page.
*   **Solutions**: Industry Solutions (Marine, Electrical, etc.).

## ❌ Out of Scope (Explicitly NOT doing in Phase 1)
*   **E-commerce**: No cart, no checkout, no payment gateway.
*   **User Accounts**: No login/registration.
*   **Live Inventory**: No ERP sync (Stock status is manual).
*   **Phase 2 Content**: Blog, Services, and Solutions are NOT in Phase 1 build.

## 🛠️ Tech Constraints & Standards
*   **Stack**: WordPress + GeneratePress Child + Tailwind CSS + ACF Pro.
*   **Editor**: **Classic Editor / ACF Fields ONLY**. Gutenberg Block Editor is DISABLED.
*   **Frontend**: `render.php` via `frontend-dev-architect` skill.
*   **Backend**: Flat ACF structure via `backend-dev-architect` skill.
*   **Design**: "Industrial Material Realism" via `copper-ui-architect` skill.

## 📦 Content Taxonomy Strategy (The Matrix)
*   **Logic**: A product (e.g., "C11000 Copper Sheet") belongs to multiple dimensions:
    *   **Shape**: Copper Sheet
    *   **Material**: Pure Copper
    *   **Grade**: Pure Copper Grades (C10000-C15000)
*   **Implementation**: Use Custom Taxonomies (`product_shape`, `product_material`, `product_grade`) to organize a single CPT (`product`), rather than creating separate CPTs for each.

## 🏁 Definition of Done (DoD)
1.  **Visual**: Matches "Industrial Material Realism" (100px padding, Geist font, Copper interactions).
2.  **Navigation**: Users can traverse from Home -> Shape -> Sheet -> Product seamlessly.
3.  **Data**: Specs are stored in ACF Repeaters (not Textareas).
4.  **Code**: All templates use `get_flat_field` and `_starter_render_block`.
