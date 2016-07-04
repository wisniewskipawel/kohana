<div id="profile_catalog_box" class="profile_box">
	<ul class="profile_nav">
		<li>
			<?php echo HTML::anchor(
				Route::get('site_catalog/profile/catalog/my')->uri(),
				___('catalog.profile.my.title')
			); ?>
		</li>
		<li>
			<?php echo ___('catalog.profile.stats.count_companies', $count_companies, array(
				':nb' => $count_companies,
			)) ?>
		</li>
		<li>
			<?php echo ___('catalog.profile.stats.count_active_companies', $count_active_companies, array(
				':nb' => $count_active_companies,
			)) ?>
		</li>
	</ul>
</div>

