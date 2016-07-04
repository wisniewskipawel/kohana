<?php
$form->param('class', $form->param('class').' add_comment-form');
echo $form->render_form_open();
?>

<?php echo $form->title->render(TRUE) ?>
<?php echo $form->body->render(TRUE) ?>

<div class="author_fields">
	<?php echo $form->author->render(TRUE) ?>
	<?php echo $form->email->render(TRUE) ?>
</div>

<?php if($form->has('captcha')) echo $form->captcha->render(TRUE) ?>

<?php echo $form->form_id ?>

<?php echo $form->param('buttons_manager')->render() ?>

<?php echo $form->render_form_close() ?>