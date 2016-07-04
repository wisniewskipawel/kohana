<?php if ($auth->permissions('admin/news/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/news', ___('news.title')) ?>
	
	<ul>
		<li><?php echo HTML::anchor('/admin/news/index', ___('news.admin.browse')) ?></li>
		<?php if ($auth->permissions('admin/news/add')): ?>
			<li><?php echo HTML::anchor('/admin/news/add', ___('news.admin.add.btn')) ?></li>
		<?php endif ?>
		<?php if ($auth->permissions('admin/news/settings')): ?>
			<li><?php echo HTML::anchor('/admin/news/settings', ___('news.admin.settings.title')) ?></li>
		<?php endif ?>
	</ul>
</li>
<?php endif ?>