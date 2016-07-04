<li>
	<?php echo HTML::anchor('admin/settings', ___('settings.title')) ?>
	<ul>
		<li><?php echo HTML::anchor('/admin/settings/change_password', ___('settings.change_password.menu')) ?></li>

		<?php if ($auth->permissions('admin/settings/site')): ?>
		<li><?php echo HTML::anchor('/admin/settings/site', ___('settings.site.title')) ?></li>
		<li><?php echo HTML::anchor('/admin/settings/appearance', ___('settings.appearance.title')) ?></li>
		<li><?php echo HTML::anchor('/admin/settings/security', ___('settings.security.title')) ?></li>
		<li><?php echo HTML::anchor('/admin/settings/agreements', ___('settings.agreements.title')) ?></li>
		<?php endif ?>

		<?php if ($auth->permissions('admin/modules')): ?>
		<li><?php echo HTML::anchor('/admin/modules', ___('settings.modules.title')) ?></li>
		<?php endif ?>

		<?php if ($auth->permissions('admin/payment/settings')): ?>
		<li><?php echo HTML::anchor('/admin/payment/settings', ___('payments.admin.settings.title')) ?></li>
		<?php endif ?>
		
		<?php echo Events::fire('admin/menu/settings') ?>
	</ul>
</li>