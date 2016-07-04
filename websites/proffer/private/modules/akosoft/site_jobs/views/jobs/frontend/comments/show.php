<div class="job-box">
	<h3 class="box-header"><?php echo ___('jobs.comments.show.title') ?></h3>
	<div class="job-box-contents">
		
		<div class="comments <?php if(!$count_comments) echo 'no_comments' ?>">

			<?php if($current_user): ?>
			<?php echo $form_add_comment->action(Route::get('site_jobs/frontend/comments/add')->uri(array('job_id' => $job->pk()))) ?>
			<?php else: ?>
			<?php echo View::factory('jobs/frontend/comments/logged_only'); ?>
			<?php endif; ?>

			<?php if($count_comments): ?>

			<?php echo View::factory('jobs/frontend/comments/partials/list_standard')
				->set('comments', $comments)
				->set('job', $job);
			?>

			<?php endif; ?>

		</div>

	</div>
</div>
