<ul>
	<?php foreach ($categories as $c): 
		$is_active_category=(isset($current_category) && $current_category == $c->category_id);
		$is_expanded_category = (isset($current_category) 
			AND $c->category_left < $current_category->category_left 
			AND $c->category_right > $current_category->category_right);
	?>
		<li id="category-<?php echo $c->category_id ?>-<?php echo (int) (bool)$c->has_children ?>" class="<?php if($is_active_category) echo ' active '; if($is_expanded_category) echo ' expanded '; ?>">
			<a href="<?php echo Route::url('site_catalog/frontend/catalog/show_category', array('category_id' => $c->category_id, 'title' => URL::title($c->category_name))).(isset($allow_query_params) ? URL::query() : NULL) ?>">
				<?php echo $c->category_name ?>
				<span class="counter">(<?php echo $c->count_companies ?>)</span>
			</a>
			
			<?php if(!empty($c->subcategories)): ?>
			<?php echo View::factory('component/catalog/_categories_list')->set('categories', $c->subcategories); ?>
			<?php endif; ?>
		</li>
	<?php endforeach ?>
</ul>