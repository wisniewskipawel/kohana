<div id="widget_modules_box" class="box tabs">
	<div class="container">
		<div class="box-header">
			<div class="box-header-title">
			<?php echo ___('boxes.modules.title') ?>
			</div>
			<ul class="box-tabs tabs-headers">
				<?php foreach($modules as $module_data): ?>
				<li><a href="#<?php echo $module_data['name'] ?>" class="active" <?php if(isset($module_data['add_btn'])) echo 'data-add_btn="'.$module_data['add_btn']['url'].'" data-add_btn_title="'.$module_data['add_btn']['title'].'"' ?>><?php echo $module_data['label'] ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<div class="box-content tabs-contents">
		<div class="container">
			<?php
			foreach($modules as $module_data)
				echo $module_data['view'];
			?>
		</div>
	</div>
</div>

<div class="clearfix"></div>