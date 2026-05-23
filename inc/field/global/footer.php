<?php
/**
 * Footer Settings Field Group
 * Location: Global Settings > Footer
 * 
 * Defines fields for:
 * 1. Branding (Logo, Desc, Social)
 * 2. Menu Titles (Products, Company)
 * 3. Contact Info (Address, Phone, Email)
 * 4. Copyright
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'    => 'group_global_footer_settings',
		'title'  => 'Footer Settings',
		'fields' => array(
			// 1. Branding Section (Logo, Desc, Social)
			array(
				'key' => 'field_footer_tab_branding',
				'label' => 'Branding',
				'type' => 'tab',
			),
			array(
				'key' => 'field_footer_brand_info',
				'label' => 'Brand Information',
				'name' => 'footer_brand_info',
				'type' => 'group',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_footer_brand_logo',
						'label' => 'Logo Image',
						'name' => 'logo_image',
						'type' => 'image',
						'return_format' => 'id', // Use ID for wp_get_attachment_image
						'preview_size' => 'medium',
						'instructions' => 'If empty, will use Site Title text.',
					),
					array(
						'key' => 'field_footer_brand_desc',
						'label' => 'Description',
						'name' => 'description',
						'type' => 'textarea',
						'rows' => 3,
						'default_value' => 'Leading supplier of copper, brass, and bronze alloys. Serving aerospace, marine, and industrial markets globally since 1998.',
					),
					array(
						'key' => 'field_footer_social_linkedin',
						'label' => 'LinkedIn URL',
						'name' => 'social_linkedin',
						'type' => 'url',
						'placeholder' => 'https://linkedin.com/company/...',
					),
				),
			),

			// 2. Menu Titles Section
			array(
				'key' => 'field_footer_tab_menus',
				'label' => 'Menu Titles',
				'type' => 'tab',
			),
			array(
				'key' => 'field_footer_menu_products_title',
				'label' => 'Products Column Title',
				'name' => 'footer_menu_products_title',
				'type' => 'text',
				'default_value' => 'Products',
				'instructions' => 'Manage the links in Appearance > Menus (Location: Footer - Products).',
			),
			array(
				'key' => 'field_footer_menu_company_title',
				'label' => 'Company Column Title',
				'name' => 'footer_menu_company_title',
				'type' => 'text',
				'default_value' => 'Company',
				'instructions' => 'Manage the links in Appearance > Menus (Location: Footer - Company).',
			),

			// 3. Contact Section (Address, Phone, Email)
			array(
				'key' => 'field_footer_tab_contact',
				'label' => 'Contact Info',
				'type' => 'tab',
			),
			array(
				'key' => 'field_footer_contact_list',
				'label' => 'Contact Details',
				'name' => 'footer_contact_list',
				'type' => 'repeater',
				'layout' => 'row', // Row layout for compact view
				'button_label' => 'Add Contact Item',
				'sub_fields' => array(
					array(
						'key' => 'field_footer_contact_label',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
						'placeholder' => 'Phone / Email / Address',
						'wrapper' => array('width' => '20'),
					),
					array(
						'key' => 'field_footer_contact_content',
						'label' => 'Content',
						'name' => 'content',
						'type' => 'textarea', // Textarea for multi-line address
						'rows' => 2,
						'new_lines' => 'br', // Auto-convert newlines
						'wrapper' => array('width' => '40'),
					),
					array(
						'key' => 'field_footer_contact_icon',
						'label' => 'Icon SVG',
						'name' => 'icon_svg',
						'type' => 'textarea',
						'rows' => 2,
						'instructions' => 'Paste raw SVG code (width/height removed).',
						'wrapper' => array('width' => '40'),
					),
					array(
						'key' => 'field_footer_contact_link',
						'label' => 'Link (Optional)',
						'name' => 'link_url',
						'type' => 'text', // Text to support tel: and mailto:
						'placeholder' => 'tel:+123... or mailto:sales@...',
						'instructions' => 'Leave empty for non-clickable items (like Address).',
						'wrapper' => array('width' => '100'),
					),
				),
			),

			// 4. Copyright Section
			array(
				'key' => 'field_footer_tab_copyright',
				'label' => 'Copyright',
				'type' => 'tab',
			),
			array(
				'key' => 'field_footer_copyright_text',
				'label' => 'Copyright Text',
				'name' => 'footer_copyright_text',
				'type' => 'text',
				'default_value' => '© {year} CopperCorp Inc. All rights reserved.',
				'instructions' => 'Use {year} placeholder for dynamic current year.',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-footer-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
	) );
}
