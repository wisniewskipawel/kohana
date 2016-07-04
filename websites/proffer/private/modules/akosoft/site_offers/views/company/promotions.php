<div id="promotions_box" class="box">
	<h2><?php echo ___('offers.company.title') ?></h2>
	
	<div class="content">
		
		<?php echo View::factory('frontend/offers/_offers_list')
			->set('offers', $offers)
			->set('no_ads', TRUE)
		?>
		
		<?php if(count($offers)): ?>
		<?php echo HTML::anchor(
			Route::get('site_offers/frontend/offers/show_by_company')
				->uri(array(
					'company_id' => $current_company->pk(),
				)), 
			___('offers.company.see_all_btn'), 
			array('class' => 'see_all_btn')
		); ?>
		<?php endif; ?>
		
	</div>
</div>
