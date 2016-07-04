<?php if ($auth->permissions('admin/emails/menu')): ?>
<li>
	<?php echo HTML::anchor('/admin/emails', ___('emails.title')) ?>
</li>
<?php endif ?>