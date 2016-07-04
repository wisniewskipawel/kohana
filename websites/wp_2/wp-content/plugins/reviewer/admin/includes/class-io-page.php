<?php

/**
 * Reviewer Plugin v.2
 * Created by Michele Ivani
 */
class RWP_IO_Page extends RWP_Admin_Page
{
	protected static $instance = null;
	public $io_fields;
	public $option_value;

	public function __construct()
	{
		parent::__construct();

		if( isset( $_GET['rwp_file'] ) )
			$this->download( $_GET['rwp_file'] );

		$this->set_io_fields(); 
		$this->menu_slug = 'reviewer-io-page';
		$this->parent_menu_slug = 'reviewer-main-page';
		$this->option_name = 'rwp_io';
		$this->option_value = RWP_Reviewer::get_option( $this->option_name );
		if (empty($this->option_value))
			add_option( $this->option_name, array() );
		$this->add_menu_page();
		$this->register_page_fields();
		//add_action( 'admin_enqueue_scripts', array( $this, 'localize_script') );
	}

	public function add_menu_page()
	{
		add_submenu_page( $this->parent_menu_slug, __( 'Import / Export', $this->plugin_slug), __( 'Import / Export', $this->plugin_slug), $this->capability, $this->menu_slug, array( $this, 'display_plugin_admin_page' ) );
	} 

	// public function localize_script() 
	// {
	// 	$action_name = 'rwp_ajax_action_restore_data';
	// 	wp_localize_script( $this->plugin_slug . '-admin-script', 'restoreDataObj', array('ajax_nonce' => wp_create_nonce( $action_name ), 'ajax_url' => admin_url('admin-ajax.php'), 'action' => $action_name ) );
	// }


	public function register_page_fields()
	{
		// Add section
		add_settings_section( 'rwp_io_section', '', array( $this, 'display_section'), $this->menu_slug );

		foreach ($this->io_fields as $field_id => $field) {

			add_settings_field( $field_id, $field['title'], array( $this, $field_id . '_cb' ), $this->menu_slug, 'rwp_io_section', array( 'field_id' => $field_id, 'options' => $field['options'] ) );
		}

		register_setting( $this->option_name, $this->option_name, array( $this, 'validate_fields' ) );
	}

	public static function get_instance() 
	{
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function display_section()
	{
		// Do Nothing!
	}

	public function display_plugin_admin_page()
	{	
		?>
		<div class="wrap">
			<h2><?php _e( 'Import / Export', $this->plugin_slug ); ?></h2>
			<p class="description"><?php _e('In this section you can easly import or export all Reviewer Plugin data. The importing process replaces the existing content of Reviewer Plugin, before go ahead make a backup of your WordPress database. The exporting process saves: templates, preferences, reviews, users ratings, comparison tables , support data', 'reviewer'); ?></p>
			<?php settings_errors(); ?>
			<form method="post" action="options.php" enctype="multipart/form-data">
			<!-- <form method="post"> -->
			<?php
				settings_fields( $this->option_name );
				do_settings_sections( $this->menu_slug );
				submit_button( __('Export', $this->plugin_slug), 'primary', 'rwp_io_submit', true, array('data-export' => __('Export', $this->plugin_slug), 'data-import' => __('Import', $this->plugin_slug) ) );
			?>
			</form>

			<?php $this->backup_files(); //RWP_Reviewer::pretty_print(  $this->option_value ); ?>

			<?php //RWP_Reviewer::pretty_print( $this->option_value ); ?>
		</div><!--/wrap-->
		<?php
	}

	public function backup_files() 
	{
		$dir_name = RWP_PLUGIN_PATH.'backup';

		if( !file_exists( $dir_name ) )
			return;

		$files = scandir( $dir_name );

		echo '<h3>'. __('Reviewer Backups' , $this->plugin_slug) .'</h3>';

		echo '<ul class"rwp-backup-files">';

		$check = true;

		foreach ($files as $file) {
			
			if( substr_count( $file, '.json') < 1 )
				continue;

			$check = false;
			
			echo '<li><a href="'. admin_url('admin.php?page='. $this->menu_slug .'&rwp_file='.$file) .'">'. $file .'</a></li>';
		}

		echo '</ul>';

		if( $check )
			echo '<p class="description">'. __('No backup has been done yet' , $this->plugin_slug) .'</p>';
	}

	public function download( $file ) 
	{
		$file_path = RWP_PLUGIN_PATH . 'backup/' . $file;

		if( !file_exists( $file_path ) )
			return;

		// Set headers
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$file");
		header("Content-Type: application/json");
		header("Content-Transfer-Encoding: binary");

		// Read the file from disk
		readfile($file_path);
		exit();
	}

	public function validate_fields( $fields )
	{
		global $wpdb;


		// Validation
		if( !isset( $fields['io_action'] ) ) {
			add_settings_error( $this->option_name, 'rwp-backup-error3', __( 'The form was not submitted correctly!', $this->plugin_slug ), 'error' );
			return $this->option_value;
		}

		$wp_options = array('rwp_templates', 'rwp_preferences', 'rwp_support');
			
		if( $fields['io_action'] == 'rwp_export' ) { // EXPORT

			// - - - IO Process - - -
			
			// Templates, Preferences, Support
			$content = array();

			foreach ($wp_options as $option_key) {
				
				$data = RWP_Reviewer::get_option( $option_key );

				if( empty( $data ) )
					continue;

				$content[ $option_key ] = maybe_serialize( $data );
			}

			// Reviews 
			$post_meta = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'rwp_reviews';", ARRAY_A );

			if( $post_meta ) {

				$reviews = array();

				foreach ($post_meta as $value) {
					
					$reviews[] = array( 'post_id' => $value['post_id'], 'meta_value' => $value['meta_value'] );
				}

				$content['rwp_reviews'] = $reviews;

			}

			// Tables 
			$post_meta = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'rwp_tables';", ARRAY_A );

			if( $post_meta ) {

				$tables = array();

				foreach ($post_meta as $value) {
					
					$tables[] = array( 'post_id' => $value['post_id'], 'meta_value' => $value['meta_value'] );
				}

				$content['rwp_tables'] = $tables;

			}

			// Ratings 
			$post_meta = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key LIKE 'rwp_rating%';", ARRAY_A );

			if( $post_meta ) {

				$ratings = array();

				foreach ($post_meta as $value) {
					
					$ratings[] = array( 'post_id' => $value['post_id'], 'meta_key' => $value['meta_key'], 'meta_value' => $value['meta_value'] );
				}

				$content['rwp_ratings'] = $ratings;

			}

			//RWP_Reviewer::pretty_print( $content ); flush(); die();

			// Creating the file

			$filename = RWP_PLUGIN_PATH.'backup/Reviewer_Plugin_Backup_' . date('Y-m-d_H-i-s') . '.json';

			$fp = fopen( $filename, 'w' );

			if( $fp === false ) { // No privileges to open the file

				add_settings_error( $this->option_name, 'rwp-backup-error1', __( 'Unable to create the backup file. Check you have the privileges to write on reviewer/backup folder', $this->plugin_slug ), 'error' );
				return $this->option_value;
			}

			fputs( $fp, json_encode($content) );

			fclose($fp);

			if(! is_file( $filename ) ) {
				add_settings_error( $this->option_name, 'rwp-backup-error2', __( 'Unable to verify the new backup file.', $this->plugin_slug ), 'error' );
				return $this->option_value;
			} 

			add_settings_error( $this->option_name, 'rwp-backup-ok', __( 'Success! You can dowload your Reviewer backup file from the list down below. You can find all backup file inside the reviewer/backup folder.', $this->plugin_slug ), 'updated' );
			$this->option_value['last_exporting'] = date('Y-m-d H-i-s');
			return $this->option_value;

		} else { // IMPORT

			// Validation
			if( !isset( $_FILES[ $this->option_name ] ) ) {
				add_settings_error( $this->option_name, 'rwp-backup-error5', __( 'Unable upload backup file.', $this->plugin_slug ), 'error' );
				return $this->option_value;
			}

			// Type check
			//if( 'application/json' != $_FILES[ $this->option_name ]['type']['io_file'] ) {
			//	add_settings_error( $this->option_name, 'rwp-backup-error6', __( 'Please upload a json file that contains a backup of Reviewer plugin.', $this->plugin_slug ), 'error' );
			//	return $this->option_value;
			//}

			// Get Data
			$json_file = @file_get_contents( $_FILES[ $this->option_name ]['tmp_name']['io_file'] );
			$data = json_decode( $json_file , true);

			$errors = array();

			// Options
			foreach ($wp_options as $option_key) {
				
				if( !isset( $data[ $option_key ] ) )
					continue;

				//delete_option($option_key);
				$res = update_option( $option_key, maybe_unserialize( $data[ $option_key ] ) );

				$r = get_option( $option_key );
				//RWP_Reviewer::pretty_print( $r );

				// if( !$res )
				// 	$errors[] = sprintf( __('Unable to restore %s option', $this->plugin_slug), $option_key );
			}


			//RWP_Reviewer::pretty_print($_SERVER); flush(); die();

			// Postmeta
			$wp_postmeta = array('rwp_reviews', 'rwp_tables');

			foreach ($wp_postmeta as $meta_key) {
				
				if( !isset( $data[ $meta_key ] ) )
					continue;

				foreach ( $data[ $meta_key ] as $meta) {

					$res = update_post_meta( $meta['post_id'], $meta_key, maybe_unserialize( $meta['meta_value'] ) );

					// if( $res !== false )
					// 	$errors[] = sprintf( __('Unable to restore %s post_meta', $this->plugin_slug), $meta_key );
				}
			}

			// Ratings

			$meta_key = 'rwp_ratings';

			if( isset( $data[ $meta_key ] ) ) {

				foreach ( $data[ $meta_key ] as $key => $meta) {

					$unique = ($meta['meta_key'] == 'rwp_rating_blacklist') ? true : false;
					$res = add_post_meta( $meta['post_id'], $meta['meta_key'], maybe_unserialize( $meta['meta_value'] ), $unique );
				}

				if( !empty( $errors ) ) {
					add_settings_error( $this->option_name, 'rwp-backup-error7', implode( '<br/>', $errors ), 'update-nag' );
				} else {
					add_settings_error( $this->option_name, 'rwp-backup-import-ok', __( 'The backup was successfully imported.', $this->plugin_slug ), 'updated' );
				}
			} 

			//RWP_Reviewer::pretty_print( $errors ); flush(); die();

			$this->option_value['last_importing'] = date('Y-m-d H-i-s');
			return $this->option_value;			
		}
	}

	public function set_io_fields()
	{
		$this->io_fields = array(
		
			'io_action' => array(
				'title' 	=> __( 'Action', $this->plugin_slug ),
				'options' 	=> array(
					'rwp_export' => __( 'Export', $this->plugin_slug ),
					'rwp_import' => __( 'Import', $this->plugin_slug ),
				),
				'default'	=> 'rwp_export'
			)
		);
	}

/*----------------------------------------------------------------------------*
 * Callbacks for form fields
 *----------------------------------------------------------------------------*/

	public function io_action_cb( $args )
	{
		extract( $args );

		echo '<select id="rwp-' . $field_id . '" name="'. $this->option_name .'[' . $field_id . ']" data-fname="'. $this->option_name .'[io_file]" >';

			foreach ($options as $key => $value)
				echo '<option value="'.$key.'">'.$value.'</option>';

		echo '</select>';

	}
}
