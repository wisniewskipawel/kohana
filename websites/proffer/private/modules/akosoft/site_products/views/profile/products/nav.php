<div id="profile_products_box" class="profile_box">
	<ul class="profile_nav">
		<li>
			<?php echo HTML::anchor(
				Route::get('site_products/profile/products/my')->uri(),
				___('products.profile.my.title')
			); ?>
		</li>
		<li>
			<?php echo ___('products.profile.stats.count_products', $count_products, array(
				':nb' => $count_products,
			)) ?>
		</li>
		<li>
			<?php echo ___('products.profile.stats.count_active_products', $count_active_products, array(
				':nb' => $count_active_products,
				':link' => ($count_active_products ?
					' ('.HTML::anchor(
						Route::get('site_products/frontend/products/show_by_user')
							->uri(array('id' => $current_user->pk())), 
						___('products.profile.stats.active_products_link')
					).')' : '') 
			))
			?>
		</li>
	</ul>
</div>

