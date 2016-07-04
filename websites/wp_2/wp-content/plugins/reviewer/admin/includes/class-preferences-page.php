<?php

/**
 * Reviewer Plugin v.2
 * Created by Michele Ivani
 */
class RWP_Preferences_Page extends RWP_Admin_Page
{
	protected static $instance = null;
	public $preferences_fields;
	public $option_value;
	private $to_inf = 5000;

	public function __construct()
	{
		parent::__construct();

		$this->preferences_fields = RWP_Preferences_Page::get_preferences_fields(); 
		$this->menu_slug = 'reviewer-preferences-page';
		$this->parent_menu_slug = 'reviewer-main-page';
		$this->option_name = 'rwp_preferences';
		$this->option_value = RWP_Reviewer::get_option( $this->option_name );
		$this->add_menu_page();
		$this->register_page_fields();
		add_action( 'admin_enqueue_scripts', array( $this, 'localize_script') );
	}

	public function add_menu_page()
	{
		add_submenu_page( $this->parent_menu_slug, __( 'Preferences', $this->plugin_slug), __( 'Preferences', $this->plugin_slug), $this->capability, $this->menu_slug, array( $this, 'display_plugin_admin_page' ) );
	} 

	public function localize_script() 
	{
		$action_name = 'rwp_ajax_action_restore_data';
		wp_localize_script( $this->plugin_slug . '-admin-script', 'restoreDataObj', array('ajax_nonce' => wp_create_nonce( $action_name ), 'ajax_url' => admin_url('admin-ajax.php'), 'action' => $action_name ) );
		
		$action_name = 'rwp_ajax_action_demo_notification';
		wp_localize_script( $this->plugin_slug . '-admin-script', 'demoNotificationDataObj', array('ajax_nonce' => wp_create_nonce( $action_name ), 'ajax_url' => admin_url('admin-ajax.php'), 'action' => $action_name ) );
	
	}

	public static function send_demo_notification()
	{
		$res = array( 'code' => 400, 'data'=> array( 'msg' => __( 'Unable to send email notification. Check your Mail settings', 'reviewer' ) ) );

		// Validation
		if( !isset( $_POST['email'] ) || !is_email( $_POST['email'] ) ) {

			$res['data']['msg'] = __( 'Type a valid email address', 'reviewer' );
			die( json_encode( $res ) );
		}

		 //Get rid of wwww
		$domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);
		
		//add_filter( 'wp_mail_content_type', array('RWP_Reviewer', 'set_html_content_type') );

		$to 		= $_POST['email'];
		$subject	= '[RWP] Notification';
		$headers	= array('From: Reviewer Plugin <do-not-reply@'.$domain_name);

		$eol		= "\r\n";

		$message 	 = "Reviewer Wordpress Plugin" . $eol;
		$message    .= "--------------------------------------" . $eol . $eol;
		$message    .= "Congratulation! Your email server is configured correctly." . $eol;
		$message    .= "You will ricevie an email notification when new users reviews will be submitted to your site." . $eol . $eol;
		$message    .= "If you have any issues about the Reviewer Plugin, follow the Support rules written inside documentation." . $eol . $eol;
		$message    .= "Reviewer Team". $eol;

		$message = wordwrap( $message, 70, $eol );

		// ob_start();
		// include 'email-template.php';
		// $message = ob_get_clean();
			
		$sending = wp_mail( $to, $subject, $message, $headers );
		
		//remove_filter( 'wp_mail_content_type', array('RWP_Reviewer', 'set_html_content_type') );

		if( $sending ) {
			$res['code'] = 200;
			$res['data']['msg'] = __( 'Email sent. Check your Mail Inbox or Spam folder', 'reviewer' );
		}

		die( json_encode( $res ) );
	}

	public static function ajax_callback()
	{
		$restore_value =  RWP_Reviewer::get_option( 'rwp_restore' );
		if ( ! empty( $restore_value ) ) 
			die( json_encode( array('msg' => __( 'Data already restored', 'reviewer') ) ) );

		// - - - Templates - - -
		$previous_templates =  RWP_Reviewer::get_option( 'rwp_reviewer_templates' );
		$templates = RWP_Reviewer::get_option( 'rwp_templates' ); 

		foreach ($previous_templates as $t) {
			$temp = array();

			$temp['template_id'] = $t['template_id'];
			$temp['template_name'] = $t['template_title'];
			$temp['template_minimum_score'] = $t['template_items_rage']['min'];
			$temp['template_maximum_score'] = $t['template_items_rage']['max'];
			$temp['template_score_percentages'] = '30-69';

			foreach ($t['template_items'] as $criterion) 
				$temp['template_criterias'][] = $criterion['label'];

			switch ($t['template_theme']) {
				case 'rwp_bars_theme':
					$theme = 'rwp-theme-1';
					break;

				case 'rwp_bars_mini_theme':
					$theme = 'rwp-theme-5';
					break;

				case 'rwp_stars_theme':
					$theme = 'rwp-theme-2';
					break;

				case 'rwp_stars_mini_theme':
					$theme = 'rwp-theme-6';
					break;

				case 'rwp_circles_theme':
					$theme = 'rwp-theme-3';
					break;

				case 'rwp_big_circles_theme':
					$theme = 'rwp-theme-7';
					break;
				
				default:
					$theme = 'rwp-theme-1';
					break;
			}

			$temp['template_theme'] = $theme;
			$temp['template_text_color'] = $t['template_text_color'];
			$temp['template_total_score_box_color'] = $t['template_total_score_color_box'];
			$temp['template_users_score_box_color'] = '#566473';
			$temp['template_high_score_color'] = $t['template_scores_colors']['high_score'];
			$temp['template_medium_score_color'] = $t['template_scores_colors']['medium_score'];
			$temp['template_low_score_color'] = $t['template_scores_colors']['low_score'];
			$temp['template_pros_label_color'] = $t['template_pros_settings']['label_color'];
			$temp['template_pros_label_font_size'] = $t['template_pros_settings']['label_size'];
			$temp['template_pros_text_font_size'] = $t['template_pros_settings']['text_size'];
			$temp['template_cons_label_color'] = $t['template_cons_settings']['label_color'];
			$temp['template_cons_label_font_size'] = $t['template_cons_settings']['label_size'];
			$temp['template_cons_text_font_size'] = $t['template_cons_settings']['text_size'];
			$temp['template_total_score_label'] = $t['template_total_score_label'];
			$temp['template_users_score_label'] = 'Users Score';
			$temp['template_pros_label'] = $t['template_pros_settings']['label'];
			$temp['template_cons_label'] = $t['template_cons_settings']['label'];
			$temp['template_message_to_rate'] = 'Leave your rating';
			$temp['template_message_to_rate_login'] = 'Login to rate';
			$temp['template_success_message'] = 'Thank you for your rating';
			$temp['template_failure_message'] = 'Error during rate process';
			$temp['template_rate_image'] = RWP_PLUGIN_URL . 'public/assets/images/rating-star.png';

			$templates[ $temp['template_id'] ] = $temp;
		}

		// Save new templates
		$res = update_option('rwp_templates', $templates);

		// - - - Reviews - - -
		global $wpdb;

		// Get posts ids that contain reviews
		$post_meta = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'rwp_reviews';", ARRAY_A );
		$posts = array();
		foreach ($post_meta as $p) 
			$posts[] = $p['post_id'];

		// Loop all posts
		foreach ($posts as $post_id) {
		 	
		 	$revs = array();

		 	// Get post reviews
		 	$reviews = get_post_meta( $post_id, 'rwp_reviews', true );

		 	if ( !empty( $reviews ) ) { // Check if there are reviews

		 		// Store old reviews 
		 		update_post_meta( $post_id, 'rwp_old_reviews', $reviews );

		 		// Loop all reviews 
		 		foreach ($reviews as $review) {

		 			$review_id = $review['review_id'];
		 			$revs[ $review_id ]['review_id'] = $review['review_id'];
		 			$revs[ $review_id ]['review_title'] = $review['review_title'];
		 			$revs[ $review_id ]['review_template'] = $review['review_template'];
		 			$revs[ $review_id ]['review_scores'] = $review['review_items'];
		 			$revs[ $review_id ]['review_pros'] = $review['review_good_stuff'];
		 			$revs[ $review_id ]['review_cons'] = $review['review_bad_stuff'];
		 		}
		 		
		 		// Save updated reviews
		 		update_post_meta( $post_id, 'rwp_reviews', $revs );
		 	}
		 } 

		update_option('rwp_restore', 1);

		die( json_encode( array('msg' => __( 'Restore completed', 'reviewer') ) ) );
	}

	public function display_plugin_admin_page()
	{
		?>
		<div class="wrap">
			<h2><?php _e( 'Preferences', $this->plugin_slug ); ?></h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php" id="rwp-pref-form">
			<?php
				settings_fields( $this->option_name );
				do_settings_sections( $this->menu_slug );
				submit_button();
			?>
			</form>

			<!-- <hr/>
			<h3>Restore Data</h3>
			<p class="desctiprion"><?php _e('Important: if you already used a previous version of Reviewer Plugin please click the button below to restore the compatibility with the new version. Plaese backup your blog database before restoring data.', $this->plugin_slug); ?></p>
			<input id="rwp-restore-data-btn" type="button" class="button" value="<?php _e('Restore Data', $this->plugin_slug); ?>" data-confirm-msg="<?php _e('Do you want to continue?', $this->plugin_slug); ?>">
			<img class="rwp-loader rwp-restore" src="<?php echo admin_url(); ?>images/spinner.gif" alt="loading" />

			<div id="rwp-restore-data-notification" class="updated settings-error"> 
				<p><strong></strong></p>
			</div> -->

			<?php //RWP_Reviewer::pretty_print(  $this->option_value ); ?>
		</div><!--/wrap-->
		<?php
	}

	public function register_page_fields()
	{
		// Add sections
		$sections = array( 'rwp_preferences_users_rating_section' => __( 'Users Ratings', $this->plugin_slug), 'rwp_preferences_global_section' => __( 'Global', $this->plugin_slug), );

		foreach ( $sections as $section_id => $section_title )	
			add_settings_section( $section_id, $section_title, array( $this, 'display_section'), $this->menu_slug );

		// Add Fields
		foreach ($this->preferences_fields as $field_id => $field) {

			// Get selected value for the field
			$selected = ( isset( $this->option_value[ $field_id ] ) && ! empty( $this->option_value[ $field_id ] ) ) ? $this->option_value[ $field_id ] : $this->preferences_fields[ $field_id ]['default'];

			add_settings_field( $field_id, $field['title'], array( $this, $field_id . '_cb' ), $this->menu_slug, $field['section'], array( 'field_id' => $field_id, 'selected' => $selected, 'default' => $field['default'] ) );
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

	public function validate_fields( $fields )
	{
		$valids = array();

		//RWP_Reviewer::pretty_print($fields); //flush(); die();

		foreach ($this->preferences_fields as $field_id => $field) {

			$default = $this->preferences_fields[ $field_id ]['default'];

			if( $field_id != 'preferences_rating_allow_zero' && ! isset( $fields[ $field_id ] ) ) { // The field is not set

				$valids[ $field_id ] = $default;
				continue;
			}

			switch ( $field_id ) {

				case 'preferences_users_reviews_per_page':
					$num =  intval( $fields[ $field_id ] );
					$valids[ $field_id ] = ( $num >= 1 && $num <= 50 ) ? $num : $default;
					break;

				case 'preferences_rating_title_limits':
				case 'preferences_rating_comment_limits':

					if( is_array( $fields[ $field_id ] ) && isset( $fields[ $field_id ]['min'] ) && isset( $fields[ $field_id ]['max'] ) ) {

						$min = ( is_numeric( $fields[ $field_id ]['min'] ) ) ? intval( $fields[ $field_id ]['min'] ) : 0;
						$max = ( is_numeric( $fields[ $field_id ]['max'] ) ) ? intval( $fields[ $field_id ]['max'] ) : 99999;

						if( $min <= $max ) {

							$max = ( $max > $this->to_inf ) ? 'inf' : $max;
							$min = ( $min < 0 ) ? 0 : $min;

							$valids[ $field_id ] = $min .'-'. $max;

						} else {
							$valids[ $field_id ] = $default;
						}
						
					} else {
						$valids[ $field_id ] = $default;
					}
					break;


				case 'preferences_notification_email':

					$email = trim( $fields[ $field_id ] );
					if( empty( $email ) && intval( $valids['preferences_notification'] ) <= 0 ) {
						$valids[ $field_id ] = '';
						break;
					}

					if ( ! is_email( $email ) ) {

						add_settings_error( $this->option_name, 'rwp-pref-notification', __( 'Please, type a valid email address', $this->plugin_slug), 'update-nag' );
						$valids[ $field_id ] = $default;
						break;
					} 

					$valids[ $field_id ] = $fields[ $field_id ];
					break;

				case 'preferences_rating_allow_zero':
				case 'preferences_users_reviews_human_date_format':
				case 'preferences_sameas':

					if ( isset( $fields[ $field_id ] ) ) {
						$valids[ $field_id ] = 'yes';
					} else {
						$valids[ $field_id ] = 'no';
					}
					break;

				case 'preferences_users_reviews_captcha': 

					if ( !isset( $fields[ $field_id ] ) || !is_array( $fields[ $field_id ] ) ) {
						$valids[ $field_id ] = $default;
						break;
					}

					$value = $fields[ $field_id ];
				    $enabled    = isset( $value['enabled'] ) ? true : false;
			        $site_key   = isset( $value['site_key'] ) ? trim( $value['site_key'] ) : '';
			        $secret_key = isset( $value['secret_key'] ) ? trim( $value['secret_key'] ) : '';
			        $site_key   = esc_sql( esc_html( $site_key ) );
			        $secret_key = esc_sql( esc_html( $secret_key ) );

			        if( $enabled && ( empty( $site_key ) ||  empty( $secret_key ) ) ) {
						add_settings_error( $this->option_name, 'rwp-pref-captcha', __( 'Site key and secret key must be filled', $this->plugin_slug), 'update-nag' );
			            $valids[ $field_id ] = $default;
			            break;
			        }

			        $valids[ $field_id ] =  array(
			            'enabled'       => $enabled,
			            'site_key'      => $site_key,
			            'secret_key'    => $secret_key,
			        );
					break;

				case 'preferences_custom_login_link' : 

					$custom_link = trim( $fields[ $field_id ] ); 
					if( empty( $custom_link ) ) {
						$valids[ $field_id ] = '';
						break;
					}

					if (filter_var( $fields[ $field_id ], FILTER_VALIDATE_URL) === FALSE ) {
					    $valids[ $field_id ] = $default;
						add_settings_error( $this->option_name, 'rwp-pref-custom-url', __( 'Invalid URL for the custom login link', $this->plugin_slug), 'update-nag' );
					} else {
						$valids[ $field_id ] = $fields[ $field_id ];
					}
					break;
	
				default:

					if( is_array( $fields[ $field_id ] ) ) {
						foreach ( $fields[ $field_id ] as $post_type) 
							$valids[ $field_id ][] = esc_sql( esc_html( $post_type ) ); 
					}
					else {
						$valids[ $field_id ] = wp_kses( $fields[ $field_id ], array() ); 
					}
					break;
			}
		}

		//RWP_Reviewer::pretty_print($valids); flush(); die();

		return $valids;
	}

	public static function get_preferences_fields()
	{
		$plugin_slug = 'reviewer';
		 return array(
		
			'preferences_authorization' => array(
				'title' 	=> __( 'Rating Authorization', $plugin_slug ), 
				'options' 	=> array(
					'all' 		=> __( 'All Users', $plugin_slug ),
					'logged_in' => __( 'Logged in Users only', $plugin_slug ),
					'disabled'	=> __( 'Disabled', $plugin_slug )
				),
				'default'	=> 'all',
				'section' 	=> 'rwp_preferences_users_rating_section',
			),

			'preferences_rating_mode' => array(
				'title' 	=> __( 'Rating Mode', $plugin_slug ), 
				'options' 	=> array(
					'five_stars' 		=> __( '5 Stars Rating', $plugin_slug ),
					'full'		 		=> __( 'Single Criterion Rating with sliders', $plugin_slug ),
					'full_five_stars' 	=> __( 'Single Criterion Rating with stars', $plugin_slug ),
				),
				'default'	=> 'five_stars',
				'section' 	=> 'rwp_preferences_users_rating_section',
			),

			'preferences_rating_before_appears' => array(
				'title' 	=> __( 'Before a rating appears', $plugin_slug ), 
				'options' 	=> array(
					'nothing' 	=> __( 'Rating does not need moderation', $plugin_slug ),
					'pending'	=> __( 'Rating must be manually approved', $plugin_slug ),
				),
				'default'	=> 'nothing',
				'section' 	=> 'rwp_preferences_users_rating_section',
			),

			'preferences_rating_title_limits' => array(
				'title' 		=> __( 'User Review Title Limits', $plugin_slug ), 
				'default'		=> '0-inf',
				'description' 	=> __( 'Defines the minimum and maximum number of characters for User Review Title', $plugin_slug ),
				'section' 		=> 'rwp_preferences_users_rating_section',
			),

			'preferences_rating_comment_limits' => array(
				'title' 		=> __( 'User Review Comment Limits', $plugin_slug ), 
				'default'		=> '0-inf',
				'description' 	=> __( 'Defines the minimum and maximum number of characters for User Review Comment', $plugin_slug ),
				'section' 		=> 'rwp_preferences_users_rating_section',
			),

			'preferences_users_reviews_per_page' => array(
				'title' 		=> __( 'Users Reviews to show', $plugin_slug ), 
				'default'		=> 3,
				'description' 	=> __( 'Define the number of users reviews to show per page inside the reviews box', $plugin_slug ),
				'section' 		=> 'rwp_preferences_users_rating_section',
			),

			'preferences_rating_allow_zero' => array(
				'title' 		=> __( 'Allow zero score in users rating', $plugin_slug ), 
				'default'		=> 'yes',
				'description' 	=> __( 'By checking the checkbox the score with zero value will be allowed inside user rating', $plugin_slug ),
				'section' 		=> 'rwp_preferences_users_rating_section',
			),

			'preferences_sharing_networks' => array(
				'title' 		=> __( 'Users Reviews Sharing', $plugin_slug ), 
				'description' 	=> __( 'Share user review via the follwing networks', $plugin_slug ), 
				'default'	=> array( 'facebook', 'twitter', 'google', 'email', 'link' ),
				'options' 	=> array(  
					'facebook' 	=> __( 'Facebook', $plugin_slug ), 
					'twitter' 	=> __( 'Twitter', $plugin_slug ), 
					'google' 	=> __( 'Google+', $plugin_slug ), 
					'email' 	=> __( 'Email', $plugin_slug ), 
					'link' 		=> __( 'Standard Link', $plugin_slug ), 
				),
				'section' 	=> 'rwp_preferences_users_rating_section',
			),

			'preferences_users_reviews_captcha' => array(
                'title'         => __( 'Users Reviews Captcha', $plugin_slug ), 
                'description'   => __( 'Enable Google reCaptcha (Secure Code) for users reviews', $plugin_slug ),
                'default'       => array(  
                    'enabled'    => false,
                    'site_key'   => '',
                    'secret_key' => '',
                ),
                'section'       => 'rwp_preferences_users_rating_section',
                'type'          => 'captcha',
            ),

			'preferences_step' => array(
				'title' 	=> __( 'Scores Step', $plugin_slug ), 
				'options' 	=> array( 1, .5, .1, .05, .01 ),
				'default'	=> 0.5,
				'section' 	=> 'rwp_preferences_global_section',
			),

			'preferences_nofollow' => array(
				'title' 	=> __( 'Nofollow Attribute', $plugin_slug ), 
				'options' 	=> array(  
					'box_image' 		=> __( 'Reviews Box Image Link', $plugin_slug ),
					'box_custom_links' 	=> __( 'Reviews Box Custom Links', $plugin_slug ),
				),
				'default'	=> array(),
                'description'   => sprintf(__( 'Add the %s attribute to the following links of reviews box', $plugin_slug ), '<em>rel="nofollow"</em>'),
				'section' 	=> 'rwp_preferences_global_section',
			),

			'preferences_sameas' => array(
				'title' 		=> __( 'Enable "sameAs" property', $plugin_slug ), 
				'default'		=> 'no',
				'description' 	=> __( 'By checking the checkbox the plugin will add the "sameAs" property to Google Rich Snippets', $plugin_slug ),
				'section' 		=> 'rwp_preferences_global_section',
			),

			'preferences_post_types' => array(
				'title' 	=> __( 'Enable Reviewer Plugin inside following Post Types', $plugin_slug ), 
				'default'	=> array( 'post' ),
				'section' 	=> 'rwp_preferences_global_section',
			),

			'preferences_custom_login_link' => array(
				'title' 		=> __( 'Custom Login URL', $plugin_slug ), 
				'default'		=> '',
				'description' 	=> __( 'Define the custom login url for reviews boxes', $plugin_slug ),
				'section' 		=> 'rwp_preferences_global_section',
			),

			'preferences_custom_css' => array(
				'title' 		=> __( 'Custom CSS Rules', $plugin_slug ), 
				'default'		=> '',
				'section' 		=> 'rwp_preferences_global_section',
				'description' 	=> __( 'You can define CSS rules for customizing the Reviewer plugin layout', $plugin_slug ), 
			),

			'preferences_notification' => array(
				'title' 	=> __( 'E-mail me whenever', $plugin_slug ), 
				'options' 	=> array(
					'1'		=> __( 'Anyone posts a rating', $plugin_slug ),
					'3'		=> __( '3 ratings have been posted', $plugin_slug ),
					'5'		=> __( '5 ratings have been posted', $plugin_slug ),
					'10'	=> __( '10 ratings have been posted', $plugin_slug ),
					'50'	=> __( '50 ratings have been posted', $plugin_slug ),
					'0' 	=> __( 'No, thanks. I don\'t want to receive notifications', $plugin_slug ),
				),
				'default'	=> '0',
				'section' 	=> 'rwp_preferences_users_rating_section',
			),

			'preferences_notification_email' => array(
				'title' 	=> __( 'Send notification to', $plugin_slug ),
				'default'	=> '',
				'section' 	=> 'rwp_preferences_users_rating_section',
				'description' 	=> __( 'Insert a valid e-mail address to send the notification about new users ratings. Just for testing... Press the button below to receive a demo notification. If the email is not in inbox, check the Spam folder', $plugin_slug ), 

			),

			'preferences_users_reviews_human_date_format' => array(
				'title' 		=> __( 'Format user review date', $plugin_slug ), 
				'default'		=> 'no',
				'description' 	=> __( 'By checking the checkbox the user review date will be converted in a human readable format, such as "1 hour ago", "5 mins ago", "2 days ago"', $plugin_slug ),
				'section' 		=> 'rwp_preferences_users_rating_section',
			),
		);
	}

/*----------------------------------------------------------------------------*
 * Callbacks for form fields
 *----------------------------------------------------------------------------*/

	public function preferences_authorization_cb( $args )
	{
		extract( $args );

		echo '<ul class="rwp-options-ul">';

		foreach ($this->preferences_fields['preferences_authorization']['options'] as $option_id => $option_title) {
			
			$ck = ( $selected == $option_id ) ? 'checked' : '';

			echo '<li><input type="radio" name="'. $this->option_name .'[' . $field_id . ']" value="' . $option_id . '" '. $ck .' /> <label>' . $option_title . '</label></li>';
		}

		echo '</ul>';
	}


	public function preferences_rating_mode_cb( $args )
	{
		extract( $args );

		echo '<ul class="rwp-options-ul">';

		foreach ($this->preferences_fields['preferences_rating_mode']['options'] as $option_id => $option_title) {

			$ck = ( $selected == $option_id ) ? 'checked' : '';
			
			echo '<li><input type="radio" name="'. $this->option_name .'[' . $field_id . ']" value="' . $option_id . '" '. $ck .' /> <label>' . $option_title . '</label></li>';
		}

		echo '</ul>';
	}

	public function preferences_rating_before_appears_cb( $args )
	{
		extract( $args );

		echo '<ul class="rwp-options-ul">';

		foreach ($this->preferences_fields['preferences_rating_before_appears']['options'] as $option_id => $option_title) {

			$ck = ( $selected == $option_id ) ? 'checked' : '';
			
			echo '<li><input type="radio" name="'. $this->option_name .'[' . $field_id . ']" value="' . $option_id . '" '. $ck .' /> <label>' . $option_title . '</label></li>';
		}

		echo '</ul>';
	}

	public function preferences_step_cb( $args )
	{
		extract( $args );

		echo '<ul class="rwp-options-ul">';

		foreach ($this->preferences_fields['preferences_step']['options'] as $option_id => $option_value) {

			$ck = ( $selected == $option_value ) ? 'checked' : '';
			
			echo '<li><input type="radio" name="'. $this->option_name .'[' . $field_id . ']" value="' . $option_value . '" '. $ck .' /> <label>' . $option_value . '</label></li>';
		}

		echo '</ul>';
	}

	public function preferences_post_types_cb( $args )
	{
		extract( $args );

		$post_types = get_post_types();

		echo '<ul class="rwp-post-type-ul">';

		foreach ($post_types as $type) {
			
			$ck = ( in_array( $type, $selected ) ) ? 'checked' : '';
			$post_type = get_post_type_object( $type );
            $label   = $post_type->labels->name;

			echo '<li><input type="checkbox" name="'. $this->option_name .'[' . $field_id . '][]" value="' . $type . '" '. $ck .' /> <label>'. $label . ' - <em style="color:#666">' . $type . '</em></label></li>';
		}		

		echo '</ul>';
	}

	public function preferences_nofollow_cb( $args )
	{
		extract( $args );

		$links = $this->preferences_fields[ $field_id ]['options'];

		echo '<p>'. $this->preferences_fields[ $field_id ]['description'] .'</p>';
		echo '<ul class="rwp-post-type-ul">';
		foreach ($links as $key => $name) {
			$ck = ( in_array( $key, $selected ) ) ? 'checked' : '';

			echo '<li><input type="checkbox" name="'. $this->option_name .'[' . $field_id . '][]" value="' . $key . '" '. $ck .' /> <label>' . $name . '</label></li>';
		}		
		echo '</ul>';
	}

	public function preferences_sharing_networks_cb( $args )
	{
		extract( $args );

		$networks = $this->preferences_fields[ $field_id ]['options'];

		echo '<p>'. $this->preferences_fields[ $field_id ]['description'] .'</p>';
		echo '<ul class="rwp-post-type-ul">';
		foreach ($networks as $key => $name) {
			$ck = ( in_array( $key, $selected ) ) ? 'checked' : '';

			echo '<li><input type="checkbox" name="'. $this->option_name .'[' . $field_id . '][]" value="' . $key . '" '. $ck .' /> <label>' . $name . '</label></li>';
		}		
		echo '</ul>';
	}

	public function preferences_rating_title_limits_cb( $args ) 
	{
		extract( $args );

		$range 		= explode( '-', $selected );
		$defaults 	= explode( '-', $default );

		$max_r = ( $range[1] == 'inf' ) ? 'no-limit' : $range[1]; 
		$max_d = ( $defaults[1] == 'inf' ) ? 'no-limit' : $defaults[1]; 

		echo '<div class="rwp-slider-wrap">';

			echo '<input type="text" class="rwp-min" name="'. $this->option_name .'[' . $field_id . '][min]" value="" placeholder="'. $defaults[0] .'"/>';
			echo '<div class="rwp-slider-limits" data-min="'. $range[0] .'" data-max="'. $range[1] .'" ></div>';
			echo '<input type="text" class="rwp-max" name="'. $this->option_name .'[' . $field_id . '][max]" value="" placeholder="'. $max_d .'"/>';

		echo '</div><!-- /slider-wrap -->';

		echo '<p class="description">'. $this->preferences_fields[ $field_id ]['description'].'</p>';
	}

	public function preferences_rating_comment_limits_cb( $args ) 
	{
		extract( $args );

		$range 		= explode( '-', $selected );
		$defaults 	= explode( '-', $default );

		$max_r = ( $range[1] == 'inf' ) ? 'no-limits' : $range[1]; 
		$max_d = ( $defaults[1] == 'inf' ) ? 'no-limits' : $defaults[1]; 

		echo '<div class="rwp-slider-wrap">';

			echo '<input type="text" class="rwp-min" name="'. $this->option_name .'[' . $field_id . '][min]" value="" placeholder="'. $defaults[0] .'"/>';
			echo '<div class="rwp-slider-limits" data-min="'. $range[0] .'" data-max="'. $range[1] .'" ></div>';
			echo '<input type="text" class="rwp-max" name="'. $this->option_name .'[' . $field_id . '][max]" value="" placeholder="'. $max_d .'"/>';

		echo '</div><!-- /slider-wrap -->';

		echo '<p class="description">'. $this->preferences_fields[ $field_id ]['description'].'</p>';
	}

	public function preferences_rating_allow_zero_cb( $args ) 
	{
		extract( $args );

		if( $selected == 'yes' ) {
			$ck = 'checked';
			$value = 'yes';
		} else {
			$ck = '';
			$value = 'no';
		}

		echo '<input type="checkbox" name="'. $this->option_name .'['. $field_id .']" value="'. $value .'" '.$ck.'/>';
		echo '<span class="description">'. $this->preferences_fields[ $field_id ]['description'].'</span>';
	}

	public function preferences_users_reviews_human_date_format_cb( $args ) 
	{
		extract( $args );

		if( $selected == 'yes' ) {
			$ck = 'checked';
			$value = 'yes';
		} else {
			$ck = '';
			$value = 'no';
		}

		echo '<input type="checkbox" name="'. $this->option_name .'['. $field_id .']" value="'. $value .'" '.$ck.'/>';
		echo '<span class="description">'. $this->preferences_fields[ $field_id ]['description'].'</span>';
	}

	public function preferences_sameas_cb( $args ) 
	{
		extract( $args );

		if( $selected == 'yes' ) {
			$ck = 'checked';
			$value = 'yes';
		} else {
			$ck = '';
			$value = 'no';
		}

		echo '<input type="checkbox" name="'. $this->option_name .'['. $field_id .']" value="'. $value .'" '.$ck.'/>';
		echo '<span class="description">'. $this->preferences_fields[ $field_id ]['description'].'</span>';
	}

	public function preferences_custom_login_link_cb( $args ) 
	{
		extract( $args );
		
		echo '<input type="text" name="'. $this->option_name .'['. $field_id .']" value="'. $selected .'" class="regular-text" />';
		echo '<p class="description">'. $this->preferences_fields[ $field_id ]['description'].'</p>';
	}

	public function preferences_custom_css_cb( $args ) 
	{
		extract( $args );

		echo '<p class="description" style="margin: 0 0 10px 0;">'. $this->preferences_fields[ $field_id ]['description'].'</p>';

		echo '<textarea name="'. $this->option_name .'[' . $field_id . ']" id="rwp-codemirror" cols="30" rows="10">'.$selected.'</textarea>';
	}

	public function preferences_notification_cb( $args )
	{
		extract( $args );

		echo '<ul class="rwp-options-ul">';

		foreach ($this->preferences_fields[ $field_id ]['options'] as $option_id => $option_title) {
			
			$ck = ( $selected == $option_id ) ? 'checked' : '';

			echo '<li><input type="radio" name="'. $this->option_name .'[' . $field_id . ']" value="' . $option_id . '" '. $ck .' /> <label>' . $option_title . '</label></li>';
		}

		echo '</ul>';
	}

	public function preferences_notification_email_cb( $args )
	{
		extract( $args );

		echo '<input type="text" name="'. $this->option_name .'[' . $field_id . ']" value="'. $selected .'" />';

		echo '<p class="description">'. $this->preferences_fields[ $field_id ]['description'].'</p>';

		echo '<a href="#" id="rwp-notification-btn" class="button">'. __( 'Send Demo Notification', 'reviewer' ) .'</a>';

		echo '<img class="rwp-loader rwp-pref-loader" src="'.admin_url() .'images/spinner.gif" alt="loading" />';
	}

	public function preferences_users_reviews_per_page_cb( $args )
	{
		extract( $args );

		$min = 1;
		$max = 50;

		echo '<div class="rwp-slider-wrap">';

			echo '<input type="text" name="'. $this->option_name .'[' . $field_id . ']" value="'. $selected .'" />';
			echo '<div class="rwp-slider-std" data-min="'. $min .'" data-max="'. $max .'" data-val="'. $selected .'" ></div>';

		echo '</div><!-- /slider-wrap -->';

		echo '<p class="description">'. $this->preferences_fields[ $field_id ]['description'].'</p>';
	}

	/**
     * Render captcha
     *
     * @since    4.0.0
     * @access   public
     */
    public function preferences_users_reviews_captcha_cb( $args ) 
    {

        extract( $args ); // $field_id, $selected, $default
        $value = $selected;

        $enabled    = isset( $value['enabled'] )    ? $value['enabled']     : $default['enabled'];    
        $site_key   = isset( $value['site_key'] )   ? $value['site_key']    : $default['site_key'];
        $secret_key = isset( $value['secret_key'] ) ? $value['secret_key']  : $default['secret_key'];

        $checked = $enabled ? 'checked' : '';

        echo '<p class="description rwp-description">'. $this->preferences_fields[ $field_id ]['description'] .'</p>';
        echo '<p class="rwp-input-wrapper">'; 
            echo '<input id="rwp-enable-captcha" type="checkbox" name="'. $this->option_name .'[' . $field_id . '][enabled]" value="1" '. $checked .'/>';
            echo '<label for="rwp-enable-captcha">'. __('Enable captcha', 'reviewer') .'</label>';
        echo '</p>';

        echo '<p class="rwp-input-wrapper">'; 
            echo '<label style="min-width: 150px; display: inline-block; vertical-align: middle;">'. __('ReCaptcha Site Key', 'reviewer') .'</label>';
            echo '<input type="text" class="regular-text" name="'. $this->option_name .'[' . $field_id . '][site_key]" value="'. $site_key .'" />';
        echo '</p>';

        echo '<p class="rwp-input-wrapper">'; 
            echo '<label style="min-width: 150px; display: inline-block; vertical-align: middle;">'. __('ReCaptcha Secret Key', 'reviewer') .'</label>';
            echo '<input type="text" class="regular-text" name="'. $this->option_name .'[' . $field_id . '][secret_key]" value="'. $secret_key .'" />';
        echo '</p>';

    }

}
