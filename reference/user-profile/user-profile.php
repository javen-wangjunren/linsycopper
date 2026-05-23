<?php
if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_user_extra_profile',
			'title'                 => 'User Profile: Professional Info',
			'fields'                => array(
				array(
					'key'               => 'field_user_profile_picture',
					'label'             => 'Profile Picture',
					'name'              => 'user_profile_picture',
					'type'              => 'image',
					'instructions'      => 'Upload a profile photo for the author card.',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '50',
						'class' => '',
						'id'    => '',
					),
					'return_format'      => 'id',
					'preview_size'       => 'medium',
					'library'            => 'all',
				),
				array(
					'key'               => 'field_user_job_title',
					'label'             => 'Job Title',
					'name'              => 'user_job_title',
					'type'              => 'text',
					'instructions'      => 'e.g., Lead Engineer, Material Scientist',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '50',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_user_linkedin',
					'label'             => 'LinkedIn URL',
					'name'              => 'user_linkedin',
					'type'              => 'url',
					'instructions'      => 'Full URL to LinkedIn profile.',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '50',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => 'https://linkedin.com/in/...',
				),
				array(
					'key'               => 'field_user_bio',
					'label'             => 'Bio',
					'name'              => 'user_bio',
					'type'              => 'textarea',
					'instructions'      => 'Short bio shown in the author card.',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '100',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'maxlength'         => '',
					'rows'              => 4,
					'new_lines'         => 'wpautop',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'user_form',
						'operator' => '==',
						'value'    => 'all', // Show on all user profile edit screens
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => 'Extra fields for blog author display.',
		)
	);

endif;
