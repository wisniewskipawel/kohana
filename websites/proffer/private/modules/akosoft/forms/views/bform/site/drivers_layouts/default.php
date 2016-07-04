<?php if ($e->html('html_before')): ?>
	<span class="<?php echo Kohana::$config->load('bform.css.drivers.html_before_class') ?>"><?php echo $e->html('html_before') ?></span><br/>
<?php endif ?>

<span><?php echo $e->render() ?></span>

<?php if ($e->html('html_after')): ?>
	<p class="<?php echo Kohana::$config->load('bform.css.drivers.html_after_class') ?>"><?php echo $e->html('html_after') ?></p>
<?php endif ?>

<?php if ($e->data('has_error') === TRUE): ?>
	<span class="error"><?php echo $e->html('error_messages') ?></span>
<?php endif ?>
