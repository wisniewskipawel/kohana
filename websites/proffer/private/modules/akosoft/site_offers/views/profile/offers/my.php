<div id="my_offers_box" class="box primary offers list_box">
	<h2><?php echo ___('offers.profile.my.title') ?></h2>
	<div class="content">

		<?php echo View::factory('frontend/offers/_filters_and_sorters')
				->set('name', 'my_filters')
				->set('filters_sorters', $filters_sorters)
		?>
		
		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php echo View::factory('frontend/offers/_offers_list')
			->set('offers', $offers)
			->set('view_actions', 'my')
			->set('place', 'category');
		?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
	</div>
</div>
