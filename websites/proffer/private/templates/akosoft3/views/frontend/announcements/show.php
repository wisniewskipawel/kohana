<div id="announcement-show-box" class="announcement box" itemscope itemtype="http://data-vocabulary.org/Offer">
	<div class="box-header">
		<span><?php echo ___('announcement') ?>:</span> 
		<h1 itemprop="name">
			<?php echo HTML::chars($announcement->annoucement_title) ?>

			<?php if (!empty($announcement->product_state)): ?>
			<small class="product_state">
				(<?php echo announcements::product_state($announcement->product_state) ?>)
			</small>
			<?php endif ?>
		</h1>
	</div>
	
	<div class="content">
		
		<div class="meta">
			<span class="date_added"><?php echo ___('announcements.show.date_added') ?>: <?php echo date('Y.m.d', strtotime($announcement->annoucement_date_added)) ?></span>
			<span class="date_availability"><?php echo ___('announcements.show.date_availability') ?>: <?php echo date('Y.m.d', strtotime($announcement->annoucement_availability)) ?></span>
			<span class="visits"><?php echo ___('announcements.show.visits') ?>: <?php echo $announcement->annoucement_visits ?></span>
		</div>
		
		<?php if($announcement->can_show_price() OR $announcement->annoucement_price_to_negotiate): ?>
		<div class="price_box">
					
			<?php if($announcement->annoucement_price !== NULL): ?>
			<span class="price-inner">
				<label><?php echo ___('price') ?>:</label>
				<span class="price">
					<span itemprop="price"><?php echo payment::price_format($announcement->annoucement_price, FALSE) ?></span>
					<span itemprop="currency"><?php echo payment::currency() ?></span>
				</span>
				<?php if ($announcement->annoucement_price_to_negotiate): ?>
					<?php echo ___('announcements.price.negotiable') ?>
				<?php endif; ?>
			</span>
			<?php endif; ?>

			<?php if ($announcement->annoucement_price_to_negotiate AND Kohana::$config->load('modules.site_announcements.suggest_price')): ?>
			<?php echo HTML::anchor(
				$suggest_price_url = Route::get('site_announcements/frontend/announcements/suggest_price')
					->uri(array('id' => $announcement->pk())),
				___('announcements.suggest_price.btn'),
				array(
					'class' => 'suggest_price_btn show_dialog_btn', 
					'data-dialog-target' => "#dialog_suggest_price"
				)
			); ?>

			<div id="dialog_suggest_price" class="dialog hidden box">
				<div class="dialog-title box-header"><?php echo ___('announcements.suggest_price.title') ?></div>
				<?php echo Bform::factory('Frontend_Announcement_SuggestPrice', array(
					'announcement' => $announcement,
				))->action($suggest_price_url)->render() ?>
			</div>
			<?php endif ?>
		</div>
		<?php endif ?>

		<div class="announcement-content entry_content_box">
			<h5><?php echo ___('announcements.show.details') ?>:</h5>
			<div class="entry_content_box_body" itemprop="description">
				<?php
					$content = $announcement->annoucement_content;
					$content = Text::linkify($content);
					echo $content;
				?>
			</div>
		</div>

		<?php $attributes = $announcement->get_attributes(TRUE); if(!empty($attributes) AND count($attributes)): ?>
		<div class="announcement_attributes entry_content_box">
			<h5><?php echo ___('announcements.attributes') ?>:</h5>
			<div class="entry_content_box_body">
				<?php
				$chbox_values = array();

				foreach($attributes as $attribute):
					if($attribute->field->type == 'checkbox')
					{
						$chbox_values[] = $attribute->field->label;
						continue;
					}
				?>
				<div class="attribute">
					<label><?php echo $attribute->field->label ?>:</label>
					<span><?php echo $attribute->value ?></span>
				</div>
				<?php endforeach; ?>

				<?php if(!empty($chbox_values)): ?>
				<div class="checkbox_attributes">
					<?php echo implode(', ', $chbox_values); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
			
		<?php if ($images = $announcement->get_images()): ?>
		<div class="entry_content_box">
			<div id="slider-gallery" class="slider">
				<div class="slider-track">
					<ul>
						<?php foreach ($images as $i): ?>
						<li>
							<div class="image-wrapper">
								<a title="<?php echo Security::xss_clean($announcement->annoucement_title) ?>" href="<?php echo URL::site($i->get_uri('announcement_big')) ?>">
									<img src="<?php echo URL::site($i->get_uri('announcement_list')) ?>" alt="" />
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
		
		<?php if(!announcements::config('youtube_view_disabled') AND $announcement->annoucement_youtube): ?>
		<div class="entry_content_box">
			<h5><?php echo ___('video') ?></h5>

			<div class="entry_content_box_body">
				<?php Media::js('jquery.fitvids.js', 'js/vendor'); ?>
				<div id="announcement-video">
					<iframe src="http://www.youtube.com/embed/<?php echo Tools::youtube_video_id($announcement->annoucement_youtube) ?>" frameborder="0" allowfullscreen></iframe>
				</div>
				<script>
				$(function() {
					$("#announcement-video").fitVids();
				});
				</script>
			</div>
		</div>
		<?php endif ?>

		<div class="entry_content_box" itemprop="seller" itemscope itemtype="http://schema.org/Person">
			<h5><?php echo ___('contact') ?></h5>

			<div class="entry_content_box_body">
				
				<div class="contact-details">
					<div class="author" itemprop="name"><?php echo $announcement->contact_data()->display_name() ?></div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="address">
								<?php echo $announcement->contact_data()->address->render('single_line') ?>
								
								<?php if($announcement->contact_data()->address->province_id != Regions::ALL_PROVINCES): ?>
								<span class="show_map_container">
									(<a href="#" class="show_dialog_btn show_map_btn" data-dialog-target="#dialog_map"><span class="glyphicon glyphicon-globe"></span> <?php echo ___('show_on_map') ?></a>)
								</span>
								
								<div id="dialog_map" class="dialog hidden box dialog_map">
									<div class="dialog-title box-header"><?php echo ___('map') ?></div>
									<div id="map" data-map_lat="<?php echo $announcement->annoucement_map_lat ?>" data-map_lng="<?php echo $announcement->annoucement_map_lng ?>" data-map_addr="<?php echo HTML::chars($announcement->contact_data()->address->city.', '.$announcement->contact_data()->address->street) ?>" data-map_point_title="<?php echo HTML::chars($announcement->contact_data()->display_name()) ?>"></div>
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

							<a href="<?php echo $contact_url = Route::url('site_announcements/frontend/announcements/contact', array('id' => $announcement->pk())) ?>" class="contact_btn btn btn-default show_dialog_btn" data-dialog-target="#dialog_contact"><?php echo ___('contact') ?></a>
							<div id="dialog_contact" class="dialog hidden box">
								<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
								<?php echo Bform::factory('Frontend_Announcement_SendMessage', array(
									'announcement' => $announcement,
								))->action($contact_url)->render() ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="contact-meta">
								<?php if ( !announcements::config('email_view_disabled')): ?>
								<div class="email">
									<span><?php echo ___('email') ?>:</span>
									<?php echo announcements::curtain($announcement, 'email', ___('email.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if ($announcement->annoucement_telephone): ?>
								<div class="telephone">
									<span><?php echo ___('telephone') ?>:</span>
									<?php echo announcements::curtain($announcement, 'telephone', ___('telephone.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if($announcement->contact_data()->www): ?>
								<div class="www">
									<span><?php echo ___('annoucement_www') ?>:</span>
									<a href="<?php echo Tools::link($announcement->contact_data()->www) ?>" target="_blank"><?php echo URL::idna_decode($announcement->contact_data()->www) ?></a>
								</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				
					<?php
					$user = $announcement->user;
					
					if($user):
					$other_announcements_count = Model_Announcement::factory()
						->filter_by_user($user)
						->where('annoucement_id', '!=', $announcement->pk())
						->add_active_conditions()
						->count_all();

					if($other_announcements_count OR ($announcement->has_company() AND $announcement->catalog_company->is_promoted())):
					?>
					<div class="user_other_entries">
						<ul>
							<?php if ($announcement->has_company() AND $announcement->catalog_company->is_promoted()): ?>
							<li class="company_link">
								<?php echo HTML::anchor(catalog::url($announcement->catalog_company), '<i class="glyphicon glyphicon-briefcase"></i> '.___('catalog.module_links.btn'), array(
									'target' => ($announcement->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</li>
							<?php endif; ?>
							<?php if($other_announcements_count): ?>
							<li><?php echo HTML::anchor(Route::get('site_announcements/frontend/announcements/show_by_user')->uri(array(
								'id' => $user->pk(),
							)), ___('template.user_announcements')) ?></li>
							<?php endif ?>
						</ul>
					</div>
					<?php endif; endif; ?>
				</div>
				
			</div>
		</div>

		<div class="bottom">
			<?php if(!$announcement->is_archived()): ?>
			<ul class="announcement-actions">
				<li class="closet"><a href="<?php echo Route::url('site_announcements/profile/announcements/add_to_closet', array('id' => $announcement->annoucement_id)) ?>"><?php echo ___('to_closet') ?></a></li>
				<li class="print"><a href="<?php echo Route::url('site_announcements/frontend/announcements/print', array(
					'id' => $announcement->pk(),
				)) ?>" target="_blank"><?php echo ___('print') ?></a></li>
				<li class="report"><a rel="nofollow" href="<?php echo Route::url('site_announcements/frontend/announcements/report', array('id' => $announcement->annoucement_id)) ?>"><?php echo ___('report') ?></a></li>
			</ul>
			<?php endif; ?>

			<div class="announcement-share">
				<span class="l"><?php echo ___('share') ?>:</span>
				
				<?php
				$share = new Share(
					announcements::url($announcement, 'http'), 
					$announcement->annoucement_title, 
					Text::limit_chars(strip_tags($announcement->annoucement_content), 100, '...')
				);

				if($images AND $images->first() AND $images->first()->exists('announcement_big'))
					$share->add_image(URL::site($images->first()->get_uri('announcement_big'), 'http'));

				$share->add_send_friend_form(
					$send_url = Route::url('site_announcements/frontend/announcements/send', array('id' => $announcement->annoucement_id)),
					Bform::factory('Frontend_Announcement_Send', array(
						'announcement' => $announcement,
					))->action($send_url)->render(),
					___('announcements.send.title')
				);

				echo $share->render();
				?>
			</div>
		</div>
		
		<?php if(isset($comments))
		{
			$comments->form_add_comment->param('layout', 'forms/comments');
			echo $comments;
		}
		?>
		
	</div>
</div>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>