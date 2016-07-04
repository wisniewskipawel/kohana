<?php if (count($offers)): ?>
	<ul class="offers_list list_box">
		<?php foreach ($offers as $a): 
			$offer_link = URL::site(
				Route::get('site_offers/frontend/offers/show')
					->uri(array(
						'offer_id' => $a->pk(), 
						'title' => URL::title($a->offer_title)
					)), 
				'http', 
				FALSE, 
				Request::$subdomain
			); 
		?>
			<li>
				<a href="<?php echo $offer_link ?>" class="title">
					<?php echo $a->offer_title ?>
				</a>
				
				<div class="price_side">
					<?php echo ___('price'); ?>:
					<span class="price"><?php echo payment::price_format($a->get_price_new(), FALSE) ?></span>
					<span class="currency"><?php echo payment::currency() ?></span>
				</div>
				
				<?php if($a->has_last_category()): ?>
				<div class="category">
					<?php echo HTML::anchor(Route::get('site_offers/frontend/offers/category')->uri(array(
						'category_id' => $a->last_category->pk(),
						'title' => URL::title($a->last_category->category_name),
					)), $a->last_category->category_name); ?>
				</div>
				<?php endif; ?>
				
				<div class="date_added">
					<?php echo ___('date_added') ?>: <span><?php echo Date::my($a->offer_date_added) ?></span>
				</div>
						
			</li>
		<?php endforeach ?>
	</ul>
<?php else: ?>
	<div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
		<?php echo ___('offers.list.no_results') ?>
	</div>
<?php endif ?>
