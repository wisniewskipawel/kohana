<?php if ( ! ($driver instanceof Bform_Driver_Input_hidden) AND !$driver->html('no_decorate')): ?>
	<div id="<?php echo $driver->html('row_id') ?>" class="control-group input <?php echo $driver->html('row_class') ?><?php if($driver->data('has_error')) echo ' error' ?>">
		<label <?php if ($driver->html('id')): ?>for="<?php echo $driver->html('id') ?>"<?php endif; ?>>
			<?php if(!($driver instanceof Bform_Driver_Input_Checkbox)): ?>
			<?php echo $driver->html('label') ?> <?php echo $driver->data('required') ? '<span class="required">*</span>' : ''; ?>
			
			<?php if($label_help = $driver->html('label_help')): ?>
			<div class="label-help"><?php echo $label_help ?></div>
			<?php endif; ?>
			
			<?php endif; ?>
		</label>
		<div class="controls">
			<?php if ($driver->html('html_before')): ?>
				<div class="<?php echo Kohana::$config->load('bform.css.drivers.html_before_class') ?>"><?php echo $driver->html('html_before') ?></div>
			<?php endif ?>
<?php endif ?>
			
		<?php if($driver instanceof Bform_Driver_Input_Checkbox AND !$driver->html('no_decorate')): ?>
			<label>
				<?php echo $driver->render(FALSE); ?> <?php echo $driver->data('required') ? '<span class="required">*</span>' : ''; ?> <?php echo $driver->html('label') ?>
			</label>
		<?php else: ?>
		<?php echo $driver->render(FALSE); ?>
		<?php endif; ?>

<?php if ( ! ($driver instanceof Bform_Driver_Input_hidden) AND !$driver->html('no_decorate')): ?>
			<?php if ($driver->html('html_after')): ?>
				<div class="<?php echo Kohana::$config->load('bform.css.drivers.html_after_class') ?>"><?php echo $driver->html('html_after') ?></div>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>