<h2><?php echo ___('jobs.admin.fields.title') ?></h2>

<div class="box">

	<?php if($category): ?>
	<h3><?php echo ___('jobs.admin.fields.category.add.title') ?></h3>

	<?php echo Form::open(NULL, array('class' => 'bform form-horizontal', 'id' => 'field_to_category_form')); ?>
	<fieldset>
	<div class="control-group required">
		<label class="required label"><?php echo ___('jobs.admin.fields.category.add.choose_field') ?></label>
		<div class="controls">
			<?php echo Form::select('category_field_id', $fields_all->as_array('id', 'label')) ?>
		</div>
	</div>
	
	<div class="form-buttons">
		<ul>
			<li>
				<?php echo Form::submit('submitFieldToCategory', ___('form.add'), array('class' => 'button', 'id' => 'bform-submit')) ?>
			</li>
		</ul>
	</div>
	</fieldset>
	<?php echo Form::close(); ?>

	<?php endif; ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<form action="<?php echo URL::site('/admin/job/categories/fields/index') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo ___('Form_Admin_Job_Field_Add.name') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($fields as $field): ?>
					<tr>
						<td><?php echo $field->pk() ?></td>
						<td><?php echo $field->name ?></td>
						<td>
							<?php echo HTML::anchor(
								'admin/job/fields/remove_from_category?category_id='.$category->pk().'&field_id='.$field->pk(),
								___('jobs.admin.fields.category.delete')
							); ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>
	<div id="confirmDelete"></div>
</div>