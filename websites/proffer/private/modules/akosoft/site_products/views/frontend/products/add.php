<div class="box primary">
	<h2><?php echo ___('products.add.title') ?></h2>
	<div class="content">

		<?php echo FlashInfo::display(___('products.add.info'), FlashInfo::INFO) ?>
		
		<?php 
		echo $form->template('site')
			->param('layout', 'frontend/products/forms/add');
		?>	
		
	</div>  <!-- end .box-body -->
</div>