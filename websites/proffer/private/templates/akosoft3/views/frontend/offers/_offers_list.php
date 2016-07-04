<?php Media::css('stackicons.min.css', 'stackicons/css'); ?>
<?php
if(empty($no_ads) AND Modules::enabled('site_ads')) $ad = ads::show(ads::PLACE_F);

if (count($offers)): ?>
	<?php $i = 1; ?>
	<ul class="offers_list <?php if(!empty($view_actions)) echo 'actions_list' ?> entries_list">
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
			<li class="<?php if ($a->is_promoted()) echo 'promoted' ?> entry_list_item">
				
				<?php if(!empty($view_actions)): ?>
				<ul class="actions">
					
					<?php if($view_actions == 'closet'): ?>
					
					<li><a href="<?php echo Route::url('site_offers/frontend/offers/send', array(
						'id' => $a->pk()
					)) ?>"><?php echo ___('share_friend') ?></a></li>
					
					<li><a href="<?php echo Route::url('site_offers/profile/offers/delete_from_closet', array(
						'id' => $a->pk()
					)) ?>"><?php echo ___('delete_from_closet') ?></a></li>
					
					<?php else: ?>
					
					<li><a href="<?php echo Route::url('site_offers/profile/offers/edit', array(
						'id' => $a->pk()
					)) ?>"><?php echo ___('edit') ?></a></li>
					
					<?php if ($a->can_renew()): ?>
					<li><a href="<?php echo Route::url('site_offers/profile/offers/renew', array(
						'id' => $a->pk()
					)) ?>"><?php echo ___('prolong') ?></a></li>
					<?php endif; ?>
					
					<?php if ( ! $a->is_promoted()): ?>
					<li><a href="<?php echo Route::url('site_offers/frontend/offers/promote', array(
						'offer_id' => $a->pk())) . '?from=my' ?>"><?php echo ___('promote') ?></a></li>
					<?php endif ?>
					
					<li><a href="<?php echo Route::url('site_offers/profile/offers/delete', array(
						'id' => $a->pk()
					)) ?>"><?php echo ___('delete') ?></a></li>
					
					<li><a href="<?php echo Route::url('site_offers/profile/offers/statistics', array(
						'id' => $a->pk()
					)) ?>"><?php echo ___('statistics') ?></a></li>
					
					<li><a href="<?php echo Route::url('site_offers/profile/offers/coupons', array(
							'id' => $a->pk()
					)) ?>"><?php echo ___('offers.profile.downloaded_coupons') ?></a></li>
							
					<?php endif; ?>
							
				</ul>
				<?php endif; ?>
				
				<div class="entry">
					
					<div class="info">
						<h3>
							<a href="<?php echo $offer_link ?>" title="<?php echo HTML::chars($a->offer_title) ?>">
								<span class="price">
									<?php echo ___('offers.list.title_discount', array(
										':price' => payment::price_format($a->get_price_new(), 'short'), 
										':price_old' => payment::price_format($a->get_price_old(), 'short')))
									?>
								</span> - 
								<?php echo HTML::chars($a->offer_title) ?>
							</a>
						</h3>
					
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
						
						<div class="entry_list_item-body">
							<div class="header">
								<div class="expiration_date">
									<label><?php echo ___('offers.list.offer_availability') ?>: </label>
									<span><?php echo Date::my($a->offer_availability, 'offer') ?></span>
								</div>
							</div>

							<div class="content">
								<div class="description">
									<?php echo Text::limit_chars(strip_tags($a->offer_content), 60, '...', TRUE) ?>
								</div>

								<div class="share">
									<label><?php echo ___('share') ?>:</label>
									<?php
									$share = new Share(
										$offer_link, 
										$a->offer_title
									);

									echo $share->render();
									?>
								</div>

							</div>
						</div>
						
					</div>
						
					<div class="details">
						<div class="discount"><?php echo ___('offers.list.discount', array(':discount' => $a->get_discount())) ?></div>

						<div class="info_group">

							<?php if($a->is_active()): ?>

							<?php if(!empty($a->download_limit)): ?>
							<div class="download_limit">
								<label><?php echo ___('offers.list.download_limit') ?>:</label>
								<span><?php echo $a->get_active_coupon_counter() ?></span>
							</div>
							<?php endif; ?>

							<div class="availability">
								<label><?php echo ___('offers.list.availability') ?>:</label>
								<span><?php echo $a->get_days_left()  ?></span>
							</div>

							<?php else: ?>

							<div class="coupon_inactive">
								<?php echo ___('offers.list.coupon_inactive') ?>
							</div>

							<?php endif; ?>

						</div>
					</div>
				</div>
			</li>
			<?php if ($i == (round(count($offers) / 2, 0)) AND ! empty($ad)): ?>
				<li class="banner">
					<?php echo $ad; ?>
				</li>
			<?php endif; ?>
			<?php $i++ ?>
		<?php endforeach ?>
	</ul>

	<script type="text/javascript">
	  window.____gcfg = {lang: 'pl'};

	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
<?php else: ?>
	<div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
		<?php echo ___('offers.list.no_results') ?>
	</div>
<?php endif ?>