<div class="box primary">
	<h2><?php echo ___('products.profile.statistics.title') ?></h2>
	<div class="content">
		<p>
			<?php echo ___('products.profile.statistics.product_visits') ?>: <?php echo $product->product_visits ?>
		</p>
		<p>
			<?php echo ___('date_added') ?>: <?php echo date('d.m.Y', strtotime($product->product_date_added)) ?>
		</p>
		<p>
			<?php echo ___('date_availability') ?>: <?php echo date('d.m.Y', strtotime($product->product_availability)) ?>
		</p>
	</div>
</div>