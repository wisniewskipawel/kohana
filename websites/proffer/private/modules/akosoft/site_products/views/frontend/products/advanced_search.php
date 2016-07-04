<?php if(!count($products)): ?>

<div class="box primary products">
	<h2><?php echo ___('products.advanced_search.title') ?></h2>
	<div class="content">
		<?php echo $form->render('frontend/products/forms/advanced_search') ?>
	</div>
</div>

<?php else: ?>

<div class="box primary products">
	<h2><?php echo ___('products.search.results') ?></h2>
	<div class="content">
		<?php echo $pager ?>

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/products/partials/list_box')->set('products', $products)->bind('ad', $ad) ?>

		<?php echo $pager ?>

		<div class="clearfix"></div>
	</div>
</div>

<?php endif; ?>