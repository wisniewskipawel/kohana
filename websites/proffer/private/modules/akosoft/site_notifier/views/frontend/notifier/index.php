<?php 
$document = Pages::get('notifier');
?>
<form action="" method="post" class="bform notifier_form">
	<?php echo $form->form_id->render() ?>
	
	<div class="box primary">
		<h2><?php echo $document->document_title ?></h2>
		<div class="content">
			
			<div>
				<?php echo $document->document_content ?>
			</div>
			
			<?php if ($form->param('errors')): ?>
				<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
					<?php foreach ($form->param('errors') as $ar): ?>
						<li><b><?php echo $ar['label'] ?>:</b> <?php echo $ar['message'] ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			
			<fieldset>
				<?php $field = 'email'; if ($form->has($field)): $field = $form->{$field}; ?>
				<div class="control-group">
					<label><?php echo $field->html('label') ?>
						<?php if($field->data('required')): ?>
						<span class="required">*</span>
						<?php endif; ?>
					</label>
					<?php echo $field->render() ?>
				</div>
				<?php endif ?>
				
				<?php $field = 'province'; if ($form->has($field)): $field = $form->{$field}; ?>
				<div class="control-group">
					<label><?php echo $field->html('label') ?>
						<?php if($field->data('required')): ?>
						<span class="required">*</span>
						<?php endif; ?>
					</label>
					<?php echo $field->render() ?>
				</div>
				<?php endif ?>
			</fieldset>
			
		</div>
	</div>
	
	<?php $field = 'categories'; if ($form->has($field)): $field = $form->{$field}; ?>
	<div class="box primary categories">
		<h2><?php echo $field->html('label') ?> <span class="right"><a href="#" id="check-all"><?php echo ___('notifiers.check_all') ?></a></span></h2>
		<div class="content">
			<?php echo $field->render() ?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="box primary">
		<h2></h2>
		<div class="content">
			<fieldset class="form-actions">
				
				<?php $field = 'notify'; if ($form->has($field)): $field = $form->{$field}; ?>
				<div class="control-group">
					<label class="inline"><?php echo $field->render() ?> <?php echo $field->html('label') ?>
						<?php if($field->data('required')): ?>
						<span class="required">*</span>
						<?php endif; ?>
					</label>
				</div>
				<?php endif ?>
				
				<?php echo Form::submit(NULL, ___('form.save')) ?>
			</fieldset>
		</div>
	</div>
	
</form>

<div class="clearfix"></div>

<script>

	$(document).ready(function() {
		jQuery("div.box.categories > h2 a#check-all").click(function() {

			var $a = jQuery(this);

			jQuery("div.box.categories div.category input[type=checkbox]").attr('checked', 'checked');

			return false;
		});
	});

</script>
