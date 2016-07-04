<div id="widget_forum_threads_active" class="box">
	<div class="box-header"><?php echo ___('forum.boxes.threads_active.title') ?></div>
	<div class="content">
		
		<div class="post-contents">
			<?php echo View::factory('forum/lists/threads/list_simple')
				->set('threads', $threads)
			?>

			<?php echo HTML::anchor(
				Route::get('site_forum/home')->uri(),
				___('forum.boxes.threads_active.more_btn'),
				array(
					'class' => 'more_btn'
				)
			) ?>
		</div>
		
	</div>
</div>
