<div class="box primary">
	<h2><?php echo ___('jobs.profile.edit.title') ?></h2>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>

<?php if(isset($form_attributes)): ?>
<div class="box primary">
	<h2><?php echo ___('jobs.attributes') ?></h2>
	<div class="content">
		<?php echo $form_attributes ?>
	</div>
</div>
<?php endif; ?>
