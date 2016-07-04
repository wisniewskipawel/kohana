<form action="<?php echo $form->action() ?>" method="<?php echo $form->method() ?>" id="<?php echo $form->param('id') ?>" class="<?php echo $form->param('class') ?> forum_form_add_post" name="<?php echo $form->param('name') ?>">

	<?php echo $form->form_id ?>
	
	<?php if ($form->param('errors')): ?>
	<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
		<?php foreach ($form->param('errors') as $ar): ?>
			<li><b><?php echo $ar['label'] ?>:</b> <?php echo $ar['message'] ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	
	<div class="row">

		<div class="fields col-sm-8">

			<?php if($field = $form->get('title')): ?>
			<?php echo $field->html('row_class', 'full') ?>
			<?php endif; ?>

			<?php if($field = $form->get('body')): ?>
			<?php echo $field->html('row_class', 'full') ?>
			<?php endif; ?>

		</div>

		<div class="info col-sm-4">
			<?php if($current_user): ?>
			<div class="user_info">
				<div class="avatar">
					<?php if($avatar = $current_user->get_avatar()): ?>
					<?php echo HTML::image($avatar) ?>
					<?php else: ?>
					<?php echo HTML::image('media/forum/img/no-avatar.png') ?>
					<?php endif; ?>
				</div>
				<div class="user_name"><?php echo HTML::chars($current_user->user_name) ?></div>
			</div>
			<?php else: ?>

			<?php if($field = $form->get('author')): ?>
			<?php echo $field->html('row_class', 'full') ?>
			<?php endif; ?>

			<?php if($field = $form->get('email')): ?>
			<?php echo $field->html('row_class', 'full') ?>
			<?php endif; ?>

			<?php if($field = $form->get('captcha')): ?>
			<?php echo $field->html('row_class', 'full') ?>
			<?php endif; ?>

			<?php endif; ?>

			<p>
				<?php echo ForumUtils::config('add_post_info') ?>
			</p>
		</div>
		
	</div>
	
	<?php echo $form->param('buttons_manager')->layout('bform/site/drivers_layouts/buttons')->render() ?>

</form>

