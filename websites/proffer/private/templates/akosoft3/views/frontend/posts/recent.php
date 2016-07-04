<div id="post_category_box" class="box primary">
	<div class="box-header">
		<h2><?php echo ___('posts.recent.title') ?></h2>
	</div>
	<div class="box-content">
		
		<?php if(count($posts)): ?>
		
		<?php echo $pagination ?>
		
		<?php echo View::factory('frontend/posts/partials/list/rows')
			->set('posts', $posts)
		?>
		
		<?php echo $pagination ?>
		
		<?php else: ?>
		
		<div class="no_results">
			<?php echo ___('posts.lists.no_results') ?>
		</div>
		
		<?php endif; ?>
		
	</div>
</div>