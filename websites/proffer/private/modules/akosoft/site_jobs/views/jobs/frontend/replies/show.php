<?php if(!$job->is_archived()): ?>
<div class="job-box">
	<h3 class="box-header"><?php echo ___('jobs.replies.add.title') ?></h3>
	<div class="job-box-contents">
		<?php if($current_user): ?>
		<?php 
		echo $form_add_reply
			->action(Route::get('site_jobs/frontend/replies/add')->uri(array('job_id' => $job->pk())))
			->param('layout', 'jobs/frontend/replies/form');
		?>
		<?php else: ?>
		<?php echo View::factory('jobs/frontend/replies/logged_only'); ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<div class="job-box">
	<h3 class="box-header"><?php echo ___('jobs.replies.show.title') ?></h3>
	<div class="job-box-contents">
		<?php if(count($replies)): ?>
		<?php echo View::factory('jobs/frontend/replies/list')->set('replies', $replies) ?>
		<?php else: ?>
		<div class="no_results"><?php echo ___('jobs.replies.lists.no_results') ?></div>
		<?php endif; ?>
	</div>
</div>