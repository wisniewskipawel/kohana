<?php

add_action('widgets_init', 'petsitter_tabs_load_widgets');

function petsitter_tabs_load_widgets(){
	register_widget('Petsitter_Tabs_Widget');
}

class Petsitter_Tabs_Widget extends WP_Widget {
	
	function __construct() {

		$widget_ops = array(
			'classname' => 'tabbed-widget',
			'description' => __('Popular posts, Recent Post and Comments.', 'petsitter')
		);

		$control_ops = array('id_base' => 'petsitter_tabs-widget');

		parent::__construct('petsitter_tabs-widget', 'PetSitter - Tabs', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		global $data, $post;
		
		extract($args);
		
		$posts = $instance['posts'];
		$comments = $instance['comments'];
		$recent_posts = $instance['recent_posts'];
		$orderby = $instance['orderby'];

		if(!$orderby) {
			$orderby = 'Highest Comments';
		}

		echo $before_widget;
		?>
		<div class="tabs">

			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-popular" data-toggle="tab"><?php echo __('Popular', 'petsitter'); ?></a></li>
				<li><a href="#tab-recent" data-toggle="tab"><?php echo __('Recent', 'petsitter'); ?></a></li>
				<li><a href="#tab-comments" data-toggle="tab"><i class="fa fa-comments fa-lg"></i></a></li>
			</ul>

			<div class="tab-content">

				<div id="tab-popular" class="tab-pane fade in active">
					<?php
					if($orderby == 'Highest Comments') {
						$order_string = '&orderby=comment_count';
					} else {
						$order_string = '&meta_key=petsitter_post_views_count&orderby=meta_value_num';
					}
					$popular_posts = new WP_Query('showposts='.$posts.$order_string.'&order=DESC');
					if($popular_posts->have_posts()): ?>
					<ul class="latest-posts-list">
						<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
						<li>
							<?php if(has_post_thumbnail()): ?>
							<figure class="thumbnail">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('xsmall'); ?>
								</a>
							</figure>
							<?php endif; ?>
							<div class="post-item-holder">
								<div class="meta">
									<?php the_time(get_option('date_format')); ?>
								</div>
								<h5 class="title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h5>
							</div>
						</li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>
				</div>

				<div id="tab-recent" class="tab-pane fade">
					<?php
					$recent_posts = new WP_Query('showposts='.$posts);
					if($recent_posts->have_posts()):
					?>
					<ul class="latest-posts-list">
						<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
						<li>
							<?php if(has_post_thumbnail()): ?>
							<figure class="thumbnail">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('xsmall'); ?>
								</a>
							</figure>
							<?php endif; ?>
							<div class="post-item-holder">
								<div class="meta">
									<?php the_time(get_option('date_format')); ?>
								</div>
								<h5 class="title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h5>
							</div>
						</li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>
				</div>

				<div id="tab-comments" class="tab-pane fade">
					<ul class="latest-posts-list">
						<?php
						$number = $instance['comments'];
						global $wpdb;
						$recent_comments = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,110) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number";
						$the_comments = $wpdb->get_results($recent_comments);
						foreach($the_comments as $comment) { ?>
						<li>
							<div class="thumbnail">
								<?php echo get_avatar($comment, '52'); ?>
							</div>
							<div class="post-item-holder">
								<div class="meta"><?php echo strip_tags($comment->comment_author); ?> <?php _e('says', 'petsitter'); ?>:</div>
								<h5 class="title">
									<a class="comment-text-side" href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo $comment->post_title; ?>"><?php echo petsitter_string_limit_words(strip_tags($comment->com_excerpt), 12); ?></a>
								</h5>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>

			</div>
		</div>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['posts'] = $new_instance['posts'];
		$instance['comments'] = $new_instance['comments'];
		$instance['recent_posts'] = $new_instance['recent_posts'];
		$instance['orderby'] = $new_instance['orderby'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'posts' => 3,
			'recent_posts' => 3,
			'comments' => '3',
			'on', 'orderby' => 'Highest Comments'
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">Popular Posts Order By:</label> 
			<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" class="widefat" style="width:100%;">
				<option <?php if ('Highest Comments' == $instance['orderby']) echo 'selected="selected"'; ?>>Highest Comments</option>
				<option <?php if ('Highest Views' == $instance['orderby']) echo 'selected="selected"'; ?>>Highest Views</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php echo _e('Number of popular posts:', 'petsitter') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('recent_posts'); ?>"><?php echo _e('Number of recent posts:', 'petsitter') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('recent_posts'); ?>" name="<?php echo $this->get_field_name('recent_posts'); ?>" value="<?php echo $instance['recent_posts']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('comments'); ?>"><?php echo _e('Number of comments:', 'petsitter') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" value="<?php echo $instance['comments']; ?>" />
		</p>
	<?php }
}

