<div id="widget_posts_main_popular_box" class="box gray col-md-6">
	<div class="box-header">
		<span><?php echo ___('posts.boxes.main_popular.title') ?></span>
		<a class="more_btn" href="<?php echo Route::url('site_posts/frontend/posts/recent') ?>"><?php echo ___('posts.boxes.main_popular.see_all_btn') ?></a>
	</div>
	<div class="content">
		
		<?php echo View::factory('frontend/posts/partials/list/rows_small')
			->set('posts', $posts)
		?>
		
	</div>
</div>