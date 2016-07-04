<?php if($auth->permissions('admin/users/menu')): ?>
<li>
	<?php if($auth->permissions('admin/users/index')): ?>
	<?php echo HTML::anchor('/admin/users', ___('users.title')) ?>
	<?php endif ?>
	
	<ul>
		<?php if($auth->permissions('admin/users/index')): ?>
		<li><?php echo HTML::anchor('/admin/users/index', ___('users.admin.menu.browse')) ?></li>
		<?php endif ?>
		
		<?php if($auth->permissions('admin/users/add')): ?>
		<li><?php echo HTML::anchor('/admin/users/add', ___('users.admin.menu.add')) ?></li>
		<?php endif ?>
		
		<?php if($auth->permissions('admin/admins')): ?>
		<li>
			<?php echo HTML::anchor('admin/admins', ___('users.admin.admins.title')) ?>
			
			<ul>
				<?php if($auth->permissions('admin/admins/index')): ?>
				<li><?php echo HTML::anchor('/admin/admins/index', ___('users.admin.admins.index.menu')) ?></li>
				<?php endif ?>
				
				<?php if($auth->permissions('admin/admins/add')): ?>
				<li><?php echo HTML::anchor('/admin/admins/add', ___('users.admin.admins.add.menu')) ?></li>
				<?php endif ?>
			</ul>
		</li>
		<?php endif ?>
		
		<?php if($auth->permissions('admin/groups')): ?>
		<li>
			<?php echo HTML::anchor('admin/groups', ___('users.admin.groups.title')) ?>
			
			<ul>
				<?php if($auth->permissions('admin/groups/index')): ?>
				<li><?php echo HTML::anchor('/admin/groups/index', ___('users.admin.groups.index.menu')) ?></li>
				<?php endif ?>
				
				<?php if($auth->permissions('admin/groups/add')): ?>
				<li><?php echo HTML::anchor('/admin/groups/add', ___('users.admin.groups.add.menu')) ?></li>
				<?php endif ?>
			</ul>
		</li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/email/blacklist')): ?>
		<li>
			<?php echo HTML::anchor('/admin/email/blacklist', ___('users.admin.menu.blacklist')) ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/email/blacklist/index', ___('users.admin.menu.blacklist.index')) ?></li>
				<li><?php echo HTML::anchor('/admin/email/blacklist/add', ___('users.admin.menu.blacklist.add')) ?></li>
			</ul>
		</li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/users/settings')): ?>
		<li><?php echo HTML::anchor('/admin/users/settings', ___('users.admin.menu.settings')) ?></li>
		<?php endif ?>
		
		<?php if ($auth->permissions('admin/users/settings_payment')): ?>
		<li>
			<?php echo HTML::anchor('/admin/users/settings_payment', ___('users.admin.payments.title')) ?>
			<ul>
				<li>
					<?php echo HTML::anchor('/admin/users/settings_payment?type=register', ___('bauth.payments.user.title')) ?>
				</li>
			</ul>
		</li>
		<?php endif ?>
		
	</ul>
</li>
<?php endif ?>