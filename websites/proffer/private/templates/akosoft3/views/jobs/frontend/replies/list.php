<?php 
$context = isset($context) ? $context : 'list'; 
?>
<ul class="job_replies_list">
	<?php foreach($replies as $reply): ?>
	<li>
		<?php if($context == 'my'): ?>
		<div class="entry_actions">
			<ul class="actions pull-right">
				<li><a href="<?php echo URL::site(Jobs::uri($reply->job)) ?>"><?php echo ___('jobs.profile.replies.my.show_job_btn') ?></a></li>
				<li><a href="<?php echo Route::url('site_jobs/profile/replies/edit', array('id' => $reply->pk())) ?>"><?php echo ___('edit') ?></a></li>
				<li><a href="<?php echo Route::url('site_jobs/profile/replies/delete', array('id' => $reply->pk())) ?>"><?php echo ___('delete') ?></a></li>
			</ul>
		</div>
		<?php endif; ?>
		
		<div class="job-reply-entry">
			<div class="reply-left">
				<div class="reply-user-avatar">
					<?php if($reply->has_user() AND $avatar = $reply->get_user()->get_avatar()): ?>
					<?php echo HTML::image($avatar) ?>
					<?php else: ?>
					<?php echo HTML::image('media/jobs/img/no-avatar.png') ?>
					<?php endif; ?>
				</div>

				<div class="reply-user-name">
					<?php echo HTML::chars($reply->get_user()->user_name) ?>
				</div>
			</div>

			<div class="reply-body">
				<div class="reply-content">
					<?php echo Text::auto_p(HTML::chars($reply->content)); ?>
				</div>

				<div class="reply-bottom">
					<?php if($auth->is_logged() OR Jobs::config('replies.show_contact_not_logged')): ?>
					<div class="reply-user-contact">

						<?php if($reply->get_email_address()): ?>
						<div class="reply-user-email">
							<?php echo Jobs::curtain_reply($reply, 'email', ___('email.curtain')) ?>
						</div>
						<?php endif; ?>

						<?php if($reply->get_user()->contact_data()->phone): ?>
						<div class="reply-user-phone">
							<?php echo Jobs::curtain_reply($reply, 'telephone', ___('telephone.curtain')) ?>
						</div>
						<?php endif; ?>

						<?php if($reply->get_user()->data->users_data_www): ?>
						<div class="reply-user-www">
							<?php echo HTML::anchor(Tools::link($reply->get_user()->data->users_data_www), ___('www'), array(
								'rel' => 'nofollow',
								'target' => '_blank',
							)) ?>
						</div>
						<?php endif; ?>

						<div class="reply-price-side">
							<?php echo ___('jobs.replies.lists.price') ?>
							<?php if($reply->price): ?>
							<div class="reply-price">
								<?php echo payment::price_format($reply->price) ?>
							</div>
							<div class="reply-price_unit">
								<?php echo ___('jobs.replies.lists.price_unit.'.$reply->price_unit) ?>
							</div>
							<?php else: ?>
							<div class="reply-no-price">
								<?php echo ___('jobs.replies.lists.no_price') ?>
							</div>
							<?php endif; ?>
						</div>

					</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>