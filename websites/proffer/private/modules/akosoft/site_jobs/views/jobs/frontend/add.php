<div class="box primary">
	<h2><?php echo ___('jobs.add.title') ?></h2>
	<div class="content">

		<?php echo FlashInfo::display(___('jobs.add.info'), FlashInfo::INFO) ?>
		
		<?php echo $form->param('layout', 'jobs/forms/add') ?>	
		
	</div>  <!-- end .box-body -->
</div>