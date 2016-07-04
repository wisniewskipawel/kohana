<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

$post_link = URL::site(Posts::uri($post), 'http');
?>
<div id="post_show_box" class="box primary" itemscope itemtype="http://schema.org/Article">
	<h2 itemprop="name"><?php echo HTML::chars($post->title) ?></h2>
	<div class="box-content">
		
		<div class="details">
			
			<span class="date_added">
				<?php echo ___('posts.lists.added') ?>: <?php echo Date::fuzzy_span(strtotime($post->date_added)) ?>
			</span>

			<span class="visits">
				<?php echo ___('posts.lists.visits') ?>: <?php echo (int)$post->visits ?>
			</span>
			
			<?php if($post->author): ?>
			<span class="author">
				<?php echo ___('posts.lists.author') ?>: 
				<span itemprop="author"><?php echo HTML::chars($post->author) ?></span>
			</span>
			<?php endif; ?>
			
			<?php if($post->is_urgent()): ?>
			<div class="urgent_info"><?php echo ___('posts.lists.urgent') ?></div>
			<?php endif; ?>
			
			<?php if($post->show_home): ?>
			<div class="recommend_info"><?php echo ___('posts.lists.recommended') ?></div>
			<?php endif; ?>
			
			<?php if($post->is_user_post): ?>
			<div class="user_post_info"><?php echo ___('posts.lists.user_post') ?></div>
			<?php endif; ?>
			
		</div>
		
		<p class="description_short" itemprop="description">
			<?php echo $post->description_short ?>
		</p>
		
		<?php
		$image_lead = $post->get_images(1, 'post_lead');

		if($image_lead && img::image_exists('posts', 'post_lead', $image_lead['image_id'], $image_lead['image'])): ?>
		<div class="lead_image">
			<img src="<?php echo img::path('posts', 'post_lead', $image_lead['image_id'], $image_lead['image']) ?>" alt="<?php echo HTML::chars($post->title) ?>" itemprop="image" />
		</div>
		<?php endif; ?>
		
		<div class="content text" itemprop="articleBody">
			<?php echo $post->content;?>
		</div>
		
		<div class="meta">
			
			<div class="share pull-left">
				<span class="l"><?php echo ___('share') ?>:</span>
				<?php
				$share = new Share(
					$post_link, 
					$post->title,
					$post->description_short
				);
				
				if($image_lead && img::image_exists('posts', 'post_list', $image_lead['image_id'], $image_lead['image']))
					$share->add_image(URL::site(img::path_uri('posts', 'post_list', $image_lead['image_id'], $image_lead['image']), 'http'));

				echo $share->render();
				?>
			</div>
			
			<?php if($post->source): ?>
			<div class="source pull-right">
				<?php echo ___('posts.lists.source') ?>: <?php echo HTML::chars($post->source) ?>
			</div>
			<?php endif; ?>
		</div>
		
		<?php if($gallery = $post->get_gallery()): ?>
		<div class="gallery">
			<h3><?php echo ___('posts.show.gallery') ?></h3>
			
			<div class="gallery_images">
				
				<?php foreach($gallery as $image): 
					if($image && img::image_exists('posts', 'post_gallery_list', $image['image_id'], $image['image'])): ?>	
				<div class="image-wrapper">
					<a href="<?php echo img::path('posts', 'post_gallery_big', $image['image_id'], $image['image']) ?>">
						<img src="<?php echo img::path('posts', 'post_gallery_list', $image['image_id'], $image['image']) ?>" alt="<?php echo HTML::chars($post->title) ?>" />
					</a>
				</div>
				<?php endif; endforeach; ?>
				
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($comments))
		{
			$comments->form_add_comment->param('layout', 'forms/comments');
			echo $comments;
		}
		?>
		
	</div>
</div>

<?php 
$posts_from_category = ORM::factory('Post')->find_other($post, 4);

if(count($posts_from_category)): ?>
<div id="posts_from_category_box" class="box">
	<div class="box-header"><?php echo ___('posts.boxes.from_category.title') ?></div>
	<div class="content">
		<?php echo View::factory('frontend/posts/partials/list/rows_small')
			->set('posts', $posts_from_category)
		?>
	</div>
</div>
<?php endif; ?>