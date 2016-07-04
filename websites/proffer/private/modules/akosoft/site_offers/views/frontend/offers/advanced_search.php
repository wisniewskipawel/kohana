<?php if(!count($offers)): ?>

<div id="advanced_search_form_box" class="box primary">
	<h2><?php echo ___('offers.advanced_search.title') ?></h2>
	<div class="content">
		<?php echo $form->render('frontend/offers/forms/advanced_search') ?>
	</div>
</div>

<?php else: ?>

<div id="advanced_search_results_box" class="box primary">
	<h2><?php echo ___('offers.advanced_search.results') ?></h2>
	<div class="content">
		<?php echo $pager ?>

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/offers/_offers_list')->set('offers', $offers)->bind('ad', $ad) ?>

		<?php echo $pager ?>

		<div class="clearfix"></div>
			
	</div>
</div>

<?php endif; ?>