<?php 
/*
Plugin Name: DF Custom Post Types for Petsitter
Plugin URI: http://themeforest.net/user/dan_fisher/portfolio
Description: This plugin creates a custom post types (Portfolio, Slider) for the Petsitter WordPress Theme.
Version: 1.0.0
Author: Dan Fisher
Author URI: http://themeforest.net/user/dan_fisher
Text Domain: df-custom-post-types-petsitter
License: GPLv2
*/

/**
 * Register Portfolio Custom Post Type 
 */
add_action('init', 'petsitter_portfolio_custom_init');  

function petsitter_portfolio_custom_init(){
	
	global $petsitter_data;

	if(isset($petsitter_data['petsitter__opt-portfolio-slug'])){
		$portfolio_slug = $petsitter_data['petsitter__opt-portfolio-slug'];
	} else {
		$portfolio_slug = "portfolio-view";
	}
	
	// Initialize Portfolio Custom Type Labels
	$labels = array(
		'name'               => _x('Portfolio', 'post type general name', 'petsitter'),
		'singular_name'      => _x('Project', 'post type singular name', 'petsitter'),
		'add_new'            => _x('Add New', 'Project', 'petsitter'),
		'add_new_item'       => __('Add New Project', 'petsitter'),
		'edit_item'          => __('Edit Project', 'petsitter'),
		'new_item'           => __('New Project', 'petsitter'),
		'view_item'          => __('View Project', 'petsitter'),
		'search_items'       => __('Search Projects', 'petsitter'),
		'not_found'          => __('No projects found', 'petsitter'),
		'not_found_in_trash' => __('No projects found in Trash', 'petsitter'),
		'parent_item_colon'  => '',
		'menu_name'          => __('Portfolio', 'petsitter'),
	);

	$args = array(
		'labels'        => $labels,
		'public'        => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( "slug" => $portfolio_slug ),
		'menu_icon'     => 'dashicons-format-gallery',
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'comments'
		)
	);
	register_post_type( 'portfolio', $args );

	// Initialize New Categories Labels
	$labels = array(
		'name'              => _x( 'Category', 'category general name', 'petsitter' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'petsitter' ),
		'search_items'      => __( 'Search Category', 'petsitter' ),
		'all_items'         => __( 'All Categories', 'petsitter' ),
		'parent_item'       => __( 'Parent Category', 'petsitter' ),
		'parent_item_colon' => __( 'Parent Category:', 'petsitter' ),
		'edit_item'         => __( 'Edit Category', 'petsitter' ),
		'update_item'       => __( 'Update Category', 'petsitter' ),
		'add_new_item'      => __( 'Add New Category', 'petsitter' ),
		'new_item_name'     => __( 'New Category Name', 'petsitter' ),
	);

	// Custom taxonomy for Project Categories
	register_taxonomy( 'portfolio_category', array('portfolio'), array(
		'hierarchical' => true,
		'public'       => true,
		'labels'       => $labels,
		'show_ui'      => true,
		'query_var'    => true,
		'rewrite'      => array( 
			'slug' => 'portfolio-cat'
		),
	));
}


// If no category selected, post in 'Uncategorized'
if(!function_exists('petsitter_mfields_set_default_object_terms')) {
	function petsitter_mfields_set_default_object_terms( $post_id, $post ) {
	  if ( 'publish' === $post->post_status && $post->post_type === 'portfolio' ) {
	    $defaults = array(
	      'portfolio_category' => array( 'Uncategorized' )
	    );
		  $taxonomies = get_object_taxonomies( $post->post_type );
		  foreach ( (array) $taxonomies as $taxonomy ) {
	      $terms = wp_get_post_terms( $post_id, $taxonomy );
	      if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
	        wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
	      }
	    }
	  }
	}
	add_action( 'save_post', 'petsitter_mfields_set_default_object_terms', 100, 2 );
}





/**
 * Register Slider Custom Post Type 
 */
add_action('init', 'petsitter_slider_custom_init');  

function petsitter_slider_custom_init(){

	
	// Initialize Portfolio Custom Type Labels
	$labels = array(
		'name'               => _x('Slider', 'post type general name', 'petsitter'),
		'singular_name'      => _x('Slide', 'post type singular name', 'petsitter'),
		'add_new'            => _x('Add New', 'Slide', 'petsitter'),
		'add_new_item'       => __('Add New Slide', 'petsitter'),
		'edit_item'          => __('Edit Slide', 'petsitter'),
		'new_item'           => __('New Slide', 'petsitter'),
		'view_item'          => __('View Slide', 'petsitter'),
		'search_items'       => __('Search Slides', 'petsitter'),
		'not_found'          => __('No slides found', 'petsitter'),
		'not_found_in_trash' => __('No slides found in Trash', 'petsitter'),
		'parent_item_colon'  => '',
		'menu_name'          => __('Slider', 'petsitter'),
	);

	$args = array(
		'labels'        => $labels,
		'public'        => true,
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( "slug" => 'slides' ),
		'menu_icon'     => 'dashicons-format-image',
		'supports' => array(
			'title',
			'thumbnail',
			'page-attributes'
		)
	);
	register_post_type( 'slides', $args );
}
