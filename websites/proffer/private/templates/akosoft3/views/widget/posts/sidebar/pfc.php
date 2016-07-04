<div class="box">
	<div class="box-header">
		<?php echo $category->category_name ?>
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
	<div class="box-content">
		
		<?php echo View::factory('frontend/posts/partials/list/pfc')
			->set('posts', $posts)
			->render()
		?>
		
	</div>
</div>
