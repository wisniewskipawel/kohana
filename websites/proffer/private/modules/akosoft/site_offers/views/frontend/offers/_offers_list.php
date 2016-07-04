<?php
if(empty($no_ads) AND Modules::enabled('site_ads')) $ad = ads::show(ads::PLACE_F);

if (count($offers)): ?>
	<?php $i = 1; ?>
	<ul class="offers_list <?php if(!empty($view_actions)) echo 'actions_list' ?>">
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
			<li class="<?php if ($a->is_promoted()) echo 'promoted' ?>">
				
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
					
					<div class="info">
						
						<div class="header">
							<h3>
								<a href="<?php echo $offer_link ?>">
									<span class="price">
										<?php echo ___('offers.list.title_discount', array(
											':price' => payment::price_format($a->get_price_new(), 'short'), 
											':price_old' => payment::price_format($a->get_price_old(), 'short')))
										?>
									</span> - 
									<?php echo Text::limit_chars($a->offer_title, 20, '...', TRUE) ?>
								</a>
							</h3>
							
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
								<?php $offer_link_encoded = urlencode($offer_link); ?>
								<label><?php echo ___('share') ?>:</label> 
								<div class="share-buttons">
									<a id="fb-share" href="https://www.facebook.com/sharer/sharer.php<?php 
										echo URL::query(array(
											's' => 100,
											'p' => array(
												'url' => $offer_link,
												'title' => $a->offer_title,
												'summary' => Text::limit_chars(strip_tags($a->offer_content), 100, '...'),
											),
										), FALSE);
										?>" title="<?php echo ___('share.fb') ?>" target="_blank"></a>
									<a id="gg-share" href="gg:/set_status?description=<?php echo $offer_link_encoded ?>" title="<?php echo ___('share.gg') ?>" target="_blank"></a>
									<a id="wykop-share" href="http://www.wykop.pl/dodaj?url=<?php echo $offer_link_encoded ?>" title="<?php echo ___('share.wykop') ?>" target="_blank"></a>
									<a id="nk-share" href="http://nasza-klasa.pl/sledzik?shout=<?php echo $offer_link_encoded ?>" title="<?php echo ___('share.nk') ?>" target="_blank"></a>
									<a id="blip-share" href="http://www.blip.pl/dashboard?body=<?php echo $offer_link_encoded ?>" title="<?php echo ___('share.blip') ?>" target="_blank"></a>
									<a id="twitter-share" href="http://twitter.com/?status=<?php echo $offer_link_encoded ?>" title="<?php echo ___('share.twitter') ?>" target="_blank"></a>
									<g:plusone size="small"></g:plusone>
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