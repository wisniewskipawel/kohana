<div class="box primary entry_show_box">
	<h2><?php echo ___('jobs.job') ?></h2>
	<div class="content">
		
		<?php 
		if($job->is_archived()) 
			echo FlashInfo::display(___('jobs.show.archived.info', array(
				':date' => date('Y-m-d', strtotime($job->date_availability)),
			)), FlashInfo::WARNING);
		?>

		<div class="job entry_body" itemscope itemtype="http://data-vocabulary.org/Offer">

			<h1 itemprop="name"><?php echo HTML::chars($job->title) ?></h1>

			<div class="content">
				
				<?php if(!$job->is_archived()): ?>
				
				<?php endif; ?>
				
				<div class="job-info-side">
					<div class="job-info">
						<div class="job-box">
							<h3><?php echo ___('jobs.show.details') ?>:</h3>
							<div class="job-box-contents">
						
								<dl class="price_box">
									<dt><?php echo ___('jobs.show.price') ?>:</dt>
									<dd class="price">
										<?php if($job->price === NULL): ?>
										<?php echo ___('jobs.show.price.not_set') ?>
										<?php else: ?>
										<span itemprop="price"><?php echo payment::price_format($job->price, FALSE) ?></span>
										<span itemprop="currency"><?php echo payment::currency() ?></span>
										<?php endif ?>
									</dd>
								</dl>

								<dl class="count_replies">
									<dt><?php echo ___('jobs.show.count_replies') ?>:</dt>
									<dd><?php echo (int)$job->count_replies ?></dd>
								</dl>

								<dl class="date_added">
									<dt><?php echo ___('jobs.show.date_added') ?>:</dt>
									<dd><?php echo date('Y.m.d', strtotime($job->date_added)) ?></dd>
								</dl>

								<dl class="date_availability">
									<dt><?php echo ___('jobs.show.date_availability') ?>:</dt>
									<dd class="red"><?php echo date('Y.m.d', strtotime($job->date_availability)) ?></dd>
								</dl>

								<dl class="visits">
									<dt><?php echo ___('jobs.show.visits') ?>:</dt>
									<dd><?php echo $job->visits ?></dd>
								</dl>

								<dl class="date_realization_limit">
									<dt><?php echo ___('jobs.show.date_realization_limit') ?>:</dt>
									<dd>
										<?php if($job->date_realization_limit === NULL): ?>
										<?php echo ___('jobs.show.price.not_set') ?>
										<?php else: ?>
										<?php echo date('Y.m.d', strtotime($job->date_realization_limit)) ?>
										<?php endif ?>
									</dd>
								</dl>
								
							</div>
						</div>
					</div>
					
					<div class="job-info">
						
						<?php if($job->has_user()): ?>
						<div id="job-contact-data-box" class="job-box">
							<h3><?php echo ___('jobs.show.principal') ?>:</h3>
							<div class="job-box-contents" itemprop="seller" itemscope itemtype="http://schema.org/Person">
								
								<div class="person_name">
									<?php if($job->contact_data()->display_name()): ?>
									<?php echo HTML::chars($job->contact_data()->display_name()); ?>
									<?php else: ?>
									<?php echo HTML::chars($job->get_user()->user_name); ?>
									<?php endif; ?>
								</div>
								
								<address>
									<?php echo $job->contact_data()->address->render('single_line') ?>
									<?php if($job->contact_data()->address->province_id != Regions::ALL_PROVINCES): ?>
									(<a href="#" class="show_dialog_btn show_map_btn" data-dialog-target="#dialog_map"><?php echo ___('jobs.show.show_on_map') ?></a>)
									
									<div id="dialog_map" class="dialog hidden">
										<div class="dialog-title"><?php echo ___('map') ?></div>
										<div class="dialog-contents">
											<div id="job-map"></div>
										</div>
									</div>

									<script type="text/javascript">
									var mapa;

									$(function() {
										$(document).on('dialog.showed', '#dialog_map', function() {

											<?php if($job->map_lat <= 0 OR $job->map_lng <= 0): ?>
											var geocoder = new google.maps.Geocoder();
											geocoder.geocode({address: '<?php echo HTML::chars($job->city) ?>, <?php echo HTML::chars($job->street) ?>'}, get_address);

											function get_address(results, status)
											{
												if(status == google.maps.GeocoderStatus.OK) 
												{
													var point = results[0].geometry.location;

													init_map(point);
												}
												else
												{
													$('#job-map').hide();
												}
											}   
											<?php else: ?>
											init_map(new google.maps.LatLng(<?php echo $job->map_lat ?>, <?php echo $job->map_lng ?>));
											<?php endif; ?>
										});
									});

									function init_map(center_point) {
										var map_options = {
										  zoom: 14,
										  center: center_point,
										  mapTypeId: google.maps.MapTypeId.ROADMAP
										};

										mapa = new google.maps.Map(document.getElementById("job-map"), map_options);

										var marker_options =
										{
											position: center_point,
											map: mapa,
											title: '<?php echo HTML::chars($job->title) ?>'
										}
										var marker = new google.maps.Marker(marker_options);
									}
									</script>
									<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
									<?php endif; ?>
								</address>
								
								<?php if($job->contact_data()->phone): ?>
								<div class="phone">
									<?php echo Jobs::curtain($job, 'telephone', ___('telephone.curtain')); ?>
								</div>
								<?php endif; ?>
								
								<?php if(Jobs::config('show_email') AND $job->get_email_address()): ?>
								<div class="email">
									<?php echo Jobs::curtain($job, 'email', ___('email.curtain')); ?>
								</div>
								<?php endif; ?>
								
								<?php $contact_uri = Route::get('site_jobs/frontend/jobs/contact')->uri(array('id' => $job->pk())); ?>
								<a href="<?php echo URL::site($contact_uri) ?>" class="contact_btn btn btn-default show_dialog_btn" data-dialog-target="#dialog_contact"><?php echo ___('contact') ?></a>
								<div id="dialog_contact" class="dialog hidden">
									<div class="dialog-title"><?php echo ___('contact') ?></div>
									<div class="dialog-contents">
										<?php echo Bform::factory('Frontend_Jobs_Contact', array(
											'job' => $job,
										))->action($contact_uri)->render() ?>
									</div>
								</div>
								
							</div>
						</div>
						<?php endif; ?>
						
					</div>
				</div>

				<div class="clearfix"></div>

				<?php $attributes = $job->get_attributes(TRUE); if($attributes AND count($attributes)): ?>
				<div class="job_attributes job-box">
					<h3><?php echo ___('jobs.attributes') ?>:</h3>
					<div class="job-box-contents">
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

				<div class="job-box">
					<h3><?php echo ___('jobs.show.content') ?>:</h3>
					<div class="job-box-contents job-content" itemprop="description">
						<?php
							$content = $job->content;
							$content = Text::linkify($content);
							echo $content;
						?>
					</div>
				</div>

				<div class="job-actions-side">

					<div class="share">
						<?php
						$job_link_raw = URL::site(Jobs::uri($job), 'http');
						$job_link = urlencode($job_link_raw);
						?>

						
						<div class="share-buttons">
							<a id="fb-share" href="https://www.facebook.com/sharer/sharer.php<?php 
								$fb_params = array(
									's' => 100,
									'p' => array(
										'url' => $job_link_raw,
										'title' => $job->title,
										'summary' => Text::limit_chars(strip_tags($job->content), 100, '...'),
									),
								);

								echo URL::query($fb_params, FALSE) ?>" title="<?php echo ___('share.fb') ?>" target="_blank"></a>
							<a id="gg-share" href="gg:/set_status?description=<?php echo $job_link ?>" title="<?php echo ___('share.gg') ?>" target="_blank"></a>
							<a id="wykop-share" href="http://www.wykop.pl/dodaj?url=<?php echo $job_link ?>" title="<?php echo ___('share.wykop') ?>" target="_blank"></a>
							<a id="nk-share" href="http://nasza-klasa.pl/sledzik?shout=<?php echo $job_link ?>" title="<?php echo ___('share.nk') ?>" target="_blank"></a>
							<a id="blip-share" href="http://www.blip.pl/dashboard?body=<?php echo $job_link ?>" title="<?php echo ___('share.blip') ?>" target="_blank"></a>
							<a id="twitter-share" href="http://twitter.com/?status=<?php echo $job_link ?>" title="<?php echo ___('share.twitter') ?>" target="_blank"></a>
							<div style="float:left; margin-top: 4px; margin-left: 3px">
								<g:plusone size="small"></g:plusone>
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
					</div>

					<ul class="job-actions">
						<li class="closet">
							<a href="<?php echo Route::url('site_jobs/profile/closet/add', array(
								'id' => $job->pk(),
							)) ?>"><?php echo ___('to_closet') ?></a>
						</li>
						<li class="print">
							<a href="<?php echo Route::url('site_jobs/frontend/jobs/print', array(
								'id' => $job->pk(),
							)) ?>" target="_blank"><?php echo ___('print') ?></a>
						</li>
						<li class="recommend">
							<a href="<?php echo Route::url('site_jobs/frontend/jobs/send', array(
								'id' => $job->pk(),
							)) ?>"><?php echo ___('share_friend') ?></a>
						</li>
						<li class="report">
							<a rel="nofollow" href="<?php echo Route::url('site_jobs/frontend/jobs/report', array(
								'id' => $job->pk(),
							)) ?>"><?php echo ___('report') ?></a>
						</li>
					</ul>

				</div>
				
				<?php echo Widget_Box::factory('jobs/replies')->set_job($job)->render(); ?>
				<?php echo Widget_Box::factory('jobs/comments')->set_job($job)->render(); ?>

			</div>

		</div>

		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>

	</div>

</div>
