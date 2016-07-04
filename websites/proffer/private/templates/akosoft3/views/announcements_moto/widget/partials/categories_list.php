<?php 
$request = Request::initial();
$query = $request->query();
?>
<ul class="nav nav-pills nav-stacked">
	<?php $i = 1 ?>
	<?php foreach ($categories as $c): 
		$is_active_category=(isset($current_category) && $current_category == $c->category_id);
	?>
		<li id="category-<?php echo $c->category_id ?>" class="<?php 
			if($c->category_alias) echo 'category_alias_'.$c->category_alias; 
			if($is_active_category) echo ' active ';
		?>">
			<a href="<?php 
			echo $current_module->route_url('frontend/announcements/category', array(
				'category_id' => $c->category_id, 
				'title' => URL::title($c->category_name)
			)).URL::query(array(
				'city' => !empty($query['city']) ?$query['city'] : NULL,
				'province' => !empty($query['province']) ?$query['province'] : NULL,
			), FALSE);
			?>">
				<?php if($image = $current_module->get_category_icon_manager()->get_uri($c->category_id))
					echo HTML::image($image, array('alt' => $c->category_name)) ?>
				<?php echo $c->category_name ?>
				<span class="counter">(<?php echo $c->count_announcements ?>)</span>
			</a>
		</li>
		<?php $i++ ?>
	<?php endforeach ?>
</ul>