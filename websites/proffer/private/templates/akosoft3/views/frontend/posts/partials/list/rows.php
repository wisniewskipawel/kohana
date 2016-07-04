<ul class="posts_list_rows">
	<?php
	foreach($posts as $post):
		$post_link = URL::site(Posts::uri($post));
		$link_attr =  $post->is_feed_item() ? HTML::attributes(array(
			'target' => '_blank',
		)) : '';
		?>
		<li>
			<div class="post-image">
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

				<?php if($post->is_urgent()): ?>
					<div class="urgent_info"><?php echo ___('posts.lists.urgent') ?></div>
				<?php elseif($post->show_home): ?>
					<div class="recommend_info"><?php echo ___('posts.lists.recommended') ?></div>
				<?php endif; ?>
			</div>

			<div class="details">
				<a href="<?php echo  $post_link?>"<?php echo $link_attr ?> class="title">
					<?php echo HTML::chars($post->title) ?>
				</a>
				<div class="date_added">
					<?php echo date('d.m.Y', strtotime($post->date_added)) ?>
				</div>
				<div class="description">
					<?php echo HTML::chars($post->description_short, FALSE) ?>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
