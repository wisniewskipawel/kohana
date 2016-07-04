<?php
$context = isset($context) ? $context : NULL;
if(empty($no_ads) AND Modules::enabled('site_ads')) $ad = ads::show(ads::PLACE_F);
?>
<?php if (count($jobs)): ?>
<?php $i = 1; ?>
<ul class="jobs_list <?php if($context == 'my' OR $context == 'closet') echo 'actions_list'; ?>">
	<?php 
	foreach ($jobs as $job): 
		$job_link = URL::site(Jobs::uri($job));
	?>
	<li class="<?php if ($job->is_promoted()) echo 'promoted'; ?>">

		<?php if($context == 'my'): ?>
		<div class="entry_actions">
			<div class="pull-left">
				<?php 
				$days_left = $job->get_availability_days_left();

				echo $days_left > 0 ? ___('jobs.profile.my.list.days_left', $days_left, array(
					':days_left' => $days_left,
				)) : ___('jobs.profile.my.list.inactive') ?>
			</div>

			<ul class="actions pull-right">
				<li><a href="<?php echo Route::url('site_jobs/profile/jobs/edit', array('id' => $job->pk())) ?>"><?php echo ___('edit') ?></a></li>
				<?php if ($job->can_renew()): ?>
				<li><a href="<?php echo Route::url('site_jobs/profile/jobs/renew', array('id' => $job->pk())) ?>"><?php echo ___('prolong') ?></a></li>
				<?php endif; ?>
				<?php if(Jobs::distinctions()): ?>
				<li><a href="<?php echo Route::url('site_jobs/profile/jobs/promote', array('id' => $job->pk())) ?>"><?php echo ___('promote') ?></a></li>
				<?php endif; ?>
				<li><a href="<?php echo Route::url('site_jobs/profile/jobs/delete', array('id' => $job->pk())) ?>"><?php echo ___('delete') ?></a></li>
				<li class="last"><a href="<?php echo Route::url('site_jobs/profile/jobs/statistics', array('id' => $job->pk())) ?>"><?php echo ___('statistics') ?></a></li>
			</ul>
		</div>
		<?php elseif($context == 'closet'): ?>
		<div class="entry_actions">
			<ul class="actions">
				<li><a href="<?php echo Route::url('site_jobs/frontend/jobs/send', array('id' => $job->pk())) ?>"><?php echo ___('share_friend') ?></a></li>
				<li><a href="<?php echo Route::url('site_jobs/profile/closet/delete', array('id' => $job->pk())) ?>"><?php echo ___('delete') ?></a></li>
			</ul>
		</div>
		<?php endif; ?>

		<div class="job-entry">

			<div class="job-info">
				<h3>
					<a href="<?php echo $job_link ?>" tite="<?php echo HTML::chars($job->title) ?>">
						<?php echo HTML::chars($job->title) ?>
					</a>
				</h3>
				
				<div class="job-entry-bottom">
					<?php if($job->has_category()): ?>
					<dl class="category">
						<dt><?php echo ___('category') ?>:</dt> 
						<dd>
							<a href="<?php echo Route::url('site_jobs/frontend/jobs/category', array('category_id' => $job->last_category->pk(), 'title' => URL::title($job->last_category->category_name))) ?>"><?php echo $job->last_category->category_name ?></a>
						</dd>
					</dl>
					<?php endif; ?>
					
					<dl class="date_added">
						<dt><?php echo ___('date_added') ?>:</dt>
						<dd><?php echo Date::my($job->date_added, 'job') ?></dd>
					</dl>
				</div>
			</div>

			<div class="job-details">
				
				<?php if($job->price): ?>
				<dl class="price_box">
					<dt><?php echo ___('jobs.show.price') ?>:</dt>
					<dd class="price">
						<span itemprop="price"><?php echo payment::price_format($job->price, FALSE) ?></span>
						<span itemprop="currency"><?php echo payment::currency() ?></span>
					</dd>
				</dl>
				<?php endif; ?>

				<dl class="count_replies">
					<dt><?php echo ___('jobs.show.count_replies') ?>:</dt>
					<dd><?php echo (int)$job->count_replies ?></dd>
				</dl>
				
			</div>

			
		</div>
		
		

	</li>
	<?php if ($i == (round(count($jobs) / 2, 0)) AND ! empty($ad)): ?>
		<li class="banner">
			<?php echo $ad; ?>
		</li>
	<?php endif; ?>
	<?php $i++ ?>
	<?php endforeach ?>
</ul>
<?php else: ?>
<div class="no_results">
	<?php echo ___('jobs.list.no_results') ?>
</div>
<?php endif ?>