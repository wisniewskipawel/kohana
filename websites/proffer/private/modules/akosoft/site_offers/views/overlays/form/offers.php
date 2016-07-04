<form action="<?php echo Route::url('site_notifier/notifier/offers', NULL, 'http') ?>" method="post" class="bform">
	
	<?php echo $form->email ?>

	<?php if($field = $form->get('province')): ?>
	<?php echo $field; ?>
	<?php endif ?>

	<div class="control-group categories-row">
		<label><?php echo $form->categories->html('label') ?> <span class="required">*</span></label>
		<div class="controls">
			<div class="html-before"><?php echo ___('overlay.categories.multiple') ?></div>
			<?php 
			$categories = ORM::factory('Offer_Category')->get_select(FALSE, TRUE, 5);
			echo Form::select('categories[]', $categories, NULL, array('multiple' => 'multiple'));
			?>
		</div>
	</div>

	<?php echo $form->notify ?>

	<div class="control-group">
		<label>&nbsp;</label>
		<div class="controls">
			<?php echo Form::submit(NULL, ___('form.save')) ?>
		</div>
	</div>
	
	<?php echo $form->form_id ?>

</form>