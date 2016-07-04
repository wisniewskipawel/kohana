<ul class="job_comments_list">
	<?php foreach($comments as $comment):  ?>
	<li>
		<div id="comment<?php echo $comment->pk() ?>" class="comment">
			
			<div class="user-avatar">
				<?php if($comment->has_user() AND $avatar = $comment->get_user()->get_avatar()): ?>
				<?php echo HTML::image($avatar) ?>
				<?php else: ?>
				<?php echo HTML::image('media/jobs/img/no-avatar.png') ?>
				<?php endif; ?>
			</div>
			
			<div class="comment-contents">
				<div class="comment-header">
					<span class="author">
						<span><?php echo HTML::chars($comment->user->user_name) ?></span>
					</span>

					<div class="date_added">
						<label><?php echo ___('date_added') ?>:</label>
						<span><?php echo $comment->date_added ?></span>
					</div>
				</div>
				<div class="comment-body">
					<?php echo HTML::chars($comment->body) ?>
				</div>
				<div class="comment-footer">
					<?php echo HTML::anchor(
						Route::get('site_jobs/frontend/comments/add')->uri(array(
							'job_id' => $job->pk(),
							'parent_comment_id' => $comment->pk(),
						)), ___('jobs.comments.add_reply'), array('class' => 'add_reply'));
					?>
				</div>
			</div>
		</div>
		
		<?php if(count($comment->subcomments)): ?>
		<div class="subcomments">
			<?php echo View::factory('jobs/frontend/comments/partials/list_standard')
					->set('comments', $comment->subcomments)
					->set('job', $job);
			?>
		</div>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>