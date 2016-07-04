<?php if ($auth->permissions('admin/payment/settings')): ?>
<li><?php echo HTML::anchor('/admin/payment', ___('payments.admin.index.title')) ?></li>
<?php endif ?>