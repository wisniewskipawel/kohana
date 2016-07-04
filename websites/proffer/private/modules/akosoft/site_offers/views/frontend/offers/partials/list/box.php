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
				<div class="image-wrapper">
					<a href="<?php echo  $offer_link?>">
						<?php if($a->has_last_category() && img::image_exists('offer_category', 'offer_category_medium', $a->last_category->pk(), $a->last_category->category_image)): ?>
						<?php echo HTML::image(
							img::path_uri('offer_category', 'offer_category_medium', $a->last_category->pk(), $a->last_category->category_image),
							array('alt' => $a->offer_title)
						) ?>
						<?php else: ?>
						<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="offer-photo no-photo" />
						<?php endif; ?>
					</a>
				</div>
				
				<a href="<?php echo $offer_link ?>" class="title">
					<?php echo Text::limit_chars($a->offer_title, 20, '...', TRUE) ?>
				</a>
				<div class="description">
					<span class="price">
						<?php echo ___('offers.list.title_discount', array(
							':price' => payment::price_format($a->get_price_new(), 'short'), 
							':price_old' => payment::price_format($a->get_price_old(), 'short')))
						?>
					</span>
				</div>
						
			</li>
		<?php endforeach ?>
	</ul>
<?php else: ?>
	<div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
		<?php echo ___('offers.list.no_results') ?>
	</div>
<?php endif ?>
