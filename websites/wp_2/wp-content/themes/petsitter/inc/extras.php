<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package PetSitter
 */

/**
 * Create Main Navigation.
 *
 */
function petsitter_nav() {
	if (has_nav_menu('primary')) {
		wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'flexnav',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul data-breakpoint="992" id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0
			)
		);
	}
}

/**
 * Create Secondary Navigation.
 *
 */
function petsitter_secondary_nav() {
	if (has_nav_menu('secondary')) {
		wp_nav_menu(
		array(
			'theme_location'  => 'secondary',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'header-top-nav header-top-nav__secondary',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => '',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<button class="btn btn-sm btn-default menu-link menu-link__secondary"><i class="fa fa-list"></i></button><ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0
			)
		);
	}
}


/**
 * Create Tertiary Navigation.
 *
 */
function petsitter_tertiary_nav() {
	if (has_nav_menu('tertiary')) {
		wp_nav_menu(
		array(
			'theme_location'  => 'tertiary',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'header-top-nav header-top-nav__tertiary',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => '',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<button class="btn btn-sm btn-default menu-link menu-link__tertiary"><i class="fa fa-user"></i></button><ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0
			)
		);
	}
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function petsitter_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'petsitter_page_menu_args' );


if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function test_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name.
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'test' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'test_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function test_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'test_render_title' );
endif;

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function petsitter_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'petsitter_setup_author' );


add_action('wp_head', 'petsitter_set_post_views');
function petsitter_set_post_views() {
    global $post;

    if('post' == get_post_type() && is_single()) {
        $postID = $post->ID;

        if(!empty($postID)) {
          $count_key = 'petsitter_post_views_count';
          $count = get_post_meta($postID, $count_key, true);

          if($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
          } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
          }
        }
    }
}




// Add Font Awesome to Menus
class PetsitterFontAwesomeMenus {

  function petsitter_menu_item( $nav ){
      $menu_item = preg_replace_callback(
          '/(<li[^>]+class=")([^"]+)("?[^>]+>[^>]+>)([^<]+)<\/a>/',
          array( $this, 'petsitter_replace_menu' ),
          $nav
      );
      return $menu_item;
  }

  function petsitter_replace_menu( $a ){
      $start = $a[ 1 ];
      $classes = $a[ 2 ];
      $rest = $a[ 3 ];
      $text = $a[ 4 ];
      $before = true;

      $class_array = explode( ' ', $classes );
      $fontawesome_classes = array();
      foreach( $class_array as $key => $val ){
          if( 'fa' == substr( $val, 0, 2 ) ){
              if( 'fa' == $val ){
                  unset( $class_array[ $key ] );
              } elseif( 'fa-after' == $val ){
                  $before = false;
                  unset( $class_array[ $key ] );
              } else {
                  $fontawesome_classes[] = $val;
                  unset( $class_array[ $key ] );
              }
          }
      }

      if( !empty( $fontawesome_classes ) ){
          $fontawesome_classes[] = 'fa';
          $text = ' '.$text;
           $newtext = '<i class="'.implode( ' ', $fontawesome_classes ).'"></i><span class="fontawesome-text">'.$text.'</span>';
      } else {
          $newtext = $text;
      }

      $item = $start.implode( ' ', $class_array ).$rest.$newtext.'</a>';
      return $item;
  }


  function __construct(){
    add_filter( 'wp_nav_menu' , array( $this, 'petsitter_menu_item' ), 10, 2 );
  }
}
$n9m_font_awesome_four = new PetsitterFontAwesomeMenus();




/**
 * Way to set menu and set home page.
 *
 */

if ( !function_exists( 'petsitter_wbc_extended' ) ) {
	function petsitter_wbc_extended( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );


		// Setting Menus

		$wbc_menu_array = array( 'Default' );

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$primary_menu   = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
			$secondary_menu = get_term_by( 'name', 'Secondary Menu', 'nav_menu' );
			$tertiary_menu  = get_term_by( 'name', 'Account Menu', 'nav_menu' );

			if ( isset( $primary_menu->term_id ) && isset( $secondary_menu->term_id ) && isset( $tertiary_menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'primary'   => $primary_menu->term_id,
						'secondary' => $secondary_menu->term_id,
						'tertiary'  => $tertiary_menu->term_id
					)
				);
			}

		}

		// Set HomePage

		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'Default' => 'Home',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}
	add_action( 'wbc_importer_after_content_import', 'petsitter_wbc_extended', 10, 2 );
}


/**
 * Demo Style Switcher
 *
 */
if ( file_exists( get_template_directory() . '/demo-style-switcher/petsitter-style-switcher.php' ) ) {
	include_once get_template_directory() . '/demo-style-switcher/petsitter-style-switcher.php';
}
