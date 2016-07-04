<div id="job-show-box" class="box primary" itemscope itemtype="http://data-vocabulary.org/Offer">
	<div class="box-header">
		<span><?php echo ___('jobs.job') ?>:</span> 
		<h1 itemprop="name">
			<?php echo HTML::chars($job->title) ?>
		</h1>
	</div>
	<div class="content">
		
		<?php 
		if($job->is_archived()) 
			echo FlashInfo::display(___('jobs.show.archived.info', array(
				':date' => date('Y-m-d', strtotime($job->date_availability)),
			)), FlashInfo::WARNING);
		?>
		
		<div id="job-details-box" class="entry_content_box">
			<h3><?php echo ___('jobs.show.details') ?>:</h3>
			<div class="job-box-contents">

				<div class="price_box">
					<span class="price-inner">
						<label><?php echo ___('jobs.show.price') ?>:</label>
						<span class="price">
							<?php if($job->price === NULL): ?>
							<?php echo ___('jobs.show.price.not_set') ?>
							<?php else: ?>
							<span itemprop="price"><?php echo payment::price_format($job->price, FALSE) ?></span>
							<span itemprop="currency"><?php echo payment::currency() ?></span>
							<?php endif ?>
						</span>
					</span>
					<div class="replies_count-side">
						<?php echo ___('jobs.show.count_replies') ?>:
						<?php echo (int)$job->count_replies ?>
					</div>
				</div>

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

		<div class="entry_content_box">
			<h3><?php echo ___('jobs.show.content') ?>:</h3>
			<div class="job-box-contents job-content" itemprop="description">
				<?php
					$content = $job->content;
					$content = Text::linkify($content);
					echo $content;
				?>
			</div>
		</div>

		<?php $attributes = $job->get_attributes(TRUE); if($attributes AND count($attributes)): ?>
		<div class="job_attributes entry_content_box">
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

		<?php if($job->has_user()): ?>
		<div id="job-contact-data-box" class="entry_content_box">
			<h3><?php echo ___('jobs.show.principal') ?>:</h3>
			<div class="job-box-contents" itemprop="seller" itemscope itemtype="http://schema.org/Person">
				
				<div class="contact-details">
					<div class="author" itemprop="name">
						<?php if($job->contact_data()->display_name()): ?>
						<?php echo HTML::chars($job->contact_data()->display_name()); ?>
						<?php else: ?>
						<?php echo HTML::chars($job->get_user()->user_name); ?>
						<?php endif; ?>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="address">
								<?php echo $job->contact_data()->address->render('single_line') ?>
							</div>

							<?php $contact_uri = Route::get('site_jobs/frontend/jobs/contact')->uri(array('id' => $job->pk())); ?>
							<a href="<?php echo URL::site($contact_uri) ?>" class="contact_btn btn btn-default show_dialog_btn" data-dialog-target="#dialog_contact"><?php echo ___('contact') ?></a>
							<div id="dialog_contact" class="dialog hidden box">
								<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
								<div class="dialog-contents">
									<?php echo Bform::factory('Frontend_Jobs_Contact', array(
										'job' => $job,
									))->action($contact_uri)->render() ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="contact-meta">

								<?php if(Jobs::config('show_email') AND $job->get_email_address()): ?>
								<div class="email">
									<span><?php echo ___('email') ?>:</span>
									<?php echo Jobs::curtain($job, 'email', ___('email.curtain')); ?>
								</div>
								<?php endif; ?>
								
								<?php if($job->contact_data()->phone): ?>
								<div class="phone">
									<span><?php echo ___('telephone') ?>:</span>
									<?php echo Jobs::curtain($job, 'telephone', ___('telephone.curtain')); ?>
								</div>
								<?php endif; ?>
								
							</div>
						</div>
					</div>
				
					<?php
					if($user = $job->get_user()):
					$other_jobs_count = Model_Job::factory()
						->filter_by_user($user)
						->filter_by_active()
						->where('id', '!=', $job->pk())
						->count_all();

					if($other_jobs_count OR ($job->has_company() AND $job->catalog_company->is_promoted())):
					?>
					<div class="user_other_entries">
						<ul>
							<?php if ($job->has_company() AND $job->catalog_company->is_promoted()): ?>
							<li class="company_link">
								<?php echo HTML::anchor(catalog::url($job->catalog_company), '<i class="glyphicon glyphicon-briefcase"></i> '.___('catalog.module_links.btn'), array(
									'target' => ($job->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</li>
							<?php endif; ?>
							<?php if($other_jobs_count): ?>
							<li><?php echo HTML::anchor(Route::get('site_jobs/frontend/jobs/show_by_user')->uri(array(
								'user_id' => $user->pk(),
							)), ___('template.user_jobs')) ?></li>
							<?php endif ?>
						</ul>
					</div>
					<?php endif; endif; ?>
				</div>

			</div>
		</div>
		<?php endif; ?>
		
		<div class="bottom">
			<?php if(!$job->is_archived()): ?>
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
				<li class="report">
					<a rel="nofollow" href="<?php echo Route::url('site_jobs/frontend/jobs/report', array(
						'id' => $job->pk(),
					)) ?>"><?php echo ___('report') ?></a>
				</li>
			</ul>
			<?php endif; ?>

			<div class="share-side">
				<span class="l"><?php echo ___('share') ?>:</span>
				<?php
				$share = new Share(
					URL::site(Jobs::uri($job), 'http'), 
					$job->title,
					Text::limit_chars(strip_tags($job->content), 100, '...')
				);
				
				$share->add_send_friend_form(
					$send_url = Route::url('site_jobs/frontend/jobs/send', array('id' => $job->pk())),
					Bform::factory(new Form_Frontend_Jobs_Send, array(
							'job' => $job,
						))->action($send_url)->render(),
					___('jobs.send.title')
				);

				echo $share->render();
				?>
			</div>
		</div>

		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>

		<?php echo Widget_Box::factory('jobs/replies')->set_job($job)->render(); ?>
		<?php echo Widget_Box::factory('jobs/comments')->set_job($job)->render(); ?>

	</div>

</div>