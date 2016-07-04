<?php if ($auth->permissions('admin/language/index')): ?>
<li><?php echo HTML::anchor('admin/languages', ___('languages.admin.settings.title')) ?></li>
<?php endif ?>