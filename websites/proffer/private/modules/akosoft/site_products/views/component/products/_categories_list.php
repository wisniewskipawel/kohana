<?php 
$request = Request::initial();
$query = $request->query();
?>
<ul>
	<?php $i = 1 ?>
	<?php foreach ($categories as $c): 
		$is_active_category=(isset($current_category) && $current_category == $c->category_id);
		$is_expanded_category = (isset($current_category) 
			AND $c->category_left < $current_category->category_left 
			AND $c->category_right > $current_category->category_right);
	?>
		<li id="category-<?php echo $c->category_id ?>-<?php echo (int) (bool)$c->has_children ?>" class="<?php if($is_active_category) echo ' active '; if($is_expanded_category) echo ' expanded '; if($i == count($categories)) echo ' last'; ?>">
			<a href="<?php 
			echo Route::url('site_products/frontend/products/category', array(
				'category_id' => $c->category_id, 
				'title' => URL::title($c->category_name)
			)).URL::query(array(
				'city' => !empty($query['city']) ?$query['city'] : NULL,
				'province' => !empty($query['province']) ?$query['province'] : NULL,
			), FALSE);
			?>">
				<?php echo $c->category_name ?>
				<span class="counter">(<?php echo $c->count_products ?>)</span>
			</a>
			<?php if(!empty($c->subcategories)): ?>
			<?php echo View::factory('component/products/_categories_list')->set('categories', $c->subcategories); ?>
			<?php endif; ?>
		</li>
		<?php $i++ ?>
	<?php endforeach ?>
</ul>