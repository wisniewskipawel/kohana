<div id="show_offer_box" class="box" itemscope itemtype="http://data-vocabulary.org/Offer">
	
	<div class="box-header">
		<span><?php echo ___('offers.show.title') ?>:</span> 
		<h1 itemprop="name">
			<?php echo HTML::chars($offer->offer_title) ?>
		</h1>
	</div>
	
	<div class="content">
		
		<div class="meta">
			<span class="date_added"><?php echo ___('offers.show.date_added') ?>: <?php echo date('Y.m.d', strtotime($offer->offer_date_added)) ?></span>
			<span class="date_availability"><?php echo ___('offers.show.date_availability') ?>: <?php echo date('Y.m.d', strtotime($offer->offer_availability)) ?></span>
			<span class="visits"><?php echo ___('offers.show.visits') ?>: <?php echo (int)$offer->offer_visits ?></span>
		</div>
		
		<div class="availability_box">
			<div class="row">
				<div class="col-md-8">
					
					<?php if($offer->is_active()): ?>
					<div class="expiration_date">
						<label><?php echo ___('offers.show.expiration_date.label') ?>:</label>
						<?php
						$date_end = strtotime($offer->offer_availability);
						$ticker = Date::span(time(), $date_end, 'days,hours,minutes,seconds');
						?>
						<div class="ticker" data-end="<?php echo  $date_end ?>">
							<div class="days"><span><?php echo $ticker['days'] ?></span><label><?php echo ___('offers.show.expiration_date.days', $ticker['days']) ?></label></div>
							<div class="hours"><span><?php echo $ticker['hours'] ?></span><label><?php echo ___('offers.show.expiration_date.hours', $ticker['hours']) ?></label></div>
							<div class="minutes"><span><?php echo $ticker['minutes'] ?></span><label><?php echo ___('offers.show.expiration_date.minutes', $ticker['minutes']) ?></label></div>
							<div class="seconds"><span><?php echo $ticker['seconds'] ?></span><label><?php echo ___('offers.show.expiration_date.seconds', $ticker['seconds']) ?></label></div>
						</div>
					</div>
					
				</div>
				<div class="col-md-4">
				
					<div class="limits">
					<?php if(!empty($offer->download_limit)): ?>
						<?php echo ___('offers.show.limit', array(':count' => (int)$offer->download_counter, ':limit' => $offer->download_limit)) ?>
					<?php endif; ?>
					</div>

					<div class="availability">
						<?php echo ___('offers.show.availability.label') ?> <strong><?php echo ___('offers.show.availability.active') ?></strong>
					</div>
					<?php else: ?>
					<div class="availability">
						<?php echo ___('offers.show.availability.label') ?> <strong><?php echo ___('offers.show.availability.inactive') ?></strong>
					</div>
					<?php endif; ?>

					<?php if($offer->coupon_expiration): ?>
					<div class="coupon_dates">
						<?php echo ___('offers.show.coupon_dates', array(
							':from' => date('Y-m-d', strtotime($offer->offer_date_added)),
							':to' => date('Y-m-d', strtotime($offer->coupon_expiration)),
						)) ?>
					</div>
					<?php endif; ?>
					
				</div>
			</div>
		</div><!-- /.availability_box -->
		
		<div class="offer_content entry_content_box">
			<h5><?php echo ___('offers.show.offer_content') ?>:</h5>
			<div class="entry_content_box_body" itemprop="description">
				<?php
					$content = $offer->offer_content;
					$content = Text::linkify($content);
					echo $content;
				?>
			</div>
		</div><!-- /.offer_content -->
		
		<div class="row">
			<div class="col-md-6">
				
				<div class="price_box">
					<?php
					echo HTML::anchor(
						Route::get('site_offers/frontend/offers/send_coupon')
							->uri(array('id' => $offer->pk())),
						___('offers.show.download_coupon_btn'),
						array('class' => 'download_coupon_btn')
					); ?>

					<div class="new_price">
						<label><?php echo ___('offers.show.new_price.label') ?>:</label>
						<div class="price">
							<span itemprop="price"><?php echo payment::price_format($offer->get_price_new(), FALSE) ?></span>
							<span>
								<?php echo payment::currency('short') ?>
								<meta itemprop="currency" content="<?php echo payment::currency() ?>" />
							</span>
						</div>
					</div>

					<div class="old_price">
						<label><?php echo ___('offers.show.old_price') ?>:</label>
						<div class="price"><?php echo payment::price_format($offer->get_price_old()) ?></div>
					</div>

					<div class="discount">
						<label><?php echo ___('offers.show.discount') ?>:</label>
						<span class="discount_value">
							<?php echo $offer->get_discount()?>%
						</span>
						
						<span class="annotation">(<?php echo ___('offers.show.new_price.annotation', array(
							':price' => payment::price_format($offer->get_price_old() - $offer->get_price_new(), 'short')
						))?>)</span>
					</div>
				</div><!-- /.price_box -->
				
			</div>
			<div class="col-md-6">
				
				<div class="offer-photo">
					<div class="slider-gallery">
						<div class="big-photo">
							<?php $images = $offer->get_images(); if(count($images)): ?>
							<a class="photo_big" title="<?php echo Security::xss_clean($offer->offer_title) ?>" href="<?php echo $images->first()->get_url('offer_big') ?>">
								<?php echo HTML::image(
									$images->first()->get_uri('offer_show_big'),
									array('alt' => $offer->offer_title, 'itemprop' => 'image')
								) ?>
							</a>

							<script type="text/javascript">
							$(function() {
								$("a.photo_big").live('click', function(e) {
									e.preventDefault();

									$.fancybox(this.href, {
										'padding'			: 0,
										'transitionIn'		: 'none',
										'transitionOut'		: 'none',
										'type'              : 'image',
										'changeFade'        : 0,
									});
								});
							});
							</script>

							<?php else: ?>
							<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
							<?php endif ?>
						</div>
					</div>
				</div><!-- /.offer-photo -->
				
			</div>
		</div>
		
		<div class="offer-seller entry_content_box" itemprop="seller" itemscope itemtype="http://schema.org/Person">
			<h5><?php echo ___('contact') ?></h5>

			<div class="entry_content_box_body">
				
				<div class="contact-details">
					<div class="author" itemprop="name"><?php echo $offer->contact_data()->display_name() ?></div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="address">
								<?php echo $offer->contact_data()->address->render('single_line') ?>
							</div>
							
							<?php if(($offer->contact_data() instanceof Contact_Company) AND $offer->contact_data()->nip): ?>
							<div class="nip">
								<label><?php echo ___('nip') ?>: </label>
								<span><?php echo HTML::chars($offer->contact_data()->nip) ?></span>
							</div>
							<?php endif; ?>

							<a href="<?php echo $contact_url = Route::url('site_offers/frontend/offers/contact', array('id' => $offer->pk())) ?>" class="contact_btn btn btn-default btn-block show_dialog_btn" data-dialog-target="#dialog_contact"><?php echo ___('contact') ?></a>
							<div id="dialog_contact" class="dialog hidden box">
								<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
								<?php echo Bform::factory(new Form_Frontend_Offer_Contact, array(
									'offer' => $offer,
								))->action($contact_url)->render() ?>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="contact-meta">
								<?php if ( !offers::config('email_view_disabled') && $offer->contact_data()->email): ?>
								<div class="email">
									<span><?php echo ___('email') ?>:</span>
									<?php echo offers::curtain($offer, 'email', ___('email.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if ($offer->contact_data()->phone): ?>
								<div class="telephone">
									<span><?php echo ___('telephone') ?>:</span>
									<?php echo offers::curtain($offer, 'telephone', ___('telephone.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if($offer->contact_data()->www): ?>
								<div class="www">
									<span><?php echo ___('www') ?>:</span>
									<a href="<?php echo Tools::link($offer->contact_data()->www) ?>" target="_blank"><?php echo URL::idna_decode($offer->contact_data()->www) ?></a>
								</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				
					<?php
					$user = $offer->user;
					$other_count = $user ? Model_Offer::factory()
						->filter_by_user($user)
						->where('offer_id', '!=', $offer->pk())
						->add_active_conditions()
						->count_all() : 0;

					if($other_count OR ($offer->has_company() AND $offer->catalog_company->is_promoted())):
					?>
					<div class="user_other_entries">
						<ul>
							<?php if ($offer->has_company() AND $offer->catalog_company->is_promoted()): ?>
							<li class="company_link">
								<?php echo HTML::anchor(catalog::url($offer->catalog_company), '<i class="glyphicon glyphicon-briefcase"></i> '.___('catalog.module_links.btn'), array(
									'target' => ($offer->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</li>
							<?php endif; ?>
							<?php if($other_count): ?>
							<li><?php echo HTML::anchor(Route::get('site_offers/frontend/offers/show_by_user')->uri(array(
								'id' => $user->pk(),
							)), ___('template.user_offers')) ?></li>
							<?php endif ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
				
			</div>
		</div><!-- /.offer-seller -->
		
		
		<div class="bottom">
			<ul class="offer-actions">
				<li class="closet">
					<a href="<?php echo Route::url('site_offers/profile/offers/add_to_closet', array('id' => $offer->pk())) ?>" class="closet_btn"><?php echo ___('to_closet') ?></a>
				</li>
				<li class="report">
					<a rel="nofollow" href="<?php echo Route::url('site_offers/frontend/offers/report', array('id' => $offer->pk())) ?>"><?php echo ___('report') ?></a>
				</li>
			</ul>

			<div class="share">
				<span class="l"><?php echo ___('share') ?>:</span>
				<?php
				$share = new Share(
					URL::site(offers::uri($offer), 'http'), 
					$offer->offer_title
				);
				
				if($images AND $images->first() AND $images->first()->exists('offer_big'))
					$share->add_image($images->first()->get_url('offer_big', 'http'));
				
				$share->add_send_friend_form(
					$send_url = Route::url('site_offers/frontend/offers/send', array('id' => $offer->pk())),
					Bform::factory(new Form_Frontend_Offer_Send, array(
						'offer' => $offer,
					))->action($send_url)->render(),
					___('offers.send.title')
				);

				echo $share->render();
				?>
			</div>
		</div><!-- /.bottom -->
		
	</div><!-- /.content -->

</div>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>
