<?php

/**
 * TGM Init Class
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'starter_plugin_register_required_plugins' );


if ( ! function_exists('starter_plugin_register_required_plugins')) {
	function starter_plugin_register_required_plugins() {

		$plugins = array(
			array(
				'name' 		=> 'Redux Framework',
				'slug' 		=> 'redux-framework',
				'required' 	=> true,
			),
			array(
				'name' 		=> 'Contact Form 7',
				'slug' 		=> 'contact-form-7',
				'required' 	=> true,
			),
			array(
				'name' 		=> 'WP Job Manager',
				'slug' 		=> 'wp-job-manager',
				'required' 	=> true,
			),
			array(
				'name'      => 'DF Shortcodes for Petsitter',
				'slug'      => 'df-shortcodes_petsitter-master',
				'source'    => get_template_directory() . '/inc/plugins/df-shortcodes_petsitter.zip',
				'required'  => true,
				'version'   => '1.4.9'
			),
	    array(
	      'name'         => 'Envato WordPress Toolkit',
	      'slug'         => 'envato-wordpress-toolkit',
	      'required'     => false,
	      'source'       => 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
				'external_url' => 'https://github.com/envato/envato-wordpress-toolkit',
	      'version'      => '1.7.0' // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
	      // 'force_activation'       => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	      // 'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	    ),
			array(
				'name' 		  => 'Easy Custom Sidebars',
				'slug' 		  => 'easy-custom-sidebars',
				'required' 	=> false,
			),
			array(
				'name' 		=> 'Clean Login',
				'slug' 		=> 'clean-login',
				'required' 	=> true,
			),
			array(
				'name' 		=> 'Nav Menu Roles',
				'slug' 		=> 'nav-menu-roles',
				'required' 	=> true,
			),
			array(
				'name'      => 'Reviewer',
				'slug'      => 'reviewer',
				'source'    => get_template_directory() . '/inc/plugins/reviewer.zip',
				'required'  => true,
				'version'   => '3.10.0'
			),
			array(
				'name' 		=> 'Breadcrumb Trail',
				'slug' 		=> 'breadcrumb-trail',
				'required' 	=> true,
			),
			array(
				'name'      => 'DF Custom Post Types for Petsitter',
				'slug'      => 'df-custom-post-types-petsitter',
				'source'    => get_template_directory() . '/inc/plugins/df-custom-post-types-petsitter.zip',
				'required'  => true,
				'version'   => '1.0.0'
			),
			array(
				'name' 		=> 'WP-LESS',
				'slug' 		=> 'wp-less',
				'required' 	=> true,
			),
		);

		$config = array(
			'id'           => 'petsitter__tgmpa',      // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',  // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                    // Automatically activate plugins after installation or not.
			'message'      => '',
		);

		tgmpa( $plugins, $config );

	}
}
