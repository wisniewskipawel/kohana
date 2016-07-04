<?php 
$images = $offer->get_images();
?>
<div id="show_offer_box" class="box primary entry_show_box">
	<h2><?php echo ___('offers.show.title') ?></h2>
	<div class="content">

		<?php if(!Request::$subdomain): ?>
		<ul class="entry-navigation-tabs">
			<?php if(!empty($offer->user_id) && ORM::factory('offer')->count_all_list(array('user_id' => $offer->user_id))-1): ?>
			<li><a href="<?php echo Route::url('site_offers/frontend/offers/show_by_user', array('id' => $offer->user_id)) ?>"><?php echo ___('offers.show_by_user.btn') ?></a></li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>

		<div class="offer entry_body" itemscope itemtype="http://data-vocabulary.org/Offer">

			<h1 itemprop="name"><?php echo $offer->offer_title ?></h1>

			<div class="price_box">
				<?php
				echo HTML::anchor(
					Route::get('site_offers/frontend/offers/send_coupon')
						->uri(array('id' => $offer->pk())),
					___('offers.show.download_coupon_btn'),
					array('class' => 'download_coupon_btn')
				); ?>

				<div class="new_price">
					<label><?php echo ___('offers.show.new_price.label') ?></label>
					<div class="price">
						<span itemprop="price"><?php echo payment::price_format($offer->get_price_new(), FALSE) ?></span>
						<span>
							<?php echo payment::currency('short') ?>
							<meta itemprop="currency" content="<?php echo payment::currency() ?>" />
						</span>
					</div>
					<div class="annotation">(<?php echo ___('offers.show.new_price.annotation', array(
						':price' => payment::price_format($offer->get_price_old() - $offer->get_price_new(), 'short')
					))?>)</div>
				</div>

				<div class="old_price">
					<label><?php echo ___('offers.show.old_price') ?></label>
					<div class="price"><?php echo payment::price_format($offer->get_price_old()) ?></div>
				</div>

				<div class="discount">
					<label><?php echo ___('offers.show.discount') ?></label>
					<span><?php echo $offer->get_discount()?>%</span>
				</div>
			</div>

			<div class="sidebar">

				<div class="availability_box sidebar_box">

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

				<div class="company_box sidebar_box">
					<label>
					<?php if ($offer->contact_data() instanceof Contact_Person): ?>
						<?php echo ___('offers.show.offer_person_type.person') ?>:
					<?php elseif ($offer->contact_data() instanceof Contact_Company): ?>
						<?php echo ___('offers.show.offer_person_type.company') ?>:
					<?php endif ?>
					</label>
					<br/>
					<div class="address">

						<h2><?php echo $offer->contact_data()->display_name() ?></h2>

						<div>
							<?php if ($offer->contact_data()->address->postal_code): ?>
							<span class="postal_code"><?php echo $offer->contact_data()->address->postal_code ?></span>
							<?php endif ?>

							<?php if ($offer->contact_data()->address->city): ?>
							<span class="city"><?php echo $offer->contact_data()->address->city ?></span>
							<?php endif ?>
						</div>

						<?php if ($offer->contact_data()->address->street): ?>
						<div class="street"><?php echo $offer->contact_data()->address->street ?></div>
						<?php endif ?>

						<?php if (Kohana::$config->load('modules.site_offers.settings.provinces_enabled') && $offer->contact_data()->address->province): ?>
						<div class="province">
							<label><?php echo ___('province') ?>: </label>
							<span><?php echo $offer->contact_data()->address->province ?></span>
						</div>
						<?php if($offer->contact_data()->address->county AND $offer->contact_data()->address->province_id != Regions::ALL_PROVINCES): ?>
						<div class="county">
							<label><?php echo ___('county') ?>: </label>
							<span><?php echo $offer->contact_data()->address->county ?></span>
						</div>
						<?php endif ?>
						<?php endif ?>
						
						<?php if(($offer->contact_data() instanceof Contact_Company) AND $offer->contact_data()->nip): ?>
						<br/>
						<div class="nip">
							<label><?php echo ___('nip') ?>: </label>
							<span><?php echo HTML::chars($offer->contact_data()->nip) ?></span>
						</div>
						<?php endif; ?>
						
						<br/>
						
						<?php if ($offer->contact_data()->phone): ?>
						<div class="phone">
							<label><?php echo ___('telephone') ?>:</label>
							<span><?php echo offers::curtain($offer, 'telephone', 'telephone.curtain') ?></span>
						</div>
						<?php endif ?>

						<?php if ( ! Kohana::$config->load('modules.site_offers.settings.email_view_disabled') && $offer->contact_data()->email): ?>
						<div class="email">
							<label><?php echo ___('email') ?>:</label>
							<span><?php echo offers::curtain($offer, 'email', 'email.curtain') ?></span>
						</div>
						<?php endif ?>

						<?php if ($offer->contact_data()->www): ?>
						<div class="www">
							<label><?php echo ___('www') ?>:</label>
							<span><a href="<?php echo Tools::link($offer->contact_data()->www) ?>" target="_blank"><?php echo URL::idna_decode($offer->contact_data()->www) ?></a></span>
						</div>
						<?php endif ?>
						
						<?php if($offer->has_company() AND $offer->catalog_company->is_promoted()): ?>
						<div class="modules_links">
							<div class="company_link">
								<?php echo HTML::anchor(catalog::url($offer->catalog_company), ___('catalog.module_links.btn'), array(
									'target' => ($offer->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</div>
							
							<?php if(Modules::enabled('site_announcements') AND Model_Announcement::count_by_company($offer->catalog_company)): ?>
							<div class="announcements">
							<?php echo HTML::anchor(catalog::url($offer->catalog_company, 'announcements'), ___('announcements.module_links.btn'), array(
									'target' => ($offer->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</div>
							<?php endif; ?>
						
							<?php if(Modules::enabled('site_products') AND Model_Product::count_by_company($offer->catalog_company)): ?>
							<div class="products">
								<?php echo HTML::anchor(catalog::url($offer->catalog_company, 'products'), ___('products.module_links.btn'), array(
									'target' => ($offer->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</div>
							<?php endif; ?>
							
						</div>
						<?php endif ?>
						
					</div>
				</div>

				<?php if(!Request::$subdomain): ?>
				<div class="actions">
					<ul class="offer-actions entry_actions">
						<li class="contact">
							<a href="<?php echo Route::url('site_offers/frontend/offers/contact', array('id' => $offer->pk())) ?>" class="contact_btn"><?php echo ___('contact') ?></a>
							<div id="dialog_offer_contact" class="dialog hidden box">
								<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
								<?php echo Bform::factory('Frontend_Offer_Contact', array(
									'offer' => $offer,
								))->render() ?>
							</div>
							<script type="text/javascript">
							$(function() {
								
								var $dialog_offer_contact = $('#dialog_offer_contact').remove().wrap('<div>').parent();
								$dialog_offer_contact.find('#dialog_offer_contact').removeClass('hidden').show();
								
								$('.contact_btn').on('click', function(e) {
									e.preventDefault();

									$.fancybox(
										$dialog_offer_contact.html(),
										{
											'autoDimensions'	: true,
											'transitionIn'		: 'none',
											'transitionOut'		: 'none',
											'padding'			: 0
										}
									);
								});
							});
							</script>
						</li>
						<li class="closet">
							<a href="<?php echo Route::url('site_offers/profile/offers/add_to_closet', array('id' => $offer->pk())) ?>" class="closet_btn"><?php echo ___('to_closet') ?></a>
						</li>
						<li class="recommend">
							<a href="<?php echo Route::url('site_offers/frontend/offers/send', array('id' => $offer->pk())) ?>" class="recommend_btn"><?php echo ___('share_friend') ?></a>
						</li>
					</ul>
				</div>
				<?php endif; ?>
			</div>

			<div class="content">

				<div class="container">

					<div class="active" id="offer-photos">
						<div class="slider-gallery">
							<div class="big-photo">
								<?php if (count($images)): ?>
								<a class="photo_big" title="<?php echo Security::xss_clean($offer->offer_title) ?>" href="<?php echo $images->first()->get_url('offer_big') ?>">
									<?php echo HTML::image(
										$images->first()->get_uri('offer_show_big'),
										array('alt' => $offer->offer_title, 'itemprop' => 'image')
									) ?>
								</a>
								
								<script type="text/javascript">
								$(function() {
									$("a.photo_big").on('click', function(e) {
										e.preventDefault();
										
										$.fancybox(this.href, {
											'padding'			: 0,
											'transitionIn'		: 'none',
											'transitionOut'		: 'none',
											'type'              : 'image',
											'changeFade'        : 0
										});
									});
								});
								</script>
								
								<?php else: ?>
								<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="offer-photo no-photo" />
								<?php endif ?>
							</div>
						</div>
					</div>

				</div>



				<div class="clearfix"></div>

			</div>

			<div class="entry-content">
				<h3><?php echo ___('offers.show.offer_content') ?>:</h3>
				<div itemprop="description">
					<?php
						$content = $offer->offer_content;
						$content = Text::linkify($content);
						echo $content;
					?>
				</div>
			</div>

			<div class="clearfix"></div>

		</div>

		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>

	</div>

</div>