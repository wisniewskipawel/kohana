<ul class="nav nav-pills nav-stacked">
	<?php foreach($categories as $category): 
		$is_active_category=(isset($current_category) && $current_category == $category->category_id);
	?>
	<li id="category-<?php echo $category->category_id ?>" class="<?php if($is_active_category) echo ' active '; ?>">
		
		<a href="<?php 
		echo Route::url('site_offers/frontend/offers/category', array(
			'category_id' => $category->category_id, 
			'title' => URL::title($category->category_name)
		)).URL::query(array(
			'city' => !empty($query['city']) ?$query['city'] : NULL,
			'province' => !empty($query['province']) ?$query['province'] : NULL,
		), FALSE);
		?>">
			<?php if($image = offers::get_category_icon_manager()->get_uri($category->category_id))
				echo HTML::image($image, array('alt' => $category->category_name)) ?>
			<?php echo $category->category_name ?>
			<span class="counter">(<?php echo $category->count_offers ?>)</span>
		</a>
		
		<?php if(!empty($category->subcategories)): ?>
		<?php echo View::factory('template/partials/categories')->set('categories', $category->subcategories); ?>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>