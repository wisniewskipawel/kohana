<?php 
$categories = $driver->data('categories');
$checked = $driver->get_value();
?>
<a href="#" class="check-all-btn"><?php echo ___('notifiers.check_all') ?></a>
<div class="categories">
	<?php foreach ($categories as $index => $c): ?>
	<label>
		<?php echo Form::checkbox('categories[]', $c->pk(), (is_array($checked) AND in_array($c->pk(), $checked))) ?>
		<span class="category_name"><?php echo $c->category_name ?></span>
	</label>
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