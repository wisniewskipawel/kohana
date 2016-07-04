<?php if ($auth->permissions('admin/documents/index')): ?>
<li>
	<?php echo HTML::anchor('/admin/documents', ___('documents.title')) ?>
	<ul>
		<li><?php echo HTML::anchor('/admin/documents/index', ___('documents.browse')) ?></li>
		<?php if ($auth->permissions('admin/documents/add')): ?>
			<li><?php echo HTML::anchor('/admin/documents/add', ___('documents.add.btn')) ?></li>
		<?php endif ?>
		<?php if ($auth->permissions('admin/documents/placements/index')): ?>
			<li><?php echo HTML::anchor('/admin/documents/placements/index', ___('documents.placements.index.title')) ?></li>
		<?php endif ?>
	</ul>
</li>
<?php endif ?>