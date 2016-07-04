<div class="box posts_category_box">
	<div class="box-header">
		<?php echo HTML::chars($category->category_name) ?>
	</div>
	<div class="box-content">
		
		<div class="posts-container">
			<?php echo View::factory('frontend/posts/partials/list/rows')
				->set('posts', $posts)
				->render()
			?>

			<?php echo HTML::anchor(
				Route::get('site_posts/frontend/posts/category')->uri(array(
					'id' => $category->pk(),
					'name' => URL::title($category->category_name),
				)),
				"Więcej &raquo;",
				array(
					'class' => 'more_btn',
				)
			); ?>
		</div>
		
	</div>
</div>
