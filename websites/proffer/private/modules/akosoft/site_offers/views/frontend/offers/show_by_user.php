<div class="box primary offers list_box">
	<h2><?php echo ___('offers.show_by_user.title', array(':user_name' => $user->user_name)) ?></h2>
	<div class="content">

		<?php
			$filters = $session->get('show_by_user_filters');
			$from = $filters['from'];
		?>

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/offers/_filters_and_sorters')
							->set('name', 'show_by_user_filters')
					?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php echo View::factory('frontend/offers/_offers_list')->set('offers', $offers) ?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>