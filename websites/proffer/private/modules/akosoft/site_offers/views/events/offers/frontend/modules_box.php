<div class="tabs-wrapper slider" id="promoted_offers">
	<div class="slider-track">
		<?php if (count($offers)): ?>
			<ul class="global_list_box">
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
								<?php $image = $a->get_first_image(); if($image AND $image->exists('offer_list')): ?>
									<img src="<?php echo $image->get_url('offer_list') ?>" alt="" class="offer-photo" />
								<?php elseif($a->has_last_category() && img::image_exists('offer_category', 'offer_category_medium', $a->last_category->pk(), $a->last_category->category_image)): ?>
									<img src="<?php echo img::path('offer_category', 'offer_category_medium', $a->last_category->pk(), $a->last_category->category_image) ?>" alt="" class="offer-photo" />
								<?php else: ?>
									<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="offer-photo no-photo" />
								<?php endif; ?>
							</a>
						</div>
						<div class="info">
							<div class="title">
								<a href="<?php echo $offer_link ?>" class="title"> <?php echo $a->offer_title ?></a>
							</div>
							
							<?php if($a->has_last_category()): ?>
							<div class="category">
								<?php echo HTML::anchor(Route::get('site_offers/frontend/offers/category')->uri(array(
									'category_id' => $a->last_category->pk(),
									'title' => URL::title($a->last_category->category_name),
								)), $a->last_category->category_name); ?>
							</div>
							<?php endif; ?>
							
							<div class="price_side">
								<?php echo ___('price'); ?>:
								<span class="price"><?php echo payment::price_format($a->get_price_new(), FALSE) ?></span>
								<span class="currency"><?php echo payment::currency() ?></span>
							</div>
							
						</div>		
					</li>
				<?php endforeach ?>
			</ul>
			<?php endif ?>
	</div>
	<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
	<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
</div>
