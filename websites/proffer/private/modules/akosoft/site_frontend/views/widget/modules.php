<div id="widget_modules_box" class="box">
	<div class="box-header">
		<h2><?php echo ___('boxes.modules.title') ?></h2>
		<ul class="box-actions">
			<?php foreach($modules as $module_data): ?>
			<li><a href="#<?php echo $module_data['name'] ?>" class="active" <?php if(isset($module_data['add_btn'])) echo 'data-add_btn="'.$module_data['add_btn']['url'].'" data-add_btn_title="'.$module_data['add_btn']['title'].'"' ?>><?php echo $module_data['label'] ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="content">
		<?php
		foreach($modules as $module_data)
			echo $module_data['view'];
		?>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$('#widget_modules_box .box-actions a').on('click', add_more_btn);
	$('#widget_modules_box .box-actions a:first').each(add_more_btn);
	
	function add_more_btn() {
		var $trigger = $(this);
		$('#widget_modules_box .box-header .more_btn').remove();
		
		if($trigger && $trigger.data('add_btn')) {
			$('#widget_modules_box .box-header').append('<a href="'+$trigger.data('add_btn')+'" class="more_btn">'+$trigger.data('add_btn_title')+'</a>');
		}
	}
});
</script>

<div class="clearfix"></div>