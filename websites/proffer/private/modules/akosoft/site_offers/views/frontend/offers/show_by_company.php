<div class="box primary offers list_box">
	<h2><?php echo ___('offers.show_by_company.title', array(':company_name' => $company->company_name)) ?></h2>
	<div class="content">
		
		<?php echo View::factory('frontend/offers/partials/list_tabs')->set('filters_sorters', $filters_sorters) ?>

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/offers/_filters_and_sorters')
				->set('filters_sorters', $filters_sorters)
				->set('name', 'category_filters')
		?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php echo View::factory('frontend/offers/_offers_list')->set('offers', $offers)->bind('ad', $ad)->set('place', 'category') ?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>