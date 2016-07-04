<?php echo $form->render_form_open() ?>

	<?php echo $form->form_id->render() ?>
	<?php echo $form->content->render(TRUE) ?>

	<div class="group_prices">
		<?php echo $form->price->render(TRUE) ?>
		<?php echo $form->price_unit->render(TRUE) ?>
	</div>
	
	<?php echo $form->param('buttons_manager')->layout('bform/site/drivers_layouts/buttons')->render() ?>

<?php echo $form->render_form_close() ?>