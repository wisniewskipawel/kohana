<?php if ($auth->permissions('admin/newsletter/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/newsletter', ___('newsletter.title')); ?>
	<ul>
		<?php if ($auth->permissions('admin/newsletter/send')): ?>
			<li><?php echo HTML::anchor('/admin/newsletter/send', ___('newsletter.admin.send.menu')); ?></li>
		<?php endif ?>
		<?php if ($auth->permissions('admin/newsletter/subscribers/index')): ?>
			<li><?php echo HTML::anchor('/admin/newsletter/subscribers', ___('newsletter.admin.subscribers.title')); ?></li>
		<?php endif ?>
		<?php if ($auth->permissions('admin/newsletter/queue')): ?>
			<li><?php echo HTML::anchor('/admin/newsletter/queue', ___('newsletter.admin.queue.title')); ?></li>
		<?php endif ?>
		<?php if ($auth->permissions('admin/newsletter/settings')): ?>
			<li><?php echo HTML::anchor('/admin/newsletter/settings', ___('newsletter.admin.settings.title')); ?></li>
		<?php endif ?>
	</ul>
</li>
<?php endif ?>