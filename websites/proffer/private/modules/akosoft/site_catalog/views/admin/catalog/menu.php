<?php if ($auth->permissions('admin/catalog/companies/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/catalog', ___('catalog.title')); ?>
	<ul>
		<?php if($auth->permissions('admin/catalog/categories')): ?>
		<li>
			<?php echo HTML::anchor('/admin/catalog/categories', ___('catalog.admin.categories.title')); ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/catalog/categories/index', ___('catalog.admin.categories.browse')); ?></li>
				<?php if ($auth->permissions('admin/catalog/categories/add')): ?>
					<li><?php echo HTML::anchor('/admin/catalog/categories/add', ___('catalog.admin.categories.add.btn')); ?></li>
				<?php endif ?>
			</ul>
		</li>
		<?php endif ?>
		
		<li>
			<?php echo HTML::anchor('/admin/catalog/companies', ___('catalog.admin.companies.title')); ?>
			<ul>
				<li><?php echo HTML::anchor('/admin/catalog/companies/index', ___('catalog.admin.companies.browse')); ?></li>
				<?php if ($auth->permissions('admin/catalog/companies/add')): ?>
					<li><?php echo HTML::anchor('/admin/catalog/companies/add', ___('catalog.admin.companies.add.btn')); ?></li>
				<?php endif ?>
			</ul>
		</li>
		
		<?php if($auth->permissions('admin/catalog/reviews')): ?>
		<li>
			<?php echo HTML::anchor('/admin/catalog/reviews', ___('catalog.admin.reviews.title')); ?>
		</li>
		<?php endif ?>
		
		<?php if ($auth->permissions("admin/catalog/settings")): ?>
		<li><?php echo HTML::anchor('/admin/catalog/settings', ___('catalog.admin.settings.title')); ?></li>
		<?php endif ?>
		
		<?php if ($auth->permissions("admin/catalog/settings_payment")): ?>
		<li>
			<?php echo HTML::anchor('#', ___('catalog.admin.payments.title')) ?>
			<ul>
				<li><?php echo HTML::anchor('admin/catalog/settings_payment?type=company_add', ___('catalog.payments.company_add.title')) ?></li>
				<li><?php echo HTML::anchor('admin/catalog/settings_payment?type=company_promote', ___('catalog.payments.company_promote.title')) ?></li>
			</ul>
		</li>
		<?php endif ?>
		
	</ul>
</li>
<?php endif ?>