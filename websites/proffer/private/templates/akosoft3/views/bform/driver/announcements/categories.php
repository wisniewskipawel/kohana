<?php 
$i = 0; 
$opened = array(); 
$categories = $driver->data('categories');
$checked = $driver->get_value();
?>
<a href="#" class="check-all-btn"><?php echo ___('notifiers.check_all') ?></a>
<div class="categories categories_grid">
	
	<?php foreach ($categories as $c): ?>
	<div class="category">
		<label class="main_category">
			<?php echo Form::checkbox('categories[]', $c->pk(), (is_array($checked) AND in_array($c->pk(), $checked))) ?>
			<?php echo $c->category_name ?>
		</label>
		
		<?php if ( ! is_null($c->descendants_ids) AND ! is_null($c->descendants_names)):
			$descendants_ids = explode('||', $c->descendants_ids);
			$descendants_names = explode('||', $c->descendants_names);
			$descendants_has_children = explode('||', $c->descendants_has_children);

		?>
		<?php $j = 1; ?>
		<ul class="subcategories">
			<?php foreach ($descendants_ids as $index => $id): ?>
			<li <?php if ($j > 5): ?>style="display: none;"<?php endif ?>>
				<label>
					<?php echo Form::checkbox('categories[]', $descendants_ids[$index], (is_array($checked) AND in_array($descendants_ids[$index], $checked))) ?>
					<span class="category_name"><?php echo $descendants_names[$index] ?></span>
				</label>
			</li>
			<?php $j++ ?>
			<?php endforeach ?>
		</ul>

		<?php if ($j > 6): ?>
		<a href="#" class="show_more_btn"><span><?php echo ___('more') ?></span></a>
		<?php endif ?>
		
		<?php endif ?>
	</div>
	<?php endforeach ?>
	
</div>

<script>
$(document).ready(function() {
	$(".check-all-btn").click(function(e) {
		e.preventDefault();
		$(".categories input[type=checkbox]").attr('checked', 'checked');
	});
});
</script>
