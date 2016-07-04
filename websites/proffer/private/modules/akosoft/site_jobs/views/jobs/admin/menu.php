<?php if ($auth->permissions('admin/jobs/index')): ?>
<li>
	<?php echo HTML::anchor("/admin/jobs", ___('jobs.module.name')) ?>
	<ul>
		<?php if ($auth->permissions('admin/jobs/add')): ?>
		<li><?php echo HTML::anchor('/admin/jobs/add', ___('jobs.admin.menu.add')) ?></li>
		<?php endif ?>
		
		<li><?php echo HTML::anchor('/admin/jobs/index', ___('jobs.admin.menu.index')) ?></li>
		
		<?php if($auth->permissions('admin/jobs/comments') AND Jobs::config('comments.enabled')): ?>
		<li>
			<?php echo HTML::anchor('/admin/job/comments', ___('jobs.admin.comments.title')) ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/job/comments/index', ___('jobs.admin.comments.menu.index')) ?></li>
			</ul>
		</li>
		<?php endif; ?>
		
		<?php if($auth->permissions('admin/jobs/replies')): ?>
		<li>
			<?php echo HTML::anchor('/admin/job/replies', ___('jobs.admin.replies.title')) ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/job/replies/index', ___('jobs.admin.menu.replies.index')) ?></li>
			</ul>
		</li>
		<?php endif; ?>

		<?php if ($auth->permissions('admin/job/categories/index')): ?>
		<li>
			<?php echo HTML::anchor('/admin/job/categories', ___('jobs.admin.categories.title')) ?>
			<ul>
				<li>
					<?php echo HTML::anchor('/admin/job/categories/index', ___('jobs.admin.menu.categories.index')) ?>
				</li>
				<?php if ($auth->permissions('admin/job/categories/add')): ?>
					<li><?php echo HTML::anchor('/admin/job/categories/add', ___('jobs.admin.menu.categories.add')) ?></li>
				<?php endif ?>
			</ul>
		</li>
		<?php endif ?>

		<?php if ($auth->permissions('admin/job/fields/index')): ?>
		<li>
			<?php echo HTML::anchor('/admin/job/fields', ___('jobs.admin.fields.title')) ?>
			<ul>
				<li>
					<?php echo HTML::anchor('/admin/job/fields/index', ___('jobs.admin.menu.fields.index')) ?>
				</li>
				<li>
					<?php echo HTML::anchor('/admin/job/fields/add', ___('jobs.admin.menu.fields.add')) ?>
				</li>
			</ul>
		</li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/job/availabilities/index')): ?>
		<li><?php echo HTML::anchor('/admin/job/availabilities', ___('jobs.admin.availabilities.title')) ?></li>
		<?php endif ?>

		<?php if ($auth->permissions('admin/job/settings/index')): ?>
		<li><?php echo HTML::anchor('/admin/job/settings', ___('jobs.admin.settings.title')) ?></li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/job/settings/payments')): ?>
		<li>
			<?php echo HTML::anchor('#', ___('jobs.admin.payments.title')) ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/job/settings/payments?form=job_add', ___('site_jobs.payments.job_add.title')); ?></li>
				<li><?php echo HTML::anchor('/admin/job/settings/payments?form=job_promote_premium_plus', ___('jobs.promotion.premium_plus')); ?></li>
				<li><?php echo HTML::anchor('/admin/job/settings/payments?form=job_promote_premium', ___('jobs.promotion.premium')); ?></li>
			</ul>
		</li>
		<?php endif ?>

	</ul>
</li>
<?php endif ?>