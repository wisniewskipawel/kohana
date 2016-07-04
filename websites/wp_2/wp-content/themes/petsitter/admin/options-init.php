<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "petsitter_data";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'petsitter_data',
        'dev_mode' => FALSE,
        'disable_tracking' => TRUE,
        'use_cdn' => TRUE,
        'display_name' => $theme->get( 'Name' ),
        'display_version' => $theme->get( 'Version' ),
        'page_slug' => '_options',
        'page_title' => 'Theme Options',
        'admin_bar' => TRUE,
        'menu_type' => 'menu',
        'menu_title' => 'Theme Options',
        'admin_bar_icon' => 'dashicons-admin-generic',
        'allow_sub_menu' => TRUE,
        'page_parent_post_type' => 'your_post_type',
        'customizer' => TRUE,
        'hints' => array(
          'icon'          => 'el el-question-sign',
          'icon_position' => 'right',
          'icon_size'     => 'normal',
          'tip_style'     => array(
            'color' => 'dark',
          ),
          'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
          ),
          'tip_effect' => array(
            'show' => array(
              'duration' => '500',
              'event'    => 'mouseover',
            ),
            'hide' => array(
              'duration' => '500',
              'event'    => 'mouseleave unfocus',
            ),
          ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'transient_time' => '3600',
        'network_sites' => TRUE,
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */




    /*
     *
     * ---> START SECTIONS
     *
     */

    // ACTUAL DECLARATION OF SECTIONS
    Redux::setSection( $opt_name, array(
      'title'     => __('General Settings', 'petsitter'),
      'icon'      => 'el-icon-cogs',
      'fields'    => array(
        array(
          'id'        => 'favicon',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('Custom Favicon', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('Default favicon.', 'petsitter'),
          'subtitle'  => __('Format: ico, Size: 16x16', 'petsitter'),
          'default'   => array('url' => get_template_directory_uri() . '/images/favicon.ico'),
          'width'     => '',
          'height'    => ''
        ),
        array(
          'id'        => 'iphone_icon_retina',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('iPhone Favicon', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('iPhone with high-resolution Retina display.', 'petsitter'),
          'subtitle'  => __('Format: png, Size: 120x120', 'petsitter'),
          'default'   => array(
            'url'     => get_template_directory_uri() . '/images/apple-touch-icon-120x120.png'),
          'width'     => '',
          'height'    => ''
        ),
        array(
          'id'        => 'ipad_icon_retina',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('iPad Favicon', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('For iPad with high-resolution Retina display. General use iOS/Android icon, auto-downscaled by devices.', 'petsitter'),
          'subtitle'  => __('Format: png, Size: 152x152', 'petsitter'),
          'default'   => array(
            'url'     => get_template_directory_uri() . '/images/apple-touch-icon-152x152.png'),
          'width'     => '',
          'height'    => ''
        ),
        array(
          'id'            => 'tracking_code',
          'type'          => 'textarea',
          'title'         => __('Tracking Code', 'petsitter'),
          'subtitle'      => __('Google Analytics or similar', 'petsitter'),
          'desc'          => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'petsitter'),
          'validate'      => '',
          'default'       => '',
          'allowed_html'  => array('') //see http://codex.wordpress.org/Function_Reference/wp_kses
        ),
        array(
          'id'        => 'breadcrumbs',
          'type'      => 'switch',
          'title'     => __('Breadcrumbs', 'petsitter'),
          'subtitle'  => __('Breadcrumbs are displayed by default.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
      )
    ) );


    // Header Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Header', 'petsitter'),
      'icon'      => 'el-icon-home',
      'fields'    => array(
        array(
          'id'        => 'petsitter__header-top-bar',
          'type'      => 'switch',
          'title'     => __('Header Top Bar', 'petsitter'),
          'desc'      => __('Top Bar located at the top of the header.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'logo-standard',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('Logo', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('Upload your image or remove image if you want to use text-based logo.', 'petsitter'),
          'default'   => array(
            'url'     => get_template_directory_uri() . '/images/logo.png'),
          'width'     => '',
          'height'    => '',
        ),
        array(
          'id'        => 'petsitter__header-phone-title',
          'type'      => 'text',
          'title'     => __('Phone Title', 'petsitter'),
          'subtitle'  => __('Text before phone number.', 'petsitter'),
          'desc'      => __('Enter short text used before phone number.', 'petsitter'),
          'msg'       => 'Fill Phone Title',
          'default'   => 'Call us on:'
        ),
        array(
          'id'        => 'petsitter__header-phone-number',
          'type'      => 'text',
          'title'     => __('Phone Number', 'petsitter'),
          'desc'      => __('Enter phone number.', 'petsitter'),
          'msg'       => 'Fill Phone Number',
          'default'   => '+1 (234) 567890'
        ),
        array(
          'id'        => 'petsitter__header-email-title',
          'type'      => 'text',
          'title'     => __('Email Title', 'petsitter'),
          'subtitle'  => __('Text before email address.', 'petsitter'),
          'desc'      => __('Enter short text used before email address.', 'petsitter'),
          'msg'       => 'Fill Email Title',
          'default'   => 'Email:'
        ),
        array(
          'id'        => 'petsitter__header-email',
          'type'      => 'text',
          'title'     => __('Email Address', 'petsitter'),
          'subtitle'  => __('Email Address used in the header.', 'petsitter'),
          'desc'      => __('Enter email address.', 'petsitter'),
          'validate'  => 'email',
          'msg'       => 'Fill Email Address',
          'default'   => 'petsitter@dan-fisher.com'
        ),
        array(
          'id'        => 'petsitter__header-custom-info-title',
          'type'      => 'text',
          'title'     => __('Custom Info Title', 'petsitter'),
          'subtitle'  => __('Text before custom info field.', 'petsitter'),
          'desc'      => __('Enter short text used before custom info field (e.g. Working Hours:)', 'petsitter'),
          'default'   => ''
        ),
        array(
          'id'        => 'petsitter__header-custom-info-text',
          'type'      => 'text',
          'title'     => __('Custom Info Text', 'petsitter'),
          'desc'      => __('Enter short text used for custom info field (e.g. 9:00 - 21:00)', 'petsitter'),
          'default'   => ''
        ),
        array(
          'id'        => 'petsitter__header-links',
          'type'      => 'switch',
          'title'     => __('Header Social Links', 'petsitter'),
          'subtitle'  => __('Header Social Link are displayed by default.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'petsitter__header-social-fb',
          'type'      => 'text',
          'title'     => __('Facebook', 'petsitter'),
          'subtitle'  => __('Link to your Facebook account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-twitter',
          'type'      => 'text',
          'title'     => __('Twitter', 'petsitter'),
          'subtitle'  => __('Link to your Twitter account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-linkedin',
          'type'      => 'text',
          'title'     => __('Linkedin', 'petsitter'),
          'subtitle'  => __('Link to your Linkedin account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-google-plus',
          'type'      => 'text',
          'title'     => __('Google+', 'petsitter'),
          'subtitle'  => __('Link to your Google+ account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-pinterest',
          'type'      => 'text',
          'title'     => __('Pinterest', 'petsitter'),
          'subtitle'  => __('Link to your Pinterest account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-youtube',
          'type'      => 'text',
          'title'     => __('YouTube', 'petsitter'),
          'subtitle'  => __('Link to your YouTube account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__header-social-instagram',
          'type'      => 'text',
          'title'     => __('Instagram', 'petsitter'),
          'subtitle'  => __('Link to your Instagram account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-tumblr',
          'type'      => 'text',
          'title'     => __('Tumblr', 'petsitter'),
          'subtitle'  => __('Link to your Tumblr account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__header-social-dribbble',
          'type'      => 'text',
          'title'     => __('Dribbble', 'petsitter'),
          'subtitle'  => __('Link to your Dribbble account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__header-social-vimeo',
          'type'      => 'text',
          'title'     => __('Vimeo', 'petsitter'),
          'subtitle'  => __('Link to your Vimeo account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__header-social-flickr',
          'type'      => 'text',
          'title'     => __('Flickr', 'petsitter'),
          'subtitle'  => __('Link to your Flickr account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__header-social-yelp',
          'type'      => 'text',
          'title'     => __('Yelp', 'petsitter'),
          'subtitle'  => __('Link to your Yelp account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__header-social-rss',
          'type'      => 'text',
          'title'     => __('RSS Feed', 'petsitter'),
          'subtitle'  => __('Link to your RSS Feed.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__header-cart',
          'type'      => 'switch',
          'title'     => __('Header Shopping Cart', 'petsitter'),
          'desc'      => __('Shopping cart is in the Header Top Bar.', 'petsitter'),
          'default'   => 0,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
      )
    ) );



    // Slider Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Main Slider', 'petsitter'),
      'icon'      => 'el-icon-picture',
      'fields'    => array(
        array(
          'id'            => 'petsitter__slider-speed',
          'type'          => 'slider',
          'title'         => __('Delay between slides', 'petsitter'),
          'subtitle'      => __('Set the speed of the slideshow cycling, in seconds.', 'petsitter'),
          'desc'          => __('Recommended value is 7 secs.', 'petsitter'),
          'default'       => 7,
          'min'           => 2,
          'step'          => 1,
          'max'           => 20,
          'display_value' => 'label'
        ),
        array(
          'id'        => 'petsitter__slider-controls',
          'type'      => 'switch',
          'title'     => __('Show Pagination?', 'petsitter'),
          'subtitle'  => __('Slider controls (bullets).', 'petsitter'),
          'default'   => 1,
          'on'        => 'On',
          'off'       => 'Off',
        ),
        array(
          'id'        => 'petsitter__slider-autoplay',
          'type'      => 'switch',
          'title'     => __('Autoplay', 'petsitter'),
          'subtitle'  => __('Slideshow starts automatically.', 'petsitter'),
          'default'   => 1,
          'on'        => 'On',
          'off'       => 'Off',
        ),
        array(
          'id'        => 'petsitter__slider-loop',
          'type'      => 'switch',
          'title'     => __('Infinite Loop', 'petsitter'),
          'subtitle'  => __('Looped animation.', 'petsitter'),
          'default'   => 1,
          'on'        => 'On',
          'off'       => 'Off',
        ),
      )
    ) );




    // Search Form
    Redux::setSection( $opt_name, array(
      'title'     => __('Search Form (Home)', 'petsitter'),
      'icon'      => 'el-icon-search',
      'fields'    => array(

        array(
          'id'        => 'petsitter__slider-box-type',
          'type'      => 'select',
          'title'     => __('Box Content', 'petsitter'),
          'desc'      => __('Choose your slider\'s box content.', 'petsitter'),
          'options'   => array(
            '1' => 'Text &amp; Buttons',
            '2' => 'Jobs Search Form',
            '3' => 'Resumes Search Form',
            '4' => 'Hide All'
          ),
          'default'   => '2'
        ),
        array(
          'id'        => 'petsitter__slider-heading',
          'type'      => 'text',
          'title'     => __('Call to Action Heading', 'petsitter'),
          'subtitle'  => __('This heading used in the box in slider.', 'petsitter'),
          'default'   => 'What Would You Like To Do?',
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'            => 'petsitter__slider-text',
          'type'          => 'textarea',
          'title'         => __('Call to Action Text', 'petsitter'),
          'subtitle'      => __('This text used goes under the title.', 'petsitter'),
          'validate'      => '',
          'default'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis convallis at nisi id molestie. Nulla lacinia turpis et dolor varius, ac suscipit ex convallis consectetur.',
          'allowed_html'  => array(''),
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'        => 'petsitter__slider-btn1-txt',
          'type'      => 'text',
          'title'     => __('First Button Text', 'petsitter'),
          'subtitle'  => __('First button text used in the box in slider.', 'petsitter'),
          'default'   => 'Post a Job',
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'        => 'petsitter__slider-btn1-url',
          'type'      => 'text',
          'title'     => __('First Button URL', 'petsitter'),
          'subtitle'  => __('First button url used in the box in slider.', 'petsitter'),
          'default'   => '#',
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'        => 'petsitter__slider-btn2-txt',
          'type'      => 'text',
          'title'     => __('Second Button Text', 'petsitter'),
          'subtitle'  => __('Second button text used in the box in slider.', 'petsitter'),
          'default'   => 'Post Your Profile',
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'        => 'petsitter__slider-btn2-url',
          'type'      => 'text',
          'title'     => __('Second Button URL', 'petsitter'),
          'subtitle'  => __('Second button url used in the box in slider.', 'petsitter'),
          'default'   => '#',
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'        => 'petsitter__slider-conjunction',
          'type'      => 'text',
          'title'     => __('Text between buttons', 'petsitter'),
          'subtitle'  => __('This tet located between buttons.', 'petsitter'),
          'default'   => '&mdash; or &mdash;',
          'required'  => array('petsitter__slider-box-type', '=', '1'),
        ),
        array(
          'id'        => 'petsitter__slider-search-heading',
          'type'      => 'text',
          'title'     => __('Jobs Search Form Heading', 'petsitter'),
          'subtitle'  => __('This heading used in the box in slider.', 'petsitter'),
          'default'   => 'Want a Pet Sitting Job?',
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__slider-search-slug',
          'type'      => 'text',
          'title'     => __('Jobs Page URL', 'petsitter'),
          'subtitle'  => __('URL to your jobs page.', 'petsitter'),
          'desc'      => __('Put the URL to your jobs page (assuming filters are enabled). Example <em>pet-sitters/pet-sitter-jobs/</em>', 'petsitter'),
          'default'   => 'pet-sitters/pet-sitter-jobs/',
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__slider-jobs-layout',
          'type'      => 'sorter',
          'title'     => __( 'Form Fields Layout', 'petsitter' ),
          'subtitle'  => __( 'Organize search fields order.', 'petsitter' ),
          'desc'      => __( 'Organize how you want the fields to appear in the box.', 'petsitter' ),
          'compiler'  => 'true',
          'options'   => array(
              'enabled'   => array(
                'field__keywords'    => __( 'Keywords', 'petsitter' ),
                'field__location'    => __( 'Location', 'petsitter' ),
                'field__category'    => __( 'Categories', 'petsitter' ),
                'field__submit'      => __( 'Submit', 'petsitter' ),
              ),
              'disabled'  => array(
              ),
          ),
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__slider-jobs-field-keywords',
          'type'      => 'text',
          'title'     => __('Keywords Field - Placeholder', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Keywords</em> field.', 'petsitter'),
          'default'   => 'Keywords',
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__slider-jobs-field-location',
          'type'      => 'text',
          'title'     => __('Location Field - Placeholder', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Location</em> field.', 'petsitter'),
          'default'   => 'Any location',
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__slider-jobs-field-category',
          'type'      => 'text',
          'title'     => __('Categories Field - Placeholder', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Categories</em> field.', 'petsitter'),
          'default'   => 'Any category',
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__slider-jobs-field-submit',
          'type'      => 'text',
          'title'     => __('Submit Button - Text', 'petsitter'),
          'subtitle'  => __('Button\'s text.', 'petsitter'),
          'desc'      => __('Change text for <em>Submit</em> button.', 'petsitter'),
          'default'   => 'Search',
          'required'  => array('petsitter__slider-box-type', '=', '2'),
        ),



        array(
          'id'        => 'petsitter__slider-search-heading-resumes',
          'type'      => 'text',
          'title'     => __('Resumes Search Form Heading', 'petsitter'),
          'subtitle'  => __('This heading used in the box in slider.', 'petsitter'),
          'default'   => 'Find a Perfect Pet Sitter Near You',
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
        array(
          'id'        => 'petsitter__slider-search-slug-resumes',
          'type'      => 'text',
          'title'     => __('Resumes Page URL', 'petsitter'),
          'subtitle'  => __('URL to your resumes page.', 'petsitter'),
          'desc'      => __('Put the URL to your resumes page (assuming filters are enabled). Example <em>pet-sitters/pet-sitters-list/</em>', 'petsitter'),
          'default'   => 'pet-sitters/pet-sitters-list/',
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
        array(
          'id'        => 'petsitter__slider-resumes-layout',
          'type'      => 'sorter',
          'title'     => __( 'Form Fields Layout', 'petsitter' ),
          'subtitle'  => __( 'Organize search fields order.', 'petsitter' ),
          'desc'      => __( 'Organize how you want the fields to appear in the box.', 'petsitter' ),
          'compiler'  => 'true',
          'options'   => array(
              'enabled'   => array(
                'field__keywords'    => __( 'Keywords', 'petsitter' ),
                'field__location'    => __( 'Location', 'petsitter' ),
                'field__category'    => __( 'Categories', 'petsitter' ),
                'field__submit'      => __( 'Submit', 'petsitter' ),
              ),
              'disabled'  => array(
              ),
          ),
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
        array(
          'id'        => 'petsitter__slider-resumes-field-keywords',
          'type'      => 'text',
          'title'     => __('Keywords Field - Placeholder', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Keywords</em> field.', 'petsitter'),
          'default'   => 'Keywords',
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
        array(
          'id'        => 'petsitter__slider-resumes-field-location',
          'type'      => 'text',
          'title'     => __('Location Field - Placeholder', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Location</em> field.', 'petsitter'),
          'default'   => 'Any location',
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
        array(
          'id'        => 'petsitter__slider-resumes-field-category',
          'type'      => 'text',
          'title'     => __('Categories Field - Placeholder', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Categories</em> field.', 'petsitter'),
          'default'   => 'All Categories',
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
        array(
          'id'        => 'petsitter__slider-resumes-field-submit',
          'type'      => 'text',
          'title'     => __('Submit Button - Text', 'petsitter'),
          'subtitle'  => __('Button\'s text.', 'petsitter'),
          'desc'      => __('Change text for <em>Submit</em> button.', 'petsitter'),
          'default'   => 'Search',
          'required'  => array('petsitter__slider-box-type', '=', '3'),
        ),
      )
    ) );



    // Blog Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Blog', 'petsitter'),
      'icon'      => 'el-icon-th-list',
      'fields'    => array(
        array(
          'id'        => 'opt-blog-sidebar',
          'type'      => 'image_select',
          'compiler'  => true,
          'title'     => __('Sidebar Position', 'petsitter'),
          'subtitle'  => __('Select sidebar alignment or disable it.', 'petsitter'),
          'options'   => array(
              '1' => array(
                'alt' => 'Right Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
              '2' => array(
                'alt' => 'Left Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
              '3' => array(
                'alt' => 'No Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/1col.png')
          ),
          'default'   => '1'
        ),
        array(
          'id'        => 'petsitter__blog-image-size',
          'type'      => 'select',
          'title'     => __('Thumbnail Size', 'petsitter'),
          'subtitle'  => __('Blog Thumbnail Size', 'petsitter'),
          'desc'      => __('Choose your blogs\'s thumbnail size', 'petsitter'),
          'options'   => array(
            '1' => 'Large',
            '2' => 'Medium'
          ),
          'default'   => '1'
        ),
        array(
          'id'        => 'opt-blog-title',
          'type'      => 'text',
          'title'     => __('Blog Page Title', 'petsitter'),
          'subtitle'  => __('This title used on Blog Page', 'petsitter'),
          'desc'      => __('Enter Your Blog Title used on Blog page.', 'petsitter'),
          'validate'  => 'not_empty',
          'msg'       => 'Fill Blog Page title',
          'default'   => 'Blog'
        ),
        array(
          'id'        => 'petsitter__post-date-icon',
          'type'      => 'switch',
          'title'     => __('Blog Date', 'petsitter'),
          'subtitle'  => __('Show/hide date icon on blog and single post pages.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-post-image',
          'type'      => 'switch',
          'title'     => __('Featured Image on Single Post', 'petsitter'),
          'subtitle'  => __('Show/hide featured images on single post pages.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-post-title',
          'type'      => 'switch',
          'title'     => __('Post Title on Single Post', 'petsitter'),
          'subtitle'  => __('Show/hide the post title that goes below the featured images.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-info-box',
          'type'      => 'switch',
          'title'     => __('Author Info Box on Single Post', 'petsitter'),
          'subtitle'  => __('Show/hide the author info box below posts.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-social-box',
          'type'      => 'switch',
          'title'     => __('Social Sharing Box', 'petsitter'),
          'subtitle'  => __('Show/hide the social sharing box.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'petsitter__blog-more-txt',
          'type'      => 'text',
          'title'     => __('Read More Text', 'petsitter'),
          'desc'      => __('Enter button text for post. Example <em>\'Read More\'</em>', 'petsitter'),
          'validate'  => 'not_empty',
          'msg'       => 'Fill Read More button text',
          'default'   => 'Read More'
        ),
        array(
          'id'        => 'petsitter__blog-login-page',
          'type'      => 'select',
          'data'      => 'pages',
          'title'     => __('Comments Login Page', 'petsitter'),
          'subtitle'  => __('Login page on your site.', 'petsitter'),
          'desc'      => __('Choose a page where you paste <code>[clean-login]</code> shortcode.', 'petsitter'),
        )
      )
    ) );


    // Portfolio Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Portfolio', 'petsitter'),
      'icon'      => 'el-icon-picture',
      'fields'    => array(
        array(
          'id'        => 'petsitter__opt-portfolio-slug',
          'type'      => 'text',
          'title'     => __('Portfolio Slug', 'petsitter'),
          'subtitle'  => __('Change this option if you want to change default portfolio slug.', 'petsitter'),
          'desc'      => __('After changing this slug go to <em>Settings > Permalinks</em> and resave it.', 'petsitter'),
          'default'   => 'portfolio-view',
        ),
        array(
          'id'        => 'opt-portfolio-num',
          'type'      => 'text',
          'title'     => __('Number of Portfolio Items', 'petsitter'),
          'desc'      => __('How many items do you want to show on portfolio pages?', 'petsitter'),
          'validate'  => 'numeric',
          'default'   => '12',
        ),
        array(
          'id'        => 'opt-portfolio-filter',
          'type'      => 'switch',
          'title'     => __('Filter', 'petsitter'),
          'desc'      => __('Filter by categories. Located above the portfolio items.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-portfolio-filter-btn-txt',
          'type'      => 'text',
          'title'     => __('Filter Button Text', 'petsitter'),
          'desc'      => __('Text for button used for all portfolio items.', 'petsitter'),
          'validate'  => 'not_empty',
          'msg'       => 'Fill Filter Button Text',
          'default'   => 'All',
        ),
        array(
          'id'        => 'opt-portfolio-lightbox',
          'type'      => 'radio',
          'title'     => __('Portfolio Lightbox & Link', 'petsitter'),
          'desc'      => __('Magnifying icon and link icon appear when you hover on portfolio item. You can show only one of them, both or hide', 'petsitter'),
          'options'   => array(
            '1' => 'Show Both',
            '2' => 'Lightbox Icon Only',
            '3' => 'Link Icon Only',
            '4' => 'Hide Both'
          ),
          'default'   => '1'
        ),
        array(
          'id'        => 'opt-portfolio-meta',
          'type'      => 'switch',
          'title'     => __('Portfolio Title & Meta', 'petsitter'),
          'desc'      => __('Title and short info for portfolio posts.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-portfolio-layout',
          'type'      => 'image_select',
          'compiler'  => true,
          'title'     => __('Single Portfolio Layout', 'petsitter'),
          'options'   => array(
              '1' => array(
                'alt' => 'Right Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
              '2' => array(
                'alt' => 'Left Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
              '3' => array(
                'alt' => 'Full Width',
                'img' => ReduxFramework::$_url . 'assets/img/1col.png')
          ),
          'default'   => '1',
          'desc'      => __('Single Portfolio Sidebar contains project info added via content editor.', 'petsitter'),
        ),
        array(
          'id'        => 'opt-portfolio-nav',
          'type'      => 'switch',
          'title'     => __('Previous/Next Pagination', 'petsitter'),
          'subtitle'  => __('Link to prev/next portfolio items.', 'petsitter'),
          'desc'      => __('Located above the portfolio on the Single Portfolio page.', 'petsitter'),
          'default'   => 0,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-portfolio-related',
          'type'      => 'switch',
          'title'     => __('Related Projects', 'petsitter'),
          'desc'      => __('Located at the bottom of Single Portfolio Page.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-portfolio-related-title',
          'type'      => 'text',
          'title'     => __('Related Pets Title', 'petsitter'),
          'desc'      => __('Enter Your Related Pets Title used on Single Portfolio Page.', 'petsitter'),
          'validate'  => 'not_empty',
          'msg'       => 'Fill Related Pets title',
          'default'   => 'Related Pets',
        ),
      )
    ) );



    // Contact Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Contacts', 'petsitter'),
      'icon'      => 'el-icon-envelope',
      'fields'    => array(
        array(
          'id'        => 'opt-contact-gmap',
          'type'      => 'switch',
          'title'     => __('Google Map', 'petsitter'),
          'subtitle'  => __('Show/hide Google Map.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-contact-coordinates',
          'type'      => 'text',
          'title'     => __('Google Map Coordinates', 'petsitter'),
          'subtitle'  => __('Put your address here.', 'petsitter'),
          'desc'      => __('Go to <a href="https://www.google.com/maps/">Google Map</a>, copy and paste your coordinates.', 'petsitter'),
          'default'   => '57.669645,11.926832',
        ),
        array(
          'id'        => 'opt-contact-coordinates2',
          'type'      => 'text',
          'title'     => __('Google Map Coordinates 2', 'petsitter'),
          'subtitle'  => __('Put your 2nd address here.', 'petsitter'),
          'desc'      => __('Go to <a href="https://www.google.com/maps/">Google Map</a>, copy and paste your coordinates.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__map-center-coordinates',
          'type'      => 'text',
          'title'     => __('Map Center Coordinates', 'petsitter'),
          'subtitle'  => __('Coordinates for centering map.', 'petsitter'),
          'desc'      => __('Leave blank if you use single address.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'            => 'opt-contact-zoom',
          'type'          => 'slider',
          'title'         => __('Map Zoom Level', 'petsitter'),
          'subtitle'      => __('Used in Google Map.', 'petsitter'),
          'desc'          => __('Higher number will be more zoomed in.', 'petsitter'),
          'default'       => 13,
          'min'           => 1,
          'step'          => 1,
          'max'           => 19,
          'display_value' => 'label'
        ),

        array(
          'id'    => 'opt-contact-divider1',
          'type'  => 'divide'
        ),

        array(
          'id'        => 'opt-contact-info',
          'type'      => 'switch',
          'title'     => __('Contact Info', 'petsitter'),
          'subtitle'  => __('Show/hide contact info section.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-contact-title',
          'type'      => 'text',
          'title'     => __('Contact Info Title', 'petsitter'),
          'subtitle'  => __('Title used in Contact Info section.', 'petsitter'),
          'default'   => 'Contact Us',
        ),
        array(
          'id'        => 'opt-contact-address',
          'type'      => 'text',
          'title'     => __('Address', 'petsitter'),
          'subtitle'  => __('Address used in the Contact Info section.', 'petsitter'),
          'default'   => 'Pet Sitter Co., Old Town Avenue, New York, USA 23000',
        ),
        array(
          'id'        => 'opt-contact-address2',
          'type'      => 'text',
          'title'     => __('Address 2', 'petsitter'),
          'subtitle'  => __('Address used in the Contact Info section for the 2nd office.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'opt-contact-phone',
          'type'      => 'multi_text',
          'title'     => __('Phone(s)', 'petsitter'),
          'subtitle'  => __('Phone numbers used in the Contact Info section.', 'petsitter'),
          'desc'      => __('You can add as more numbers as you want.', 'petsitter'),
          // 'validate'  => 'numeric',
          'default'   => array(
            1 => '+1-888-555-5555'
          )
        ),
        array(
          'id'        => 'opt-contact-fax',
          'type'      => 'multi_text',
          'title'     => __('Fax(s)', 'petsitter'),
          'subtitle'  => __('Fax numbers used in the Contact Info section.', 'petsitter'),
          'desc'      => __('You can add as more numbers as you want.', 'petsitter'),
        ),
        array(
          'id'        => 'opt-contact-skype',
          'type'      => 'text',
          'title'     => __('Skype Username', 'petsitter'),
          'subtitle'  => __('Enter your Skype username.', 'petsitter'),
          'desc'      => __('Link will initiate Skype to call Skype username.', 'petsitter'),
        ),
        array(
          'id'        => 'opt-contact-email',
          'type'      => 'multi_text',
          'title'     => __('Email(s)', 'petsitter'),
          'subtitle'  => __('Emails used in the Contact Info section.', 'petsitter'),
          'desc'      => __('You can add as more emails as you want.', 'petsitter'),
          'validate'  => 'email',
          'default'   => array(
            1 => 'petsitter@dan-fisher.com'
          )
        ),
        array(
          'id'        => 'opt-contact-hours',
          'type'      => 'text',
          'title'     => __('Working Hours', 'petsitter'),
          'subtitle'  => __('Info your schedule.', 'petsitter'),
          'default'   => 'Monday - Friday 9:00 - 21:00',
        ),
      )
    ) );



  // Footer Options
  Redux::setSection( $opt_name, array(
      'title'     => __('Footer', 'petsitter'),
      'icon'      => 'el-icon-align-center',
      'fields'    => array(
        array(
          'id'        => 'opt-footer-widgets',
          'type'      => 'switch',
          'title'     => __('Footer Widgets', 'petsitter'),
          'subtitle'  => __('Footer Widgets are displayed by default.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-footer-widgets-layout',
          'type'      => 'image_select',
          'required'  => array('opt-footer-widgets', '=', '1'),
          'compiler'  => true,
          'title'     => __('Footer Widgets Layout', 'petsitter'),
          'subtitle'  => __('Select footer widgets layout (not equal or equal).', 'petsitter'),
          'options'   => array(
            '1' => array(
              'alt' => '4 Columns',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols1.png'),
            '2' => array(
              'alt' => '4 Columns (equal)',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols2.png'),
            '3' => array(
              'alt' => '3 Columns (left wider)',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols3.png'),
            '4' => array(
              'alt' => '3 Columns (right wider)',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols4.png'),
            '5' => array(
              'alt' => '3 Columns (equal)',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols5.png'),
            '6' => array(
              'alt' => '2 Columns (right wider)',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols6.png'),
            '7' => array(
              'alt' => '2 Columns (left wider)',
              'img' => get_template_directory_uri() . '/images/admin/footer-cols7.png'),
          ),
          'default'   => '1'
        ),
        array(
          'id'        => 'opt-footer-copyright',
          'type'      => 'switch',
          'title'     => __('Copyright', 'petsitter'),
          'subtitle'  => __('Footer Copyright is displayed by default.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'opt-footer-text',
          'type'      => 'editor',
          'required'  => array('opt-footer-copyright', '=', '1'),
          'title'     => __('Copyright Text', 'petsitter'),
          'subtitle'  => __('Add copyright text here.', 'petsitter'),
          'default'   => '&copy; 2014. All rights reserved. Done by <a href="http://themeforest.net/user/dan_fisher/portfolio?ref=dan_fisher">Dan Fisher</a>',
          'compiler'  => true,
          'args'      => array(
            'teeny'         => true,
            'media_buttons' => false,
            'quicktags'     => true,
            'textarea_rows' => 2,
          )
        ),
        array(
          'id'        => 'petsitter__footer-links',
          'type'      => 'switch',
          'title'     => __('Footer Social Links', 'petsitter'),
          'subtitle'  => __('Footer Social Link are displayed by default.', 'petsitter'),
          'default'   => 1,
          'on'        => 'Show',
          'off'       => 'Hide',
        ),
        array(
          'id'        => 'petsitter__footer-social-text',
          'type'      => 'text',
          'title'     => __('Footer Social Text', 'petsitter'),
          'subtitle'  => __('This text displayed before social links.', 'petsitter'),
          'default'   => 'Keep in Touch',
        ),
        array(
          'id'        => 'petsitter__footer-social-fb',
          'type'      => 'text',
          'title'     => __('Facebook', 'petsitter'),
          'subtitle'  => __('Link to your Facebook account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-twitter',
          'type'      => 'text',
          'title'     => __('Twitter', 'petsitter'),
          'subtitle'  => __('Link to your Twitter account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-linkedin',
          'type'      => 'text',
          'title'     => __('Linkedin', 'petsitter'),
          'subtitle'  => __('Link to your Linkedin account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-google-plus',
          'type'      => 'text',
          'title'     => __('Google+', 'petsitter'),
          'subtitle'  => __('Link to your Google+ account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-pinterest',
          'type'      => 'text',
          'title'     => __('Pinterest', 'petsitter'),
          'subtitle'  => __('Link to your Pinterest account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-youtube',
          'type'      => 'text',
          'title'     => __('YouTube', 'petsitter'),
          'subtitle'  => __('Link to your YouTube account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__footer-social-instagram',
          'type'      => 'text',
          'title'     => __('Instagram', 'petsitter'),
          'subtitle'  => __('Link to your Instagram account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-tumblr',
          'type'      => 'text',
          'title'     => __('Tumblr', 'petsitter'),
          'subtitle'  => __('Link to your Tumblr account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__footer-social-dribbble',
          'type'      => 'text',
          'title'     => __('Dribbble', 'petsitter'),
          'subtitle'  => __('Link to your Dribbble account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__footer-social-vimeo',
          'type'      => 'text',
          'title'     => __('Vimeo', 'petsitter'),
          'subtitle'  => __('Link to your Vimeo account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__footer-social-flickr',
          'type'      => 'text',
          'title'     => __('Flickr', 'petsitter'),
          'subtitle'  => __('Link to your Flickr account.', 'petsitter'),
          'default'   => '',
        ),
        array(
          'id'        => 'petsitter__footer-social-yelp',
          'type'      => 'text',
          'title'     => __('Yelp', 'petsitter'),
          'subtitle'  => __('Link to your Yelp account.', 'petsitter'),
          'default'   => '#',
        ),
        array(
          'id'        => 'petsitter__footer-social-rss',
          'type'      => 'text',
          'title'     => __('RSS Feed', 'petsitter'),
          'subtitle'  => __('Link to your RSS Feed.', 'petsitter'),
          'default'   => '',
        ),
      )
    ) );




    // Typography Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Typography', 'petsitter'),
      'icon'      => 'el-icon-font',
      'fields'    => array(
        array(
          'id'        => 'typography-body',
          'type'      => 'typography',
          'title'     => __('Body Font', 'petsitter'),
          'subtitle'  => __('Specify the body font properties.', 'petsitter'),
          'google'    => true,
          'output'    => array('body'),
          'units'     => 'px',
          'default'   => array(
            'color'         => '#8c8c8c',
            'font-size'     => '14px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '300',
            'line-height'   => '24px',
            'text-align'    => 'left',
          ),
        ),
        array(
          'id'          => 'petsitter__logo-txt',
          'type'        => 'typography',
          'title'       => __('Logo Text', 'petsitter'),
          'subtitle'    => __('Specify the Logo (Text-based) font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.logo h1 a, .logo h2 a'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#a6ce39',
            'font-size'     => '42px',
            'font-family'   => 'Bitter',
            'google'        => true,
            'font-weight'   => '700',
          ),
          'hint'        => array(
            'content'   => __( 'You can see the changes only for Text-based Logo', 'petsitter' ),
          )
        ),
        array(
          'id'          => 'petsitter__typography-top-bar',
          'type'        => 'typography',
          'title'       => __('Header Top Bar', 'petsitter'),
          'subtitle'    => __('Specify the Header Top Bar font properties.', 'petsitter'),
          'google'      => true,
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'text-transform' => true,
          'default'     => array(
            'font-size'      => '10px',
            'font-family'    => 'Lato',
            'font-weight'    => '300',
            'color'          => '#8c8c8c',
            'text-transform' => 'uppercase',
          ),
        ),
        array(
          'id'          => 'petsitter__typography-header-middle',
          'type'        => 'typography',
          'title'       => __('Header Middle', 'petsitter'),
          'subtitle'    => __('Specify the Header Middle font properties.', 'petsitter'),
          'output'      => array('.head-info-list > li'),
          'google'      => true,
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'color'       => false,
          'default'     => array(
            'font-size'      => '14px',
            'font-family'    => 'Lato',
            'font-weight'    => '300'
          ),
        ),
        array(
          'id'          => 'typography-nav',
          'type'        => 'typography',
          'title'       => __('Menu Font', 'petsitter'),
          'subtitle'    => __('Specify the main navigation font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.flexnav li a'),
          'units'       => 'px',
          'color'       => false,
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'font-size'     => '14px',
            'font-family'   => 'Lato',
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-h1',
          'type'        => 'typography',
          'title'       => __('H1 Heading', 'petsitter'),
          'subtitle'    => __('Specify the H1 heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('h1'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454546',
            'font-size'     => '32px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-h2',
          'type'        => 'typography',
          'title'       => __('H2 Heading', 'petsitter'),
          'subtitle'    => __('Specify the H2 heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('h2'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454546',
            'font-size'     => '24px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-h3',
          'type'        => 'typography',
          'title'       => __('H3 Heading', 'petsitter'),
          'subtitle'    => __('Specify the H3 heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('h3'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454546',
            'font-size'     => '20px',
            'font-family'   => 'Lato',
            'google' => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-h4',
          'type'        => 'typography',
          'title'       => __('H4 Heading', 'petsitter'),
          'subtitle'    => __('Specify the H4 heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('h4'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454546',
            'font-size'     => '18px',
            'font-family'   => 'Lato',
            'google' => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-h5',
          'type'        => 'typography',
          'title'       => __('H5 Heading', 'petsitter'),
          'subtitle'    => __('Specify the H5 heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('h5'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454546',
            'font-size'     => '16px',
            'font-family'   => 'Lato',
            'google' => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-h6',
          'type'        => 'typography',
          'title'       => __('H6 Heading', 'petsitter'),
          'subtitle'    => __('Specify the H6 heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('h6'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454546',
            'font-size'     => '14px',
            'font-family'   => 'Lato',
            'google' => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-heading-bordered',
          'type'        => 'typography',
          'title'       => __('Title Bordered', 'petsitter'),
          'subtitle'    => __('Specify the title bordered font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.title-bordered h2'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454545',
            'font-size'     => '24px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-breadcrumbs',
          'type'        => 'typography',
          'title'       => __('Breadcrumbs Font', 'petsitter'),
          'subtitle'    => __('Specify the breadcrumbs font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.page-heading .breadcrumb > li'),
          'line-height' => false,
          'text-align'  => false,
          'color'       => false,
          'default'     => array(
            'font-size'     => '12px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400',
          ),
        ),
        array(
          'id'          => 'typography-page-heading',
          'type'        => 'typography',
          'title'       => __('Page Heading Font', 'petsitter'),
          'subtitle'    => __('Specify the page heading font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.page-heading h1'),
          'units'       => 'px',
          'line-height' => false,
          'text-align'  => false,
          'default'     => array(
            'color'         => '#fff',
            'font-size'     => '20px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400'
          ),
        ),
        array(
          'id'          => 'typography-heading-post',
          'type'        => 'typography',
          'title'       => __('Blog Post Title', 'petsitter'),
          'subtitle'    => __('Specify the post title font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.post .entry-header .entry-title, .post .entry-header .entry-title a'),
          'units'       => 'px',
          'text-align'  => false,
          'default'     => array(
            'color'         => '#454545',
            'font-size'     => '24px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400',
            'line-height'   => '28px',
          ),
        ),
        array(
          'id'          => 'typography-sidebar-heading',
          'type'        => 'typography',
          'title'       => __('Sidebar Widget Heading', 'petsitter'),
          'subtitle'    => __('Specify the Sidebar widget title font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.widget__sidebar .widget-title h3'),
          'units'       => 'px',
          'line-height' => false,
          'default'     => array(
            'color'         => '#454545',
            'font-size'     => '18px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400'
          ),
        ),
        array(
          'id'          => 'typography-footer-heading',
          'type'        => 'typography',
          'title'       => __('Footer Widget Heading', 'petsitter'),
          'subtitle'    => __('Specify the footer widget title font properties.', 'petsitter'),
          'google'      => true,
          'output'      => array('.widget__footer .widget-title h4'),
          'units'       => 'px',
          'line-height' => false,
          'default'     => array(
            'color'         => '#d8d8d8',
            'font-size'     => '16px',
            'font-family'   => 'Lato',
            'google'        => true,
            'font-weight'   => '400',
            'text-align'    => 'left'
          ),
        ),
      )
    ) );


    // Styling Options
    Redux::setSection( $opt_name, array(
      'title'     => __('Styling', 'petsitter'),
      'icon'      => 'el-icon-tint',
      'fields'    => array(
        array(
          'id'        => 'petsitter__colors',
          'type'      => 'image_select',
          'compiler'  => false,
          'presets'   => true,
          'title'     => __('Color Presets', 'petsitter'),
          'desc'      => __('Choose color preset you want to use.', 'petsitter'),
          'options'   => array(
            '1' => array(
              'alt' => 'Green',
              'img' => get_template_directory_uri() . '/images/admin/color-green.png',
              'presets' => array(
                'theme-color1' => '#a6ce39'
              )
            ),
            '2' => array(
              'alt' => 'Blue',
              'img' => get_template_directory_uri() . '/images/admin/color-blue.png',
              'presets' => array(
                'theme-color1' => '#3498db'
              )
            ),
            '3' => array(
              'alt' => 'Red',
              'img' => get_template_directory_uri() . '/images/admin/color-red.png',
              'presets' => array(
                'theme-color1' => '#dc2a0b'
              )
            ),
            '4' => array(
              'alt' => 'Orange',
              'img' => get_template_directory_uri() . '/images/admin/color-orange.png',
              'presets' => array(
                'theme-color1' => '#f39c12'
              )
            ),
            '5' => array(
              'alt' => 'Yellow',
              'img' => get_template_directory_uri() . '/images/admin/color-yellow.png',
              'presets' => array(
                'theme-color1' => '#f1c40f'
              )
            ),
            '6' => array(
              'alt' => 'Violet',
              'img' => get_template_directory_uri() . '/images/admin/color-violet.png',
              'presets' => array(
                'theme-color1' => '#9b59b6'
              )
            ),
            '7' => array(
              'alt' => 'Silver',
              'img' => get_template_directory_uri() . '/images/admin/color-silver.png',
              'presets' => array(
                'theme-color1' => '#bdc3c7'
              )
            ),
            '8' => array(
              'alt' => 'Asbestos',
              'img' => get_template_directory_uri() . '/images/admin/color-asbestos.png',
              'presets' => array(
                'theme-color1' => '#7f8c8d'
              )
            )
          )
        ),
        array(
          'id'          => 'theme-color1',
          'type'        => 'color',
          'title'       => __('Primary Color', 'petsitter'),
          'subtitle'    => __('Pick a primary color.', 'petsitter'),
          'default'     => '#a6ce39',
          'validate'    => 'color',
          'transparent' => false
        ),
        array(
          'id'          => 'theme-color3',
          'type'        => 'color',
          'title'       => __('Secondary Color', 'petsitter'),
          'subtitle'    => __('Pick a primary color.', 'petsitter'),
          'default'     => '#00adef',
          'validate'    => 'color',
          'transparent' => false
        ),


        array(
          'id'    => 'opt-divide00',
          'type'  => 'divide'
        ),


        array(
          'id'        => 'petsitter__layout',
          'type'      => 'select',
          'title'     => __('Layout Mode', 'petsitter'),
          'desc'      => __('Choose your site\'s layout either Boxed or Full Width', 'petsitter'),
          'options'   => array(
            '1' => 'Full Width',
            '2' => 'Boxed'
          ),
          'default'   => '1'
        ),

        array(
          'id'        => 'petsitter__layout-spacing',
          'type'      => 'spacing',
          'output'    => array('.site-wrapper.site-wrapper__boxed'),
          'mode'      => 'margin',
          'all'       => false,
          'left'      => false,
          'right'     => false,
          'units'     => 'px',
          'title'     => __('Wrapper Top/Bottom Margin', 'petsitter'),
          'desc'      => __('You can set top and bottom margin for the site wrapper.', 'petsitter'),
          'default'       => array(
            'margin-top'     => '20px',
            'margin-bottom'  => '20px'
          ),
          'required'  => array('petsitter__layout', '=', '2'),
        ),
        array(
          'id'        => 'petsitter__layout-border-radius',
          'type'      => 'spinner',
          'title'     => __('Wrapper Border Radius', 'petsitter'),
          'desc'      => __('You can set border radius for the site wrapper.', 'petsitter'),
          'default'   => '0',
          'min'       => '0',
          'step'      => '1',
          'max'       => '40',
          'required'  => array('petsitter__layout', '=', '2'),
        ),

        array(
          'id'    => 'opt-divide01',
          'type'  => 'divide'
        ),

        array(
          'id'          => 'body-bg',
          'type'        => 'background',
          'output'      => array('body'),
          'title'       => __('Body Background', 'petsitter'),
          'desc'        => __('Pick a background color. Also you can upload and set up background image.', 'petsitter'),
          'preview'     => true,
          'transparent' => false,
          'default'     => array(
            'background-color' => '#fafafa',
          ),
          'hint'        => array(
            //'title'   => '',
            'content'   => __( 'Enable Boxed layout to see changes.', 'petsitter' ),
          )
        ),

        array(
          'id'          => 'petsitter__holder-bg',
          'type'        => 'background',
          'output'      => array('.site-wrapper'),
          'title'       => __('Content Background', 'petsitter'),
          'desc'        => __('Pick a background color for the content. Also you can upload and set up background image.', 'petsitter'),
          'preview'     => true,
          'transparent' => false,
          'default'     => array(
            'background-color' => '#fafafa',
          ),
          'hint'        => array(
            //'title'   => '',
            'content'   => __( 'Enable Boxed layout to see changes.', 'petsitter' ),
          )
        ),

        array(
          'id'                    => 'top-bar_bg',
          'type'                  => 'background',
          'output'                => array('.header-top'),
          'title'                 => __('Header Top Background Color', 'petsitter'),
          'subtitle'              => __('Background color for Header Top Bar', 'petsitter'),
          'preview'               => false,
          'transparent'           => false,
          'background-size'       => false,
          'background-repeat'     => false,
          'background-attachment' => false,
          'background-position'   => false,
          'background-image'      => false,
          'default'               => array(
            'background-color' => '#2e2e2e',
          ),
        ),

        array(
          'id'                    => 'header-main_bg',
          'type'                  => 'background',
          'output'                => array('.header-main'),
          'title'                 => __('Header Middle Background Color', 'petsitter'),
          'subtitle'              => __('Background color for Header Middle Part', 'petsitter'),
          'preview'               => false,
          'transparent'           => false,
          'background-size'       => false,
          'background-repeat'     => false,
          'background-attachment' => false,
          'background-position'   => false,
          'background-image'      => false,
          'default'               => array(
            'background-color' => '#fff',
          ),
        ),

        array(
          'id'          => 'petsitter_header-middle-text-color',
          'type'        => 'color',
          'output'      => array('.head-info'),
          'title'       => __('Header Middle Text Color', 'petsitter'),
          'subtitle'    => __('Pick a text color for Header Middle.', 'petsitter'),
          'desc'        => __('This option applied on Phone number by default', 'petsitter'),
          'default'     => '#8c8c8c',
          'validate'    => 'color',
          'transparent' => false
        ),

        array(
          'id'          => 'petsitter_header-middle-label-color',
          'type'        => 'color',
          'output'      => array('.head-info .head-info-list > li > span'),
          'title'       => __('Header Middle Label Color', 'petsitter'),
          'subtitle'    => __('Pick a label color for Header Middle.', 'petsitter'),
          'desc'        => __('This option applied on label by default (Phone Title, Email Title)', 'petsitter'),
          'default'     => '#454545',
          'validate'    => 'color',
          'transparent' => false
        ),

        array(
          'id'                    => 'navbar_bg',
          'type'                  => 'background',
          'output'                => array('.header-menu-fullw .nav-main'),
          'title'                 => __('Navbar Background Color', 'petsitter'),
          'subtitle'              => __('Background color for Navigation Bar', 'petsitter'),
          'preview'               => false,
          'transparent'           => false,
          'background-size'       => false,
          'background-repeat'     => false,
          'background-attachment' => false,
          'background-position'   => false,
          'background-image'      => false,
          'default'               => array(
            'background-color' => '#fff',
          ),
        ),

        array(
          'id'    => 'opt-divide1',
          'type'  => 'divide'
        ),


        array(
          'id'          => 'page-header-bg',
          'type'        => 'background',
          'output'      => array('.page-heading'),
          'title'       => __('Page Header Background', 'petsitter'),
          'subtitle'    => __('Page Header background options.', 'petsitter'),
          'preview'     => true,
          'transparent' => false,
          'default'     => array(
            'background-color'      => '#b4b4b4',
            'background-image'      => get_template_directory_uri() . '/images/samples/bg1.jpg',
            'background-repeat'     => 'repeat',
            'background-position'   => 'center top',
            'background-attachment' => 'fixed',
            'background-size'       => 'inherit',
          )
        ),
        array(
          'id'        => 'petsitter__page-header-parallax-bg',
          'type'      => 'switch',
          'title'     => __('Page Header Background Parallax', 'petsitter'),
          'subtitle'  => __('Enables parallax effect for background.', 'petsitter'),
          'default'   => 1,
          'on'        => 'On',
          'off'       => 'Off',
          'hint'        => array(
            'content'   => __( 'Only works with Image based background for <strong>Page Header Background</strong> option', 'petsitter' ),
          )
        ),
        array(
          'id'            => 'petsitter__page-header-parallax-ratio',
          'type'          => 'slider',
          'title'         => __('Parallax Ratio', 'petsitter'),
          'subtitle'      => __('Parallax Ratio for Page Header Background.', 'petsitter'),
          'desc'          => __('The ratio is relative to the natural scroll speed, so a ratio of 0.5 would cause the element to scroll at half-speed, a ratio of 1 would have no effect, and a ratio of 2 would cause the element to scroll at twice the speed.', 'petsitter'),
          'default'       => 0.5,
          'min'           => 0.0,
          'step'          => 0.1,
          'max'           => 2,
          'resolution'    => 0.1,
          'display_value' => 'label',
          'required'      => array('petsitter__page-header-parallax-bg', '=', '1'),
          'hint'        => array(
            'content'   => __( 'Make sure that your image has enought height.', 'petsitter' ),
          )
        ),

        array(
          'id'          => 'petsitter__slider-bg',
          'type'        => 'background',
          'output'      => array('.slider-holder'),
          'title'       => __('Slider Background', 'petsitter'),
          'subtitle'    => __('Background for slider.', 'petsitter'),
          'desc'        => __('Pick a background color. Also you can upload and set up background image.', 'petsitter'),
          'preview'     => true,
          'transparent' => false,
          'default'     => array(
            'background-color'      => '#b4b4b4',
            'background-image'      => get_template_directory_uri() . '/images/samples/bg1.jpg',
            'background-repeat'     => 'repeat',
            'background-position'   => 'center top',
            'background-attachment' => 'fixed',
            'background-size'       => 'inherit',
          ),
        ),

        array(
          'id'        => 'petsitter__slider-parallax-bg',
          'type'      => 'switch',
          'title'     => __('Slider Background Parallax', 'petsitter'),
          'subtitle'  => __('Enables parallax effect for background.', 'petsitter'),
          'default'   => 1,
          'on'        => 'On',
          'off'       => 'Off',
          'hint'        => array(
            'content'   => __( 'Only works with Image based background for <strong>Slider Background</strong> option', 'petsitter' ),
          )
        ),
        array(
          'id'            => 'petsitter__slider-parallax-ratio',
          'type'          => 'slider',
          'title'         => __('Parallax Ratio', 'petsitter'),
          'subtitle'      => __('Parallax Ratio for Slider Background.', 'petsitter'),
          'desc'          => __('The ratio is relative to the natural scroll speed, so a ratio of 0.5 would cause the element to scroll at half-speed, a ratio of 1 would have no effect, and a ratio of 2 would cause the element to scroll at twice the speed.', 'petsitter'),
          'default'       => 0.5,
          'min'           => 0.0,
          'step'          => 0.1,
          'max'           => 2,
          'resolution'    => 0.1,
          'display_value' => 'label',
          'required'      => array('petsitter__slider-parallax-bg', '=', '1'),
          'hint'        => array(
            'content'   => __( 'Make sure that your image has enought height.', 'petsitter' ),
          )
        ),


        array(
          'id'    => 'opt-divide4',
          'type'  => 'divide'
        ),

        array(
          'id'          => 'footer-bg',
          'type'        => 'background',
          'output'      => array('.footer, #back-top a .fa'),
          'title'       => __('Footer Background', 'petsitter'),
          'subtitle'    => __('Footer background options.', 'petsitter'),
          'preview'     => true,
          'transparent' => false,
          'default'     => array(
            'background-color' => '#454545',
          ),
        ),
        array(
          'id'                    => 'footer-copyright_bg',
          'type'                  => 'background',
          'output'                => array('.footer-copyright'),
          'title'                 => __('Copyright Background', 'petsitter'),
          'subtitle'              => __('Background color for Copyright Bar in the Footer', 'petsitter'),
          'preview'               => false,
          'transparent'           => false,
          'background-size'       => false,
          'background-repeat'     => false,
          'background-attachment' => false,
          'background-position'   => false,
          'background-image'      => false,
          'default'               => array(
            'background-color' => '#2e2e2e',
          ),
        ),
        array(
          'id'          => 'footer-text-color',
          'type'        => 'color',
          'output'      => array('.footer-copyright'),
          'title'       => __('Copyright Text Color', 'petsitter'),
          'subtitle'    => __('Pick a Footer text color.', 'petsitter'),
          'default'     => '#8c8c8c',
          'validate'    => 'color',
          'transparent' => false
        ),
      )
    ) );


    Redux::setSection( $opt_name, array(
      'icon'      => 'el-icon-briefcase',
      'title'     => __('Jobs/Resumes', 'petsitter'),
      'id'        => 'petsitter__jobs_resumes',
    ) );


    // WP Job Manager
    Redux::setSection( $opt_name, array(
      'title'  => __( 'WP Job Manager', 'petsitter' ),
      'id'     => 'petsitter__subsection-wp-job-manager',
      'subsection' => true,
      'fields' => array(
        array(
          'id'        => 'petsitter__job-manager-login-page',
          'type'      => 'select',
          'data'      => 'pages',
          'title'     => __('Job Login Page', 'petsitter'),
          'subtitle'  => __('Login page on your site.', 'petsitter'),
          'desc'      => __('Choose a page where you paste <code>[clean-login]</code> shortcode.', 'petsitter'),
        ),
        array(
          'id'        => 'petsitter__single-job-sidebar',
          'type'      => 'image_select',
          'compiler'  => true,
          'title'     => __('Single Job Sidebar Position', 'petsitter'),
          'subtitle'  => __('Select sidebar alignment or disable it.', 'petsitter'),
          'desc'      => __('Right Sidebar, Left Sidebar or Full Width Page.', 'petsitter'),
          'options'   => array(
              '1' => array(
                'alt' => 'Right Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
              '2' => array(
                'alt' => 'Left Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
              '3' => array(
                'alt' => 'No Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/1col.png')
          ),
          'default'   => '1'
        ),
        array(
          'id'        => 'petsitter__employer-placeholder',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('Employer\'s Placeholder Image', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('This image used if employer didn\'t upload his cover image.', 'petsitter'),
          'default'   => array(
            'url'     => get_template_directory_uri() . '/images/job-placeholder.gif'),
          'width'     => '',
          'height'    => '',
        ),
        array(
          'id'    => 'opt-contact-divider2',
          'type'  => 'divide'
        ),
        array(
          'id'        => 'petsitter__form-jobs-field-keywords',
          'type'      => 'text',
          'title'     => __('Keywords - Placeholder Text', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Keywords</em> field.', 'petsitter'),
          'default'   => __('Keywords', 'petsitter'),
        ),
        array(
          'id'        => 'petsitter__form-jobs-field-location',
          'type'      => 'text',
          'title'     => __('Location - Placeholder Text', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Location</em> field.', 'petsitter'),
          'default'   => __('Any location', 'petsitter'),
        ),
        array(
          'id'        => 'petsitter__form-jobs-field-category',
          'type'      => 'text',
          'title'     => __('Categories - Placeholder Text', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Categories</em> field.', 'petsitter'),
          'default'   => __('Any category', 'petsitter'),
        ),
      )
    ) );


    // Resume Manager
    Redux::setSection( $opt_name, array(
      'title'  => __( 'Resume Manager', 'petsitter' ),
      'id'     => 'petsitter__subsection-resume-manager',
      'subsection' => true,
      'fields' => array(
        array(
          'id'        => 'petsitter_opt-resume-manager-notice',
          'type'      => 'info',
          'notice'    => true,
          'icon'      => 'el el-icon-info-circle',
          'style'     => 'info',
          'title'     => __('Resume Manager', 'rocket'),
          'desc'      => __('The following options are only available if you are using <a href="https://wpjobmanager.com/add-ons/resume-manager/">Resume Manager</a> add-on.', 'rocket')
        ),
        array(
          'id'        => 'petsitter__resume-manager-login-page',
          'type'      => 'select',
          'data'      => 'pages',
          'title'     => __('Resume Login Page', 'petsitter'),
          'subtitle'  => __('Login page on your site.', 'petsitter'),
          'desc'      => __('Choose a page where you paste <code>[clean-login]</code> shortcode.', 'petsitter'),
        ),
        array(
          'id'        => 'petsitter__single-resume-sidebar',
          'type'      => 'image_select',
          'compiler'  => true,
          'title'     => __('Single Resume Sidebar Position', 'petsitter'),
          'subtitle'  => __('Select sidebar alignment or disable it.', 'petsitter'),
          'desc'      => __('Right Sidebar, Left Sidebar or Full Width Page.', 'petsitter'),
          'options'   => array(
              '1' => array(
                'alt' => 'Right Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
              '2' => array(
                'alt' => 'Left Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
              '3' => array(
                'alt' => 'No Sidebar',
                'img' => ReduxFramework::$_url . 'assets/img/1col.png')
          ),
          'default'   => '1',
          'hint'        => array(
            'content'   => __( 'Requires \'Resume Manager\' add-on', 'petsitter' ),
          )
        ),
        array(
          'id'        => 'petsitter__candidate-placeholder',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('Candidate\'s Placeholder Image', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('This image used if candidate didn\'t upload his cover image.', 'petsitter'),
          'default'   => array(
            'url'     => get_template_directory_uri() . '/images/user-placeholder.gif'),
          'width'     => '',
          'height'    => '',
          'hint'        => array(
            'content'   => __( 'Requires \'Resume Manager\' add-on', 'petsitter' ),
          )
        ),
        array(
          'id'    => 'opt-contact-divider2',
          'type'  => 'divide'
        ),
        array(
          'id'        => 'petsitter__form-resumes-field-keywords',
          'type'      => 'text',
          'title'     => __('Keywords - Placeholder Text', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Keywords</em> field.', 'petsitter'),
          'default'   => __('Keywords', 'petsitter'),
        ),
        array(
          'id'        => 'petsitter__form-resumes-field-location',
          'type'      => 'text',
          'title'     => __('Location - Placeholder Text', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Location</em> field.', 'petsitter'),
          'default'   => __('Any location', 'petsitter'),
        ),
        array(
          'id'        => 'petsitter__form-resumes-field-category',
          'type'      => 'text',
          'title'     => __('Categories - Placeholder Text', 'petsitter'),
          'subtitle'  => __('Placeholder text.', 'petsitter'),
          'desc'      => __('Change placeholder text for <em>Categories</em> field.', 'petsitter'),
          'default'   => __('Any category', 'petsitter'),
        ),
      )
    ) );




    // Coming Soon
    Redux::setSection( $opt_name, array(
      'title'     => __('Coming Soon', 'petsitter'),
      'icon'      => 'el-icon-warning-sign',
      'fields'    => array(
        array(
          'id'        => 'petsitter__coming-soon-logo',
          'type'      => 'media',
          'url'       => true,
          'title'     => __('Logo', 'petsitter'),
          'compiler'  => 'true',
          //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
          'desc'      => __('Upload your image logo.', 'petsitter'),
          'default'   => array(
            'url'     => get_template_directory_uri() . '/images/logo-alt.png'),
          'width'     => '',
          'height'    => '',
        ),
        array(
          'id'        => 'petsitter__coming-soon-page-title',
          'type'      => 'text',
          'title'     => __('Page Title', 'petsitter'),
          'desc'      => __('Enter short text for Coming Soon Page.', 'petsitter'),
          'validate'  => 'not_empty',
          'msg'       => 'Fill Coming Soon Page Title',
          'default'   => 'Our Site is launching soon...'
        ),
        array(
          'id'        => 'petsitter__coming-soon-description',
          'type'      => 'editor',
          'title'     => __('Short Description', 'petsitter'),
          'desc'      => __('Add short description here.', 'petsitter'),
          'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer quis congue eros. Quisque sagittis volutpat metus nec tristique. justo, id egestas ligula fringilla interdum. Suspendisse id justo non nibh volutpat faucibus et vel justo.',
          'compiler'  => true,
          'args'      => array(
            'teeny'         => true,
            'media_buttons' => false,
            'quicktags'     => true,
            'textarea_rows' => 2,
          )
        ),
        array(
          'id'          => 'petsitter__coming-soon-date',
          'type'        => 'date',
          'title'       => __('Site Launch Date', 'petsitter'),
          'desc'        => __('Choose the date when your will be available.', 'petsitter'),
          'placeholder' => __( 'Click to enter a date', 'petsitter' ),
          'default'     => '12/31/2015'
        ),
        array(
          'id'        => 'petsitter__coming-soon-contact-form',
          'type'      => 'text',
          'title'     => __('Contact Form Shortcode', 'petsitter'),
          'desc'      => __('Put your form created with <em>Contact Form 7</em> plugin.', 'petsitter')
        ),
      )
    ) );




    // Custom CSS
    Redux::setSection( $opt_name, array(
      'title'     => __('Custom CSS', 'petsitter'),
      'icon'      => 'el-icon-css',
      'fields'    => array(
        array(
          'id'        => 'ace-editor-css',
          'type'      => 'ace_editor',
          'title'     => __('CSS Code', 'petsitter'),
          'subtitle'  => __('Paste your CSS code here.', 'petsitter'),
          'mode'      => 'css',
          'theme'     => 'monokai',
          'desc'      => 'Any custom CSS can be added here, it will override the theme CSS.',
          'default'   => ""
        ),
      )
    ) );

    Redux::setSection( $opt_name, array(
      'title'     => __('Import / Export', 'petsitter'),
      'desc'      => __('Import and Export your theme settings from file, text or URL.', 'petsitter'),
      'icon'      => 'el-icon-refresh',
      'fields'    => array(
        array(
          'id'            => 'opt-import-export',
          'type'          => 'import_export',
          'full_width'    => false,
        ),
      ),
    ) );

    if (file_exists(dirname(__FILE__) . '/../readme.txt')) {
      Redux::setSection( $opt_name, array(
      'icon'      => 'el-icon-list-alt',
      'title'     => __('Theme Information', 'petsitter'),
      'fields'    => array(
        array(
          'id'        => '17',
          'type'      => 'raw',
          'markdown'  => true,
          'content'   => file_get_contents(dirname(__FILE__) . '/../readme.txt')
        ),
      ),
    ) );
  }
