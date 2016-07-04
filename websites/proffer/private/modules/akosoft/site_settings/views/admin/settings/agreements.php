<h2><?php echo ___('settings.agreements.title') ?></h2>

<div class="box">
    <?php if ($auth->permissions('admin/settings/site')): ?>
        <?php echo $form; ?>
    <?php endif ?>
</div>