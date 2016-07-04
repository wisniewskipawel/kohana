<?php if(!count($companies)): ?>

<div id="advanced_search_form_box" class="box primary">
	<h2><?php echo ___('catalog.companies.advanced_search.title') ?></h2>
	<div class="content">
		<?php echo $form->render('frontend/catalog/forms/advanced_search') ?>
	</div>
</div>

<?php else: ?>

<div id="advanced_search_results_box" class="box primary announcements companies">
	<h2><?php echo ___('catalog.companies.advanced_search.results') ?></h2>
	<div class="content">
		<?php echo $pager ?>

		<?php echo View::factory('frontend/catalog/_list')->set('companies', $companies) ?>

		<?php echo $pager ?>
	</div>
</div>

<?php endif; ?>