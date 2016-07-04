<div id="posts_recommended_box">
	<div class="row">
		<?php foreach(new LimitIterator($posts, 0, 2) as $post): ?>
		<div class="col-sm-6">
			<?php
			$post_link = URL::site(Posts::uri($post));
			$link_attr =  $post->is_feed_item() ? HTML::attributes(array(
				'target' => '_blank',
			)) : '';
			?>
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

				<div class="image-caption">
					<?php if($post->is_urgent()): ?>
					<div class="urgent_info"><?php echo ___('posts.lists.urgent') ?></div>
					<?php endif; ?>
					<?php echo HTML::chars($post->title) ?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>