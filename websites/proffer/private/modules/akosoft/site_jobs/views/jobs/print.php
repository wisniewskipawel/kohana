<?php
Media::css('jobs.print.css', 'jobs/css');
?>
<div class="box primary entry_show_box">
	<div class="content">

		<div class="job entry_body" itemscope itemtype="http://data-vocabulary.org/Offer">

			<h1 itemprop="name"><?php echo HTML::chars($job->title) ?></h1>

			<div class="content">
				
				<div class="job-info-side">
					<div class="job-info">
						<div class="job-box">
							<h3><?php echo ___('jobs.show.details') ?>:</h3>
							<div class="job-box-contents">
						
								<dl class="price_box">
									<dt><?php echo ___('jobs.show.price') ?>:</dt>
									<dd class="price">
										<span itemprop="price"><?php echo payment::price_format($job->price, FALSE) ?></span>
										<span itemprop="currency"><?php echo payment::currency() ?></span>
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

								<?php if($job->date_realization_limit): ?>
								<dl class="date_realization_limit">
									<dt><?php echo ___('jobs.show.date_realization_limit') ?>:</dt>
									<dd><?php echo date('Y.m.d', strtotime($job->date_realization_limit)) ?></dd>
								</dl>
								<?php endif; ?>
								
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
								</address>
								
								<?php if($job->contact_data()->phone): ?>
								<div class="phone">
									<?php echo $job->contact_data()->phone; ?>
								</div>
								<?php endif; ?>
								
								<?php if(Jobs::config('show_email') AND $job->get_email_address()): ?>
								<div class="email">
									<?php echo $job->get_email_address(); ?>
								</div>
								<?php endif; ?>
								
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

			</div>

		</div>

	</div>

</div>
