<?php 
$request = Request::initial();
$query = $request->query();
?>
<ul>
	<li class="first <?php echo Route::name($request->route()) == 'site_offers/frontend/offers/index' ? 'active' : NULL ?>">
		<?php 
		echo HTML::anchor(
			Route::get('site_offers/frontend/offers/index')->uri(), 
			___('offers.boxes.categories.all')
		); ?>
	</li>
	<?php $i = 1 ?>
	<?php foreach ($categories as $c): $is_active_category=(isset($current_category) && $current_category == $c->category_id);?>
		<li id="category-<?php echo $c->category_id ?>-<?php echo (int) (bool)$c->has_children ?>" class="<?php if($is_active_category): ?>active<?php endif; ?><?php if ($i == count($categories)): ?> last<?php endif ?>">
			<a href="<?php 
			echo Route::url('site_offers/frontend/offers/category', array(
				'category_id' => $c->category_id, 
				'title' => URL::title($c->category_name)
			)).URL::query(array(
				'city' => !empty($query['city']) ?$query['city'] : NULL,
				'province' => !empty($query['province']) ?$query['province'] : NULL,
			), FALSE);
			?>">
				<?php echo $c->category_name ?>
				<span class="counter">(<?php echo $c->count_offers ?>)</span>
			</a>
			<?php if(!empty($c->subcategories)): ?>
			<?php echo View::factory('component/offers/_categories_list')->set('categories', $c->subcategories); ?>
			<?php endif; ?>
		</li>
		<?php $i++ ?>
	<?php endforeach ?>
</ul>