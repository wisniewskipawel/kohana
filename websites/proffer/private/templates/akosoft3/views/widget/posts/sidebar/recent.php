<div id="posts_sidebar_recent_box" class="box">
	<div class="box-header">
		<?php echo ___('posts.boxes.sidebar_recent.title') ?>
	</div>
	<div class="box-content">
		<?php if(count($posts)): ?>
			<ul class="posts_recent_list">
				<?php
				foreach($posts as $post):
					$post_link = URL::site(Posts::uri($post));
					$link_attr =  $post->is_feed_item() ? HTML::attributes(array(
						'target' => '_blank',
					)) : '';
				?>
					<li>
						<div class="image-wrapper">
							<a href="<?php echo $post_link?>"<?php echo $link_attr ?>>
								<?php $image = $post->get_images(1, 'post_lead');
								if($post->is_feed_item() AND $post->feed_item_image): ?>
									<img src="<?php echo $post->feed_item_image ?>" alt="" />
								<?php elseif($image && img::image_exists('posts', 'post_list', $image['image_id'], $image['image'])): ?>
									<img src="<?php echo img::path('posts', 'post_list', $image['image_id'], $image['image']) ?>" alt="" />
								<?php else: ?>
									<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
								<?php endif; ?>
							</a>
						</div>
						<div class="details">
							<a href="<?php echo  $post_link?>"<?php echo $link_attr ?> class="title">
								<?php if($post->is_urgent()): ?>
									<div class="urgent_info"><?php echo ___('posts.lists.urgent') ?></div>
								<?php endif; ?>

								<?php echo HTML::chars($post->title) ?>
							</a>
							<div class="date_added">
								<?php echo date('d.m.Y', strtotime($post->date_added)) ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php echo HTML::anchor(
				Route::get('site_posts/frontend/posts/recent')->uri(),
				___('posts.boxes.sidebar_recent.more_btn'),
				array(
					'class' => 'more_btn',
				)
			); ?>

		<?php else: ?>
			<div class="no_results"><?php echo ___('posts.lists.no_results') ?></div>
		<?php endif; ?>
		
	</div>
</div>