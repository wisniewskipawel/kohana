<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

if(count($posts)): ?>
<ul class="posts_list_rows_small">
	<li class="featured">
		<?php 
		$post = $posts->current(); 
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
	<?php $posts->next(); while($post = $posts->current()): 
		$post_link = URL::site(Posts::uri($post));
		$link_attr =  $post->is_feed_item() ? HTML::attributes(array(
			'target' => '_blank',
		)) : '';
	?>
	<li>
		<a href="<?php echo $post_link ?>"<?php echo $link_attr ?> class="title">
			<?php if($post->is_urgent()): ?>
			<div class="urgent_info"><?php echo ___('posts.lists.urgent') ?></div>
			<?php endif; ?>
			
			<?php echo HTML::chars($post->title) ?>
		</a>
	</li>
	<?php $posts->next(); endwhile; ?>
</ul>
<?php else: ?>
<div class="no_results"><?php echo ___('posts.lists.no_results') ?></div>
<?php endif; ?>
