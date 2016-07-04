<div id="product_order_box" class="box primary">
	<h2><?php echo ___('products.order.title') ?></h2>
	<div class="content">
		
		<div class="product_info">
			<h3 class="title"><?php echo ___('products.order.ordering_product') ?>: <?php echo HTML::anchor(Products::uri($product), HTML::chars($product->product_title)) ?></h3>
		</div>
		
		<?php echo $form->param('layout', 'frontend/products/forms/order') ?>
	</div>
</div>
