<?php

add_action('widgets_init', 'flickr_load_widgets');

function flickr_load_widgets() {
  register_widget('Flickr_Widget');
}

class Flickr_Widget extends WP_Widget {
  
  function __construct() {

    $widget_ops = array(
      'classname' => 'widget_flickr',
      'description' => __('The most recent images from your flickr account.', 'petsitter')
    );

    $control_ops = array('id_base' => 'flickr-widget');

    parent::__construct( 'flickr-widget', 'Petsitter - Flickr', $widget_ops, $control_ops );

  }
  
  function widget($args, $instance) {

    extract($args);

    $title     = apply_filters('widget_title', $instance['title']);
    $flickr_id = apply_filters('flickr_id', $instance['flickr_id']);
    $count     = $instance['count'];
    $suf       = rand(100000,999999);

    echo $before_widget;

    if($title) {
      echo $before_title.$title.$after_title;
    }
    ?>
    
    <script>
      jQuery(document).ready(function() {
        jQuery('#flickr-<?php echo $suf ?>').jflickrfeed({
          limit: <?php echo esc_attr($count); ?>,
          qstrings: {
            id: '<?php echo esc_attr($flickr_id); ?>'
          },
          itemTemplate: '<li><a href="{{link}}" target="_blank"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
        });
      });
    </script>
    <ul id="flickr-<?php echo esc_attr($suf); ?>" class="flickr-feed"></ul>
    
    <?php
    
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['flickr_id'] = $new_instance['flickr_id'];
    $instance['count'] = $new_instance['count'];
    
    return $instance;
  }

  function form($instance)
  {
    $defaults = array(
      'title' => 'Flickr',
      'flickr_id' => '52617155@N08',
      'count' => 9
    );
    $instance = wp_parse_args((array) $instance, $defaults); ?>
    
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'petsitter') ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php echo _e('ID:', 'petsitter') ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php echo $instance['flickr_id']; ?>" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo _e('Number of images:', 'petsitter') ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
    </p>

  <?php
  }
}