<?php
/**
 * Plugin Name: Reviewer
 * Plugin URI: http://codecanyon.net/item/reviewer-wordpress-plugin/5532349?ref=evoG
 * Description: The Reviewer WordPress Plugin allows you to insert reviews and comparison tables inside your WordPress blog posts in a quick and easy way. The plugin offers 9 customizable themes so that you can adapt your reviews and comparison tables to your need. The plugin support users rating so blog visitors can leave their reviews.
 * Version: 3.10.0
 * Author: Michele Ivani
 * Author URI: http://codecanyon.net/user/evoG?ref=evoG
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Envato Market Extended License | Redistributors 
 * If you are going to redistribute the plugin after purchasing of extended 
 * license you need to disable plugin support features. Just set to true 
 * the following constant.
 *----------------------------------------------------------------------------*/
if ( ! defined( 'RWP_EXTENDED_LICENSE' ) ) {
	define('RWP_EXTENDED_LICENSE', true);
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

if( ! defined( 'RWP_PLUGIN_URL') )
	define( 'RWP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if( ! defined( 'RWP_PLUGIN_PATH' ) )
	define( 'RWP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

if( ! defined( 'RWP_DEMO_MODE' ) )
	define( 'RWP_DEMO_MODE', false );

// Require plugin main class
require_once( plugin_dir_path( __FILE__ ) . 'public/class-reviewer.php' );

// Include plugin API
require_once( plugin_dir_path( __FILE__ ) . 'public/includes/class-api.php' );

// Include admin notice class
require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-notification.php');

require_once( plugin_dir_path( __FILE__ ) . 'public/includes/class-snippets.php');

// Hooks for plugin activation e deactivation
register_activation_hook( __FILE__, array( 'RWP_Reviewer', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'RWP_Reviewer', 'deactivate' ) );

// Require options pages
$includes = array( 'class-admin-page', 'class-preferences-page', 'class-template-manager-page', 'class-meta-box-reviews', 'class-users-ratings-page' );

foreach ($includes as $file)
	include_once( plugin_dir_path( __FILE__ ) . 'admin/includes/'. $file .'.php');

// Include captcha class
require_once( plugin_dir_path( __FILE__ ) . 'public/includes/class-captcha.php' );


// Hook for plugin initialitazion
add_action( 'plugins_loaded', array( 'RWP_Reviewer', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-reviewer-admin.php' );
	add_action( 'plugins_loaded', array( 'RWP_Reviewer_Admin', 'get_instance' ) );
}

// Ajax 
if ( defined( 'DOING_AJAX') && DOING_AJAX ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-reviewer-admin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-meta-box-reviews.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-meta-box-tables.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'public/includes/class-rating.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-admin-page.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-preferences-page.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-main-page.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-reviews-page.php' );
	
	// Meta Boxes
	add_action( 'wp_ajax_rwp_ajax_action_get_review_form', array('RWP_Reviews_Meta_Box', 'ajax_callback'));
	add_action( 'wp_ajax_rwp_ajax_action_get_table_form', array('RWP_Tables_Meta_Box', 'ajax_callback'));

	// Restore Data
	add_action( 'wp_ajax_rwp_ajax_action_restore_data', array('RWP_Preferences_Page', 'ajax_callback'));

	// Delete Template
	add_action( 'wp_ajax_rwp_ajax_action_delete_template', array('RWP_Main_Page', 'ajax_callback'));

	// Duplicate Template
	add_action( 'wp_ajax_rwp_ajax_action_duplicate_template', array('RWP_Main_Page', 'ajax_callback_duplicate'));

	// Reset Score - Delete review
	add_action( 'wp_ajax_rwp_ajax_action_reset_users_score', array('RWP_Reviews_Page', 'ajax_callback'));
	add_action( 'wp_ajax_rwp_ajax_action_delete_review', array('RWP_Reviews_Page', 'ajax_callback_delete_review'));
	
	// Rating actions
	add_action( 'wp_ajax_nopriv_rwp_ajax_action_rating', array('RWP_Rating', 'ajax_callback') );
	add_action( 'wp_ajax_rwp_ajax_action_rating', array('RWP_Rating', 'ajax_callback') );

	// Ratings Manager Actions
	add_action( 'wp_ajax_rwp_ajax_action_ratings_page', array('RWP_Users_Ratings_Page', 'ajax_callback'));
	add_action( 'wp_ajax_rwp_ajax_bulk_action_ratings_page', array('RWP_Users_Ratings_Page', 'ajax_callback_bulk'));

	add_action( 'wp_ajax_nopriv_rwp_ajax_action_like', array('RWP_Rating', 'ajax_callback_like') );
	add_action( 'wp_ajax_rwp_ajax_action_like', array('RWP_Rating', 'ajax_callback_like') );

	// Query users reviews of a box
	add_action( 'wp_ajax_nopriv_rwp_reviews_box_query_users_reviews', array('RWP_User_Review', 'query_users_reviews') );
	add_action( 'wp_ajax_rwp_reviews_box_query_users_reviews', array('RWP_User_Review', 'query_users_reviews') );

	add_action( 'wp_ajax_nopriv_rwp_reviews_box_query_all_users_reviews', array('RWP_User_Review', 'query_all_users_reviews') );
	add_action( 'wp_ajax_rwp_reviews_box_query_all_users_reviews', array('RWP_User_Review', 'query_all_users_reviews') );

	//Captcha
	// add_action( 'wp_ajax_nopriv_rwp_ajax_action_refresh_captcha', array('RWP_Rating', 'refresh_captcha') );
	// add_action( 'wp_ajax_rwp_ajax_action_refresh_captcha', array('RWP_Rating', 'refresh_captcha') );

	// Test Email Notification
	add_action( 'wp_ajax_rwp_ajax_action_demo_notification', array('RWP_Preferences_Page', 'send_demo_notification'));


}



	



