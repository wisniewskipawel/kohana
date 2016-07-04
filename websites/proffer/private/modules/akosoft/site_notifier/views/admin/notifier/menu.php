<?php if ($auth->permissions('admin/notifier/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/notifier', ___('notifiers.title')) ?>
	<ul>
		<li><?php echo HTML::anchor('/admin/notifier/index', ___('notifiers.admin.index.title')) ?></li>
		<li><?php echo HTML::anchor('/admin/notifier/settings', ___('notifiers.admin.settings.title')) ?></li>
	</ul>
</li>
<?php endif ?>
