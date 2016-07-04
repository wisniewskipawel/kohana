<?php 
$template->set_layout($current_module->view('layouts/full'));
$images = $announcement->get_images(NULL, TRUE); 
$attributes = $announcement->get_fields();
$contact = $announcement->get_contact();
$category_alias = $announcement->last_category->get_category_alias();
?>
<div id="announcement-show-box" class="box" itemscope itemtype="http://data-vocabulary.org/Offer">
	<div class="box-header">
		<span><?php echo $current_module->trans('announcement') ?>:</span> 
		<h1 itemprop="name">
			<?php echo HTML::chars($announcement->annoucement_title) ?>

			<?php if (!empty($announcement->product_state)): ?>
			<small class="product_state">
				(<?php echo \AkoSoft\Modules\AnnouncementsMoto\Announcements::product_state($announcement->product_state) ?>)
			</small>
			<?php endif ?>
		</h1>
	</div>
	<div class="content">
		
		<div class="meta">
			<span class="date_added"><?php echo $current_module->trans('show.date_added') ?>: <?php echo date('Y.m.d', strtotime($announcement->annoucement_date_added)) ?></span>
			<span class="date_availability"><?php echo $current_module->trans('show.date_availability') ?>: <?php echo date('Y.m.d', strtotime($announcement->annoucement_availability)) ?></span>
			<span class="visits"><?php echo $current_module->trans('show.visits') ?>: <?php echo $announcement->annoucement_visits ?></span>
		</div>
		
		<div class="entry_show_box">
			<div class="top-side">

				<div class="left-side">
					
					<?php if($announcement->annoucement_price !== NULL OR $announcement->annoucement_price_to_negotiate): ?>
					<div class="price_box">

						<?php if($announcement->annoucement_price !== NULL): ?>
						<span class="price-inner">
							<label><?php echo ___('price') ?>:</label>
							<span class="price">
								<span itemprop="price"><?php echo payment::price_format($announcement->annoucement_price, FALSE) ?></span>
								<span itemprop="currency"><?php echo payment::currency() ?></span>
							</span>
							<?php if ($announcement->annoucement_price_to_negotiate): ?>
								<?php echo $current_module->trans('price.negotiable') ?>
							<?php endif; ?>
						</span>
						<?php endif; ?>

						<?php if ($announcement->annoucement_price_to_negotiate AND $current_module->config('suggest_price')): ?>
						<?php echo HTML::anchor(
							$suggest_price_url = $current_module->route('frontend/announcements/suggest_price')
								->uri(array('id' => $announcement->pk())),
							$current_module->trans('suggest_price.btn'),
							array(
								'class' => 'suggest_price_btn show_dialog_btn', 
								'data-dialog-target' => "#dialog_suggest_price"
							)
						); ?>

						<div id="dialog_suggest_price" class="dialog hidden box">
							<div class="dialog-title box-header"><?php echo $current_module->trans('suggest_price.title') ?></div>
							<?php echo Bform::factory(new \AkoSoft\Modules\AnnouncementsMoto\Forms\Frontend\SuggestPriceForm, array(
								'announcement' => $announcement,
							))->action($suggest_price_url)->render() ?>
						</div>
						<?php endif ?>
					</div>
					<?php endif ?>
					
					<ul class="price_options">
						<?php if($announcement->announcement_invoice): ?>
						<li><i class="glyphicon glyphicon-ok"></i> <?php echo $current_module->trans('show.announcement_invoice') ?></li>
						<?php endif ?>
						<?php if($announcement->announcement_credit): ?>
						<li><i class="glyphicon glyphicon-ok"></i> <?php echo $current_module->trans('show.announcement_credit') ?></li>
						<?php endif ?>
					</ul>
							
					<div id="announcement-images" class="image-box active">
						<?php if(count($images)): ?>
						<div class="big image-wrapper">
							<a href="<?php echo $images->first()->get_url('announcement_big') ?>">
								<img src="<?php echo $images->first()->get_url('announcement_show_big') ?>" />
							</a>
						</div>

						<div class="other_images nav">
							<a class="prev browse left"></a>
							<div class="scrollable">
								<ul class="items">
									<?php foreach($images as $image): ?>
									<li>
										<div class="image-wrapper">
											<a href="<?php echo $image->get_url('announcement_big') ?>">
												<img src="<?php echo $image->get_url('announcement_list') ?>" data-showbig="<?php echo $image->get_url('announcement_show_big') ?>" alt="" />
											</a>
										</div>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<a class="next browse right"></a>
						</div>
						<?php else: ?>
						<div class="big image-wrapper no-photo">
							<div>
								<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
							</div>
						</div>
						<?php endif; ?>
					</div>
							
					<?php if(!$current_module->config('youtube_view_disabled') AND $announcement->annoucement_youtube): ?>
					<?php Media::js('jquery.fitvids.js', 'js/vendor'); ?>
					<div id="announcement-video">
						<iframe src="http://www.youtube.com/embed/<?php echo Tools::youtube_video_id($announcement->annoucement_youtube) ?>" frameborder="0" allowfullscreen></iframe>
					</div>
					<script>
					$(function() {
						$("#announcement-video").fitVids();
					});
					</script>
					<?php endif ?>
					
				</div>


				<div class="info-main right-side">

					<?php 
					if($category_alias AND $attributes)
						echo $current_module->view('frontend/partials/show/attributes/tables/'.$category_alias)
							->set('announcement', $announcement)
							->set('attributes', $attributes)
					?>
					
				</div>
			</div>

			<div class="bottom-side">
				<?php if($category_alias AND $attributes):
					$render_additional_fields = $current_module->view('frontend/partials/show/attributes/additional_fields/'.$category_alias)
						->set('announcement', $announcement)
						->set('attributes', $attributes)
						->render();
				
				if($render_additional_fields): ?>
				<div id="entry_additional_fields" class="entry_content_box">
					<h5><?php echo $current_module->trans('show.additional_fields') ?></h5>
					<div class="entry_content_box-content">
					<?php echo $render_additional_fields ?>
					</div>
				</div>
				<?php endif; ?>
				<?php endif; ?>

				<div id="entry_details" class="entry_content_box">
					<h5><?php echo $current_module->trans('show.details') ?></h5>
					<div class="entry_content_box-content text">
						<?php
							echo Text::linkify($announcement->annoucement_content);
						?>
					</div>
				</div>
				
			</div>
					
			<div class="entry_content_box" itemprop="seller" itemscope itemtype="http://schema.org/Person">
				<h5><?php echo ___('contact') ?></h5>

				<div class="entry_content_box_body">

					<div class="contact-details">
						<div class="author" itemprop="name"><?php echo $contact->display_name() ?></div>

						<div class="row">
							<div class="col-md-6">
								<div class="address">
									<?php echo $contact->address->render('single_line') ?>
									
									<?php if($contact->address->province_id != Regions::ALL_PROVINCES): ?>
									<span class="show_map_container">
										(<a href="#" class="show_dialog_btn show_map_btn" data-dialog-target="#dialog_map"><span class="glyphicon glyphicon-globe"></span> <?php echo ___('show_on_map') ?></a>)
									</span>
									
									<div id="dialog_map" class="dialog hidden box dialog_map">
										<div class="dialog-title box-header"><?php echo ___('map') ?></div>
										<div id="map" data-map_lat="<?php echo $announcement->annoucement_map_lat ?>" data-map_lng="<?php echo $announcement->annoucement_map_lng ?>" data-map_addr="<?php echo HTML::chars($contact->address->city.', '.$contact->address->street) ?>" data-map_point_title="<?php echo HTML::chars($contact->display_name()) ?>"></div>
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

								<a href="<?php echo $contact_url = $current_module->route_url('frontend/announcements/contact', array('id' => $announcement->pk())) ?>" class="contact_btn btn btn-default show_dialog_btn" data-dialog-target="#dialog_contact"><?php echo ___('contact') ?></a>
								<div id="dialog_contact" class="dialog hidden box">
									<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
									<?php echo Bform::factory(new AkoSoft\Modules\AnnouncementsMoto\Forms\Frontend\ContactForm(), array(
										'announcement' => $announcement,
									))->action($contact_url)->render() ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="contact-meta">
									<?php if (!$current_module->config('email_view_disabled') && $contact->email): ?>
									<div class="email">
										<span><?php echo ___('email') ?>:</span>
										<?php echo AkoSoft\Modules\AnnouncementsMoto\Announcements::curtain($announcement, 'email', ___('email.curtain')) ?>
									</div>
									<?php endif ?>

									<?php if ($contact->phone): ?>
									<div class="telephone">
										<span><?php echo ___('telephone') ?>:</span>
										<?php echo AkoSoft\Modules\AnnouncementsMoto\Announcements::curtain($announcement, 'telephone', ___('telephone.curtain')) ?>
									</div>
									<?php endif ?>

									<?php if($contact->www): ?>
									<div class="www">
										<span><?php echo ___('www') ?>:</span>
										<a href="<?php echo Tools::link($contact->www) ?>" target="_blank"><?php echo URL::idna_decode($contact->www) ?></a>
									</div>
									<?php endif ?>

									<?php if($announcement->announcement_gadu): ?>
									<div class="gadu_number">
										<span class="label"><?php echo $current_module->trans('show.gadu') ?>:</span> 
										<?php echo HTML::chars($announcement->announcement_gadu) ?>
									</div>
									<?php endif; ?> 

									<?php if($announcement->announcement_skype): ?>
									<div class="skype">
										<span class="label"><?php echo $current_module->trans('show.skype') ?>:</span> 
										<?php echo HTML::chars($announcement->announcement_skype) ?>
									</div>
									<?php endif; ?> 
								</div>
							</div>
						</div>

						<?php
						$other_announcements_count = $announcement->count_user_announcements(TRUE);

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
								<li><?php echo HTML::anchor($current_module->route('frontend/announcements/show_by_user')->uri(array(
									'id' => $announcement->user->pk(),
								)), $current_module->trans('show.user_announcements')) ?></li>
								<?php endif ?>
							</ul>
						</div>
						<?php endif; ?>
					</div>

				</div>
			</div>
			
<?php if (Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>

			<div class="bottom">
				<ul class="announcement-actions">
					<li class="closet"><a href="<?php echo $current_module->route_url('profile/announcements/add_to_closet', array('id' => $announcement->annoucement_id)) ?>"><?php echo ___('to_closet') ?></a></li>
					<li class="print"><a href="javascript:window.print()"><?php echo ___('print') ?></a></li>
					<li class="report">
						<a rel="nofollow" href="<?php 
						echo $current_module->route_url('frontend/announcements/report', array(
							'id' => $announcement->annoucement_id,
						)) ?>" class="show_dialog_btn" data-dialog="dialog-announcement-report"><?php echo ___('report') ?></a>

						<div id="dialog-announcement-report" class="dialog" data-dialog-title="<?php echo $current_module->trans('report.title') ?>">
							<?php 
							$report_form = Bform::factory(new AkoSoft\Modules\AnnouncementsMoto\Forms\Frontend\ReportForm());
							echo $report_form
								->action($current_module->route_url('frontend/announcements/report', array(
									'id' => $announcement->pk(),
								)))
								->param('class', 'bform form-stripped');
							?>
						</div>
					</li>
				</ul>

				<div class="announcement-share">
					<span class="l"><?php echo ___('share') ?>:</span>
					
					<?php
					$share = new Share(
						AkoSoft\Modules\AnnouncementsMoto\Announcements::url($announcement, 'http'), 
						$announcement->annoucement_title, 
						Text::limit_chars(strip_tags($announcement->annoucement_content), 100, '...')
					);
					
					if($images AND $images->first() AND $images->first()->exists('announcement_big'))
						$share->add_image(URL::site($images->first()->get_uri('announcement_big'), 'http'));
					
					$share->add_send_friend_form(
						$send_url = $current_module->route_url('frontend/announcements/send', array('id' => $announcement->annoucement_id)),
						Bform::factory(new AkoSoft\Modules\AnnouncementsMoto\Forms\Frontend\SendFriendForm(), array(
							'announcement' => $announcement,
						))->action($send_url)->render(),
						$current_module->trans('send.title')
					);
					
					echo $share->render();
					?>
				</div>
			</div>
				
			<?php 
			if(isset($comments)):
				$comments->form_add_comment->param('layout', 'forms/comments');
			?>
			<div id="entry_comments" class="entry_content_box">
				<h5><?php echo $current_module->trans('comments.title') ?></h5>
				<div class="entry_content_box-content">
					<?php echo $comments ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>



<?php if(!empty($similar_announcements)): ?>
<div class="box gray announcements-similar">
	<div class="box-header"><?php echo $current_module->trans('boxes.similar.title') ?></div>
	<div class="content">
		<ul>
			<?php foreach ($similar_announcements as $a): ?>
				<?php $announcement_link = Route::url('site_announcements/frontend/announcements/show', array(
								'announcement_id' => $a->annoucement_id, 
								'title' => URL::title($a->annoucement_title)
						)); ?>

			<li>
				<div class="left">
					<div class="photo">
						<a href="<?php echo $announcement_link ?>">
							<?php $image = $a->get_images(1); if (!empty($image) && $image->exists('announcement_list')): ?>
							<img src="<?php echo $image->get_url('announcement_list') ?>" alt="" class="announcement-photo" />
							<?php else: ?>
							<img src="<?php echo URL::site('/media/images/no_photo.jpg'); ?>" alt="" class="announcement-photo no-photo" />
							<?php endif; ?>
						</a>
					</div>
				</div>
				<div class="right">
					<h3>
						<a href="<?php echo $announcement_link ?>"><?php echo $a->annoucement_title ?></a>
					</h3>
					<p><?php echo $a->annoucement_price ?> PLN</p>
				</div>
			</li>

			<?php endforeach ?>
		</ul>
	</div>
</div>
<?php endif ?>

<script type="text/javascript">
$(function() {
	$('.show_dialog_btn').on('click', function(e){
		e.preventDefault();

		var $this = $(this);

		var dialog_id = $this.attr("data-dialog");
		var $dialog = $("#" + dialog_id);
		$dialog.dialog("open");
		$this.blur();
	});
});
</script>