<?php $logo = $company->get_logo(); ?>
<div id="show_company_box" class="box primary entry_show_box">
	<h2><?php echo ___('catalog.companies.show.title') ?></h2>
	<div class="content">
		
		<div class="entry_body" itemscope itemtype="http://schema.org/Organization">
			
			<h1 itemprop="name"><?php echo $company->company_name ?></h1>
			
			<div class="content">
				
				<div class="entry_tabs entry_tabs_side">
					
					<ul class="entry_tabs_headers">
						<?php if($company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
						<li><a href="#company-map"><?php echo ___('map') ?></a></li>
						<?php endif; ?>
						<?php $images_limit  = $company->get_promotion_type_limit('images'); if($images_limit): ?>
						<li><a href="#announcement-photos"><?php echo ___('photos') ?></a></li>
						<?php endif; ?>
						<li class="last"><a href="#contact"><?php echo ___('contact') ?></a></li>
					</ul>

					<div class="container">

					<?php if($images_limit): ?>
						<div id="announcement-photos">
							<?php if (count($images)): ?>
							<div class="slider-gallery">
								<div class="big-photo">
									<a class="photo_big" title="<?php echo Security::xss_clean($company->company_name) ?>" href="<?php echo $images->first()->get_url('catalog_company_big') ?>" >
										<img src="<?php echo $images->first()->get_url('catalog_company_thumb_big') ?>" alt="<?php echo HTML::chars($company->company_name) ?>" itemprop="image">
									</a>
								</div>
								<div class="nav">
									<a class="prev browse left"></a>
									<div class="slider">
										<div class="items">
											<?php foreach(new LimitIterator($images, 0, $images_limit) as $image): ?>
											<a class="slide_photo" href="<?php echo $image->get_url('catalog_company_big') ?>" data-big_thumb="<?php echo $image->get_url('catalog_company_thumb_big') ?>">
												<img src="<?php echo $image->get_url('catalog_company_list') ?>" alt="<?php echo HTML::chars($company->company_name) ?>">
											</a>
											<?php endforeach ?>
										</div>
									</div>
									<a class="next browse right"></a>
								</div>
							</div>

							<div class="clearfix"></div>

							<?php else: ?>
								<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
							<?php endif ?>

						</div>
						<?php endif; ?>

						<?php if($company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
						<div id="company-map" class="active">
							<?php echo View::factory('frontend/catalog/partials/map')->set('company', $company) ?>
						</div>
						<?php endif; ?>

						<div id="contact">
							<div class="entry_contact_form_info">
								<?php echo ___('catalog.companies.contact.info') ?>
							</div>
							<?php echo $form->param('class', 'bform entry_contact_form') ?>
						</div>
					</div>
					
				</div>
				
				<div class="entry_info <?php if($logo): ?> with-logo <?php endif ?>">
					
					<?php if($logo->exists('catalog_company_list')): ?>
					<div class="company-logo">
						<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="<?php echo HTML::chars($company->company_name) ?>" itemprop="logo" />
					</div>
					<?php endif; ?>
					
					<div itemprop="location" itemscope itemtype="http://schema.org/Place">
						<table class="top" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
							<?php if (catalog::config('map') AND $company->get_contact()->address->province): ?>
								<tr>
									<th><span><?php echo ___('province') ?>:</span></th>
									<td class="orange"><strong itemprop="addressRegion"><?php echo $company->get_contact()->address->province ?></strong></td>
								</tr>

								<?php if($company->get_contact()->address->county AND $company->get_contact()->address->province_id != Regions::ALL_PROVINCES): ?>
								<tr>
									<th><span><?php echo ___('county') ?>:</span></th>
									<td><?php echo $company->get_contact()->address->county ?></td>
								</tr>
								<?php endif; ?>

							<?php endif ?>
							<tr>
								<th>
									<span>
										<?php echo ___('catalog.company_name') ?>
									</span>
								</th>

								<td itemprop="name"><?php echo $company->company_name ?></td>
							</tr>
							<?php if ($company->get_contact()->address->street): ?>
							<tr>
								<th><span><?php echo ___('address') ?>:</span></th>
								<td itemprop="streetAddress"><?php echo $company->get_contact()->address->street ?></td>
							</tr>
							<?php endif ?>
							<?php if ($company->get_contact()->address->city): ?>
							<tr>
								<th><span><?php echo ___('city') ?>:</span></th>
								<td itemprop="addressLocality"><?php echo $company->get_contact()->address->city ?></td>
							</tr>
							<?php endif ?>
							<?php if ($company->get_contact()->address->postal_code): ?>
							<tr>
								<th><span><?php echo ___('postal_code') ?>:</span></th>
								<td itemprop="postalCode"><?php echo $company->get_contact()->address->postal_code ?></td>
							</tr>
							<?php endif ?>
							<?php if ($company->get_contact()->phone): ?>
							<tr>
								<th><span><?php echo ___('telephone') ?>:</span></th>
								<td><?php echo catalog::curtain($company, 'telephone', 'telephone.curtain') ?></td>
							</tr>
							<?php endif ?>
							<?php if (!catalog::config('email_view_disabled') AND $company->get_contact()->email): ?>
							<tr>
								<th><span><?php echo ___('email') ?>:</span></th>
								<td><?php echo catalog::curtain($company, 'email', 'email.curtain') ?></td>
							</tr>
							<?php endif ?>
							<?php if ($company->get_contact()->www): ?>
							<tr>
								<th><span><?php echo ___('catalog.link') ?>:</span></th>
								<td><a href="<?php echo Tools::link($company->get_contact()->www) ?>" target="_blank"><?php echo URL::idna_decode($company->get_contact()->www) ?></a></td>
							</tr>
							<?php endif ?>
							<?php if ($company->get_contact()->nip): ?>
							<tr>
								<th><span><?php echo ___('nip') ?>:</span></th>
								<td><?php echo HTML::chars($company->get_contact()->nip) ?></td>
							</tr>
							<?php endif ?>
							<?php if ($company->has_company_hours()): ?>
							<tr>
								<th><span><?php echo ___('catalog.company_hours') ?>:</span></th>
								<td class="company_hours">
									<?php foreach($company->company_hours as $day => $hours): if(isset($hours['open']) AND $hours['open'] != Model_Catalog_Company::COMPANY_HOURS_NONE): ?>
									<div class="days">
										<span><?php echo ___('date.days.abbr.'.$day) ?>. :</span>
										<?php if($hours['open'] == Model_Catalog_Company::COMPANY_HOURS_OPEN): ?>
										<?php echo $hours['from'].' - '.$hours['to'] ?>
										<?php elseif($hours['open'] == Model_Catalog_Company::COMPANY_HOURS_CLOSED): 
											$hours = (array)$hours; ?>
										<?php echo ___('catalog.forms.company_hours.open.0') ?>
										<?php endif; ?>
									</div>
									<?php endif; endforeach; ?>
								</td>
							</tr>
							<?php endif ?>
							<tr>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
							<tr>
								<th><span><?php echo ___('catalog.companies.show.date_added') ?>:</span></th>
								<td><?php echo date('Y.m.d', strtotime($company->company_date_added)) ?></td>
							</tr>
							<tr>
								<th><span><?php echo ___('catalog.companies.show.visits') ?>:</span></th>
								<td><?php echo $company->company_visits ?></td>
							</tr>

							<?php if($company->is_promoted()): ?>
							<?php if(Modules::enabled('site_announcements') AND Model_Announcement::count_by_company($company)): ?>
							<tr class="announcements">
								<th><span><?php echo ___('announcements.module_links.label') ?>:</span></th>
								<td><?php echo HTML::anchor(catalog::url($company, 'announcements'), ___('announcements.module_links.btn')) ?></td>
							</tr>
							<?php endif; ?>
							<?php endif; ?>
						</table>
					</div>
					
				</div>
				
				<div class="clearfix"></div>
				
				<div class="entry_tabs">

					<ul class="entry_tabs_headers">
						<li class="active"><a href="#company-description"><?php echo ___('catalog.company_description') ?></a></li>

						<?php
						$have_products = Modules::enabled('site_products') ? Model_Product::count_by_company($company) : FALSE;
						
						if($have_products): ?>
						<li><a href="#company-products"><?php echo ___('catalog.company_products') ?></a></li>
						<?php endif; ?>

						<?php if(isset($offers) && count($offers)): ?>
						<li><a href="#company-promotions"><?php echo ___('offers.company.title') ?></a></li>
						<?php endif; ?>

						<?php if(catalog::config('settings.reviews.enabled')): ?>
						<li class="last"><a href="#company-reviews"><?php echo ___('catalog.companies.show.reviews', array(':nb' => $pagination_comments->total_items)) ?></a></li>
						 <?php endif; ?>
					</ul>
				
					<div class="container full">

						<div class="active" id="company-description">
							<div class="entry-content">
								<h3><?php echo ___('catalog.company_description') ?>:</h3>
								<div itemprop="description">
									<?php
										$content = $company->company_description;
										$content = Text::linkify($content);
										echo $content;
									?>
								</div>
							</div>
						</div>

						<?php if($have_products): ?>
						<div id="company-products">

							<div class="entry-content">
								<h3><?php echo ___('catalog.company_products') ?>:</h3>
								<div>
									<?php
									$product = new Model_Product;
									$product->filter_by_company($company);
									$product->add_active_conditions();
									$product->limit(6);
									
									echo View::factory('frontend/products/partials/list_rows')
										->set('products', $product->get_list())
										->set('context', 'company');
									?>
									
									<?php if($have_products > 6): ?>
									<div class="box-content-link">
									<?php echo HTML::anchor(catalog::url($company, 'products'), ___('products.see_all_btn'), array('class' => 'see_all_btn')) ?>
									</div>
									<?php endif; ?>
								</div>
							</div>

						</div>
						<?php endif; ?>

						<?php if(isset($offers) && count($offers)): ?>
						<div id="company-promotions">

							<div class="entry-content">
								<h3><?php echo ___('offers.company.title') ?>:</h3>
								<div>
									<?php echo View::factory('frontend/offers/_offers_list')
										->set('offers', $offers) ?>
								</div>
							</div>

						</div>
						<?php endif; ?>
				
						<?php if(catalog::config('settings.reviews.enabled')): ?>
						<div id="company-reviews">
							<div class="entry-content">
								<h3><?php echo ___('catalog.reviews.title') ?>:</h3>
								<div>
									<?php 
									echo View::factory('frontend/catalog/reviews/show')
											->set('comments', $comments)
											->set('pagination', $pagination_comments)
											->set('company', $company)
									?>
								</div>
							</div>
						</div>
						 <?php endif; ?>

					</div>
					
				</div>
				
				<div class="entry_body_top">
					<div class="share">
						<?php 
						$company_link_raw = catalog::url($company);
						$company_link = urlencode($company_link_raw);
						?>


						<div class="share-buttons">

							<a id="fb-share" href="https://www.facebook.com/sharer/sharer.php<?php 
								$fb_params = array(
									's' => 100,
									'p' => array(
										'url' => $company_link_raw,
										'title' => $company->company_name,
										'summary' => Text::limit_chars(strip_tags($company->company_description), 100, '...'),
									),
								);

								if($logo AND $logo->exists('catalog_company_big'))
									$fb_params['p']['images'][0] = $logo->get_url('catalog_company_big', 'http');

								echo URL::query($fb_params, FALSE) ?>" title="<?php echo ___('share.fb') ?>" target="_blank"></a>
							<a id="gg-share" href="gg:/set_status?description=<?php echo $company_link ?>" title="<?php echo ___('share.gg') ?>" target="_blank"></a>
							<a id="wykop-share" href="http://www.wykop.pl/dodaj?url=<?php echo $company_link ?>" title="<?php echo ___('share.wykop') ?>" target="_blank"></a>
							<a id="nk-share" href="http://nasza-klasa.pl/sledzik?shout=<?php echo $company_link ?>" title="<?php echo ___('share.nk') ?>" target="_blank"></a>
							<a id="blip-share" href="http://www.blip.pl/dashboard?body=<?php echo $company_link ?>" title="<?php echo ___('share.blip') ?>" target="_blank"></a>
							<a id="twitter-share" href="http://twitter.com/?status=<?php echo $company_link ?>" title="<?php echo ___('share.twitter') ?>" target="_blank"></a>
							<div style="float:left; margin-top: 8px; margin-left: 3px">
							  <g:plusone size="small"></g:plusone>
							</div>
							<script type="text/javascript">
							  window.____gcfg = {lang: 'pl'};

							  (function() {
								var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
								po.src = 'https://apis.google.com/js/plusone.js';
								var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
						</div>
					</div>

					<ul class="entry_actions">
						<li class="closet">
							<a href="<?php echo Route::url('site_catalog/frontend/catalog/add_to_closet', array(
								'id' => $company->pk(),
							), 'http') ?>"><?php echo ___('to_closet') ?></a>
						</li>
						<li class="print">
							<a href="<?php echo Route::url('site_catalog/frontend/catalog/print', array(
								'id' => $company->pk(),
							), 'http') ?>" target="_blank"><?php echo ___('print') ?></a>
						</li>
						<li class="recommend">
							<a href="<?php echo Route::url('site_catalog/frontend/catalog/send', array(
								'id' => $company->pk(),
							)) ?>"><?php echo ___('share_friend') ?></a>
						</li>
					</ul>
					
				</div>
				
				<div class="clearfix"></div>
				
			</div>


		</div>

	</div>
		
</div>