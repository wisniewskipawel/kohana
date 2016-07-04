<?php echo ___('email') ?>: <?php echo Arr::get($form_values, 'email'); ?><br/>
<?php echo ___('message') ?>:<br/>
<?php echo Text::auto_p(Security::clean_text(Arr::get($form_values, 'message'))); ?><br/>
