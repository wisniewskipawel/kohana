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
			<?php echo Form::checkbox('categories[]', $c->category_id, (is_array($checked) AND in_array($c->category_id, $checked))) ?>
			<?php echo $c->category_name ?>
		</label>
		
		<?php if(count($c->subcategories)): ?>
		<?php $j = 1; ?>
		<ul class="subcategories">
			<?php $count_subcat = count($c->subcategories); foreach($c->subcategories as $index => $subcat): ?>
				<li<?php if ($j === 1): ?> class="first"<?php endif ?><?php if ($j === 5 OR ($j < 5 AND $j === $count_subcat)): ?> class="last"<?php endif ?> id="menu_category-<?php echo $subcat->category_id ?>-0" <?php if ($j > 5): ?>style="display: none;"<?php endif ?>>
					<?php echo Form::checkbox('categories[]', $subcat->category_id, (is_array($checked) AND in_array($subcat->category_id, $checked))) ?>
					<span class="category_name"><?php echo $subcat->category_name ?></span>
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

