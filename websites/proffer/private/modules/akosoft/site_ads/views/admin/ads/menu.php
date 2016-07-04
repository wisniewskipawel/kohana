<?php if ($auth->permissions('admin/ads/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/ads', ___('ads.admin.index.title')) ?>
	<ul>
		<li><?php echo HTML::anchor('/admin/ads/index/active', ___('ads.admin.index.active')) ?></li>
		<li><?php echo HTML::anchor('/admin/ads/index/not_active', ___('ads.admin.index.not_active')) ?></li>
		
		<?php if ($auth->permissions('admin/ads/add')): ?>
		<li><?php echo HTML::anchor('/admin/ads/add', ___('ads.admin.add.btn')) ?></li>
		<?php endif ?>
			
		<?php if ($auth->permissions('admin/ads/users')): ?>
		<li><?php echo HTML::anchor('/admin/ads/users', ___('ads.admin.users.title')) ?></li>
		<?php endif ?>
			
		<?php if ($auth->permissions('admin/ads/settings')): ?>
		<li><?php echo HTML::anchor('admin/ads/settings', ___('ads.admin.settings.title')) ?></li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/ads/settings_payment')): ?>
		<li>
			<?php echo HTML::anchor('#', ___('ads.admin.payment.title')) ?>
			<ul>
				<li>
					<?php echo HTML::anchor('/admin/ads/settings_payment', ___('ads.payment.link_text')) ?>
				</li>
			</ul>
		</li>
		<?php endif ?>
		
	</ul>
</li>
<?php endif ?>