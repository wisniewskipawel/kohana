<?php

/**
 * Reviewer Plugin v.2
 * Created by Michele Ivani
 */
class RWP_Admin_Page
{
	// Instance of this class
	protected static $instance = null;

	// Slug of the plugin screen
	protected $plugin_slug = null;

	// Page fields
	protected $capability = 'manage_options';
	protected $menu_slug = '';
	protected $icon_url = 'dashicons-chart-line';

	function __construct()
	{
		// Call $plugin_slug from public plugin class
		$this->plugin_slug = 'reviewer';
	}
	public static function get_instance() 
	{
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}