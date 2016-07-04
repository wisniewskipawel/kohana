<div id="show_company_box" class="box primary" itemscope itemtype="http://schema.org/Organization">
	
	<div class="box-header">
		<span><?php echo ___('catalog.company') ?>:</span> 
		<h1 itemprop="name"><?php echo HTML::chars($company->company_name) ?></h1>
		
		<?php $logo = $company->get_logo(); if($logo AND $logo->exists('catalog_company_list')): ?>
		<div class="company-logo">
			<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="" itemprop="logo" />
		</div>
		<?php endif; ?>
	</div>
	
	<div class="content">

		<div id="company-description" class="entry_content_box">
			<h5><?php echo ___('catalog.company_description') ?>:</h5>
			<div class="entry-content entry_content_box_body">

				<div itemprop="description">
					<?php
						$content = $company->company_description;
						$content = Text::linkify($content);
						echo $content;
					?>
				</div>

			</div>
		</div>
			
		<?php 
		$images_limit  = $company->get_promotion_type_limit('images');
		if($images_limit AND $images = $company->get_images()): ?>
		<div class="entry_content_box">
			<div id="slider-gallery" class="slider">
				<div class="slider-track">
					<ul>
						<?php foreach(new LimitIterator($images, 0, $images_limit) as $image): ?>
						<li>
							<div class="image-wrapper">
								<a class="slide_photo inner" title="<?php echo HTML::chars($company->company_name) ?>" href="<?php echo $image->get_url('catalog_company_big') ?>">
									<img src="<?php echo $image->get_url('catalog_company_list') ?>" data-showbig="<?php echo $image->get_url('catalog_company_thumb_big') ?>" alt="" />
								</a>
							</div>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
				<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
				<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
			</div>
		</div>
		<?php endif ?>
		
		<div class="entry_content_box" itemprop="location" itemscope itemtype="http://schema.org/Place">
			<h5><?php echo ___('contact') ?></h5>

			<div class="entry_content_box_body">
				
				<div class="contact-details">
					<div class="author" itemprop="name"><?php echo $company->get_contact()->display_name() ?></div>
					
					<div class="row">
						<div class="col-lg-5 col-sm-6">
							<div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
								<?php 
								$contact = $company->get_contact();
								echo $contact->address->render('single_line') ?>
								
								<?php if($contact->address->province_id != Regions::ALL_PROVINCES): ?>
								<span class="show_map_container">
									(<a href="#" class="show_dialog_btn show_map_btn" data-dialog-target="#dialog_map"><span class="glyphicon glyphicon-globe"></span> <?php echo ___('show_on_map') ?></a>)
								</span>

								<div id="dialog_map" class="dialog hidden box dialog_map">
									<div class="dialog-title box-header"><?php echo ___('map') ?></div>
									<div id="map" data-map_lat="<?php echo $company->company_map_lat ?>" data-map_lng="<?php echo $company->company_map_lng ?>" data-map_addr="<?php echo HTML::chars($contact->address->city.', '.$contact->address->street) ?>" data-map_point_title="<?php echo HTML::chars($contact->display_name()) ?>"></div>
								</div>

								<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
								<script type="text/javascript">
								$(function() {

									$('#map').css({
										width: $(window).width()*0.8,
										height: $(window).height()*0.6
									});

									$(document)
										.on('dialog.showed', '.dialog_map', function(event, $btn) {
											var $map = $(this).find('#map');
											var data = $map.data();

											if(data['map_lat'] && data['map_lng']) {
												init_map($map[0], new google.maps.LatLng(data['map_lat'], data['map_lng']), data['map_point_title']);
												$.fancybox.resize();
												$.fancybox.center();
											} else if(data['map_addr']) {
												var geocoder = new google.maps.Geocoder();
												geocoder.geocode({address: data['map_addr']}, function(results, status) {
													if(status == google.maps.GeocoderStatus.OK) {
														var point = results[0].geometry.location;
														init_map($map[0], point, data['map_point_title']);
														$.fancybox.resize();
														$.fancybox.center();
													}
												});
											}
										});
								});

								function init_map($map, center_point, point_title) {
									var map_options = {
									  zoom: 14,
									  center: center_point,
									  mapTypeId: google.maps.MapTypeId.ROADMAP
									};

									var mapa = new google.maps.Map($map, map_options);

									var marker_options =
									{
										position: center_point,
										map: mapa,
										title: point_title
									}
									var marker = new google.maps.Marker(marker_options);
								}
								</script>
								<?php endif; ?>
							</div>
							
							<?php if ($company->get_contact()->nip): ?>
							<div class="company_nip">
								<span><?php echo ___('nip') ?>:</span>
								<span class="val"><?php echo HTML::chars($company->get_contact()->nip) ?></span>
							</div>
							<?php endif ?>

							<a href="<?php echo $contact_url = Route::url('site_catalog/frontend/company/contact', array('id' => $company->pk())) ?>" class="contact_btn btn btn-default btn-block show_dialog_btn" data-dialog-target="#dialog_contact"><?php echo ___('contact') ?></a>
							<div id="dialog_contact" class="dialog hidden box">
								<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
								<?php echo Bform::factory(new Form_Frontend_Catalog_SendMessage, array(
									'company' => $company,
								))->action($contact_url)->render() ?>
							</div>
						</div>
						
						<?php if ($company->has_company_hours()): ?>
						<div class="col-lg-3 col-sm-6">
							<div class="opening_hours_side">
								<h5><?php echo ___('catalog.company_hours') ?>:</h5>

								<div class="company_hours">
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
								</div>
							</div>
						</div>
						<?php endif; ?>
						
						<div class="col-lg-4 col-sm-12">
							<div class="contact-meta">
								<?php if ( !catalog::config('email_view_disabled') && $company->get_contact()->email): ?>
								<div class="email">
									<span><?php echo ___('email') ?>:</span>
									<?php echo catalog::curtain($company, 'email', ___('email.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if ($company->get_contact()->phone): ?>
								<div class="telephone">
									<span><?php echo ___('telephone') ?>:</span>
									<?php echo catalog::curtain($company, 'telephone', ___('telephone.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if($company->get_contact()->www): ?>
								<div class="www">
									<span><?php echo ___('www') ?>:</span>
									<a href="<?php echo Tools::link($company->get_contact()->www) ?>" target="_blank"><?php echo URL::idna_decode($company->get_contact()->www) ?></a>
								</div>
								<?php endif ?>
							</div>
						</div>
					</div>
					
					<div class="company_modules_entries">
						<ul>
							<?php if(Modules::enabled('site_announcements') AND Model_Announcement::count_by_company($company)): ?>
							<li class="announcements">
								<?php echo HTML::anchor(catalog::url($company, 'announcements'), ___('announcements.module_links.btn')) ?>
							</li>
							<?php endif; ?>
							
							<?php if(Modules::enabled('site_offers') AND Model_Offer::count_by_company($company)): ?>
							<li class="offers">
								<?php echo HTML::anchor(catalog::url($company, 'offers'), ___('offers.module_links.btn')) ?>
							</li>
							<?php endif; ?>
							
							<?php if(Modules::enabled('site_products') AND Model_Product::count_by_company($company)): ?>
							<li class="products">
								<?php echo HTML::anchor(catalog::url($company, 'products'), ___('products.module_links.btn')) ?>
							</li>
							<?php endif; ?>
						</ul>
					</div>
					
				</div>
				
			</div>
		</div>
		
		<?php if(Kohana::$config->load('modules.site_catalog.settings.reviews.enabled')): ?>
		<div id="company-reviews" class="entry_content_box">
			<h5><?php echo ___('catalog.reviews.title') ?>:</h5>
			<div class="entry-content entry_content_box_body">
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
		
		<div class="bottom">
			<ul class="company-actions">
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
			</ul>

			<div class="share">
				<span class="l"><?php echo ___('share') ?>:</span>
				<?php
				$share = new Share(
					catalog::url($company), 
					$company->company_name, 
					Text::limit_chars(strip_tags($company->company_description), 100, '...')
				);
				
				if($logo AND $logo->exists('catalog_company_big'))
					$share->add_image($logo->get_url('catalog_company_big', 'http'));

				$share->add_send_friend_form(
					$send_url = Route::url('site_catalog/frontend/catalog/send', array('id' => $company->pk())),
					Bform::factory(new Form_Frontend_Catalog_Company_Send, array(
						'company' => $company,
					))->action($send_url)->render(),
					___('catalog.companies.send.title')
				);

				echo $share->render();
				?>
			</div>
		</div><!-- /.bottom -->

	</div><!-- /.content -->
		
</div>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>