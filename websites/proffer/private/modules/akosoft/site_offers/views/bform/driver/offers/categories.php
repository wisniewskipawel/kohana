<?php 
$i = 0; 
$categories = $driver->data('categories');
$checked = $driver->get_value();
$box_limit = 6; $i = 0; 

foreach (array_chunk($categories->as_array(), $box_limit*3) as $categories_box): ?>
<div class="row">
	<?php foreach (array_chunk($categories->as_array(), $box_limit) as $categories_box): ?>
	<div class="category<?php if ($i % 3 == 2):?> last<?php endif ?>">

		<ul>
			<?php foreach ($categories_box as $index => $c): ?>
				<li id="menu_category-<?php echo $c->category_id ?>-0">
					<span class="category_name"><?php echo $c->category_name ?></span>
					<?php echo Form::checkbox('categories[]', $c->pk(), (is_array($checked) AND in_array($c->pk(), $checked))) ?>
				</li>
			<?php endforeach ?>
		</ul>

	</div>
	<?php $i++ ?>
	<?php endforeach ?>
</div>
<?php endforeach ?>
