<div id="profile_jobs_box" class="profile_box">
	<ul class="profile_nav">
		<li>
			<?php echo HTML::anchor(
				Route::get('site_jobs/profile/jobs/my')->uri(),
				___('jobs.profile.my.title')
			); ?>
		</li>
		<li>
			<?php echo ___('jobs.profile.stats.count_added', $count_jobs, array(
				':nb' => $count_jobs,
			)) ?>
		</li>
		<li>
			<?php echo ___('jobs.profile.stats.count_active', $count_active_jobs, array(
				':nb' => $count_active_jobs,
				':link' => ($count_active_jobs ?
					'('.HTML::anchor(
						Route::get('site_jobs/frontend/jobs/show_by_user')
							->uri(array('user_id' => $current_user->pk())), 
						___('jobs.profile.stats.count_active.btn')
					).')' : '')
			))	
			?>
		</li>
	</ul>
</div>

