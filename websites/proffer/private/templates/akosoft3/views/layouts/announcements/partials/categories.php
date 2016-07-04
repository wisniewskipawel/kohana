<?php
/** @var Model_Announcement_Category $category */
?>
<ul class="nav nav-pills nav-stacked">
	<?php foreach($categories as $category): 
		$is_active_category=(isset($current_category) && $current_category == $category->category_id);
		$is_expanded_category = (isset($current_category) 
			AND $category->category_left < $current_category->category_left 
			AND $category->category_right > $current_category->category_right);
	?>
	<li id="category-<?php echo $category->category_id ?>" class="<?php if($is_active_category) echo ' active '; if($is_expanded_category) echo ' expanded '; ?>">
		
		<a href="<?php 
		echo Route::url('site_announcements/frontend/announcements/category', array(
			'category_id' => $category->category_id, 
			'title' => URL::title($category->category_name)
		)).URL::query(array(
			'city' => !empty($query['city']) ?$query['city'] : NULL,
			'province' => !empty($query['province']) ?$query['province'] : NULL,
		), FALSE);
		?>" title="<?php echo HTML::chars($category->category_name) ?>">
			<?php if($image = Model_Announcement_Category::get_image_path($category->category_id))
				echo HTML::image($image, array('alt' => $category->category_name)) ?>
			<?php echo $category->category_name ?>
			<span class="counter">(<?php echo $category->count_announcements ?>)</span>
		</a>
		
		<?php if(!empty($category->subcategories)): ?>
		<?php echo View::factory('layouts/announcements/partials/categories')->set('categories', $category->subcategories); ?>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>