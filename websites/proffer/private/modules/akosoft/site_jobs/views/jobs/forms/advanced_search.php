<?php echo $form->param('class', 'form_add_job bform')->render_form_open() ?>

	<?php if ($form->param('errors')): ?>
		<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
			<?php foreach ($form->param('errors') as $ar): ?>
				<li><b><?php echo $ar['label'] ?>:</b> <?php echo $ar['message'] ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	
	<?php echo $form->form_id->render() ?>
	
	<div class="row">
		<?php if($form->has('phrase')) echo $form->phrase->render(TRUE) ?>
		<?php if($form->has('where')) echo $form->where->render(TRUE) ?>
	</div>
	
	<div id ="job-categories" class="row">
		<?php if($form->has('category_id')) echo $form->category_id->render(TRUE) ?>
	</div>
	
	<div class="row">
		<?php if($field = $form->get('province')) echo $field->render(TRUE) ?>
		<?php if($field = $form->get('county')) echo $field->render(TRUE) ?>
		<?php if($field = $form->get('city')) echo $field->render(TRUE) ?>
	</div>

	<fieldset id="attributes_fields" class="border"<?php if(!$form->has('attributes')) echo 'style="display: none;"' ?>>
		<legend><?php echo ___('jobs.attributes') ?></legend>
		<?php echo $form->render_partial(NULL, 'jobs/forms/partials/attributes'); ?>
	</fieldset>

	<?php echo $form->param('buttons_manager')->render() ?>
</form>