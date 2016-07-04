<fieldset<?php echo $e->html('row_class') ? 'class="'.$e->html('row_class').'" ' : '' ?> <?php echo $e->html('row_id') ? 'id="' . $e->html('row_id') . '"' : '' ?>>
    <legend class="<?php echo $e->html('class') ?> form-group"><?php echo $e->html('label') ?></legend>

    <?php if ($e->html('html_before')): ?>
        <span class="<?php echo Kohana::$config->load('bform.css.drivers.html_before_class') ?>"><?php echo $e->html('html_before') ?></span><br/>
    <?php endif ?>

    <?php echo $e->render() ?>

    <?php if ($e->html('html_after')): ?>
        <br/><span class="<?php echo Kohana::$config->load('bform.css.drivers.html_after_class') ?>"><?php echo $e->html('html_after') ?></span>
    <?php endif ?>

    <?php if ($e->data('has_error') === TRUE): ?>
        <br/><label class="<?php echo Kohana::$config->load('bform.css.errors.label_class') ?>"><?php echo $e->html('error_messages') ?></label>
    <?php endif ?>

</fieldset>
