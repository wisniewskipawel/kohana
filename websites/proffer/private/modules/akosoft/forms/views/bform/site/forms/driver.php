<?php if ( ! ($driver instanceof Bform_Driver_Input_hidden) AND !$driver->html('no_decorate')): ?>
	<div id="<?php echo $driver->html('row_id') ?>" class="control-group input <?php echo $driver->html('row_class') ?>">
		<label <?php if ($driver->html('id')): ?>for="<?php echo $driver->html('id') ?>"<?php endif; ?>>
			<?php if(!($driver instanceof Bform_Driver_Input_Checkbox)): ?>
			<?php echo $driver->html('label') ?> <?php echo $driver->data('required') ? '<span class="required">*</span>' : ''; ?>
			<?php endif; ?>
		</label>
		<div class="controls">
			<?php if ($driver->html('html_before')): ?>
				<div class="<?php echo Kohana::$config->load('bform.css.drivers.html_before_class') ?>"><?php echo $driver->html('html_before') ?></div>
			<?php endif ?>
<?php endif ?>
			
		<?php if($driver instanceof Bform_Driver_Input_Checkbox AND !$driver->html('no_decorate')): ?>
			<label <?php if ($driver->html('id')): ?>for="<?php echo $driver->html('id') ?>"<?php endif; ?>>
				<?php echo $driver->render(); ?> <?php echo $driver->data('required') ? '<span class="required">*</span>' : ''; ?> <?php echo $driver->html('label') ?>
			</label>
		<?php else: ?>
		<?php echo $driver->render(); ?>
		<?php endif; ?>

<?php if ( ! ($driver instanceof Bform_Driver_Input_hidden) AND !$driver->html('no_decorate')): ?>
			<?php if ($driver->html('html_after')): ?>
				<div class="<?php echo Kohana::$config->load('bform.css.drivers.html_after_class') ?>"><?php echo $driver->html('html_after') ?></div>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>