<?php

add_action('widgets_init', 'latest_load_widgets');

function latest_load_widgets() {
  register_widget('Posts_Widget');
}

class Posts_Widget extends WP_Widget {
  
  function __construct() {

    $widget_ops = array(
      'classname' => 'latest-posts-widget',
      'description' => __('The most recent posts on your site.', 'petsitter')
    );

    $control_ops = array('id_base' => 'latest-posts');

    parent::__construct('latest-posts', 'Petsitter - Recent Posts', $widget_ops, $control_ops);
  }
  
  function widget($args, $instance)
  {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    $postscount = $instance['postscount'];
    $img_size = $instance['img_size'];

    echo $before_widget;

    if($title) {
      echo $before_title.$title.$after_title;
    }
    ?>

    <ul class="latest-posts-list">
      <?php
      $pp = new WP_Query("orderby=date&posts_per_page=".$postscount); ?>
      <?php while ($pp->have_posts()) : $pp->the_post();
      $format = get_post_format();
      ?>
      <li>
        <?php if(has_post_thumbnail() && $img_size != 'none') { ?>
        <!-- begin post image -->
        <figure class="thumbnail">
          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail($img_size, array('class' => 'alignnone')); ?></a>
        </figure>
        <!-- end post image -->
        <?php } ?>
        <div class="meta">
          <?php the_time(get_option('date_format')); ?>
        </div>
        <h5 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
        
      </li>
      <?php endwhile; ?>
    </ul>
    
    <?php
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['postscount'] = $new_instance['postscount'];
    $instance['img_size'] = $new_instance['img_size'];
    
    return $instance;
  }

  function form($instance)
  {
    $defaults = array(
      'title'      => 'Recent Posts',
      'postscount' => 2,
      'img_size'   => 'none'
    );
    $instance = wp_parse_args((array) $instance, $defaults); ?>
    
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'petsitter') ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('postscount'); ?>"><?php echo _e('Number of posts:', 'petsitter') ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('postscount'); ?>" name="<?php echo $this->get_field_name('postscount'); ?>" value="<?php echo $instance['postscount']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('img_size'); ?>"><?php _e('Thumbnail:', 'petsitter'); ?></label> 
      <select id="<?php echo $this->get_field_id('img_size'); ?>" name="<?php echo $this->get_field_name('img_size'); ?>" class="widefat" style="width:100%;">
        <option <?php if ('none' == $instance['img_size']) echo 'selected="selected"'; ?>>none</option>
        <option <?php if ('small' == $instance['img_size']) echo 'selected="selected"'; ?>>small</option>
        <option <?php if ('xsmall' == $instance['img_size']) echo 'selected="selected"'; ?>>xsmall</option>
      </select>
    </p>

  <?php
  }
}
?>