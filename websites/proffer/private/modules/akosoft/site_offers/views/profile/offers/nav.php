<div id="profile_offers_box" class="profile_box">
	<ul class="profile_nav">
		<li>
			<?php echo HTML::anchor(
				Route::get('site_offers/profile/offers/my')->uri(),
				___('offers.profile.my.title')
			); ?>
		</li>
		<li>
			<?php echo ___('offers.profile.stats.count_offers', $count_offers, array(
				':nb' => $count_offers,
			)) ?>
		</li>
		<li>
			<?php echo ___('offers.profile.stats.count_active_offers.label', $count_active_offers, array(
				':nb' => $count_active_offers,
				':link' => ($count_active_offers ? 
					' ('.HTML::anchor(
						Route::get('site_offers/frontend/offers/show_by_user')
							->uri(array('id' => $current_user->pk())), 
						___('offers.profile.stats.count_active_offers.link')
					).')' : ''),
			))
			?>
		</li>
	</ul>
</div>

