<h2><?php echo ___('emails.title') ?></h2>

<div class="box">

	<div class="table_filters clearfix">
		<?php echo Form::open(NULL, array('method' => 'GET', 'id' => 'show_emails_form', 'class' => 'pull-right bform form-horizontal')) ?>
		<div class="control-group">
			<?php echo Form::label('type', ___('emails.filters.types').': ') ?>
			<div class="controls">
				<?php echo Form::select('type', Arr::unshift($types, NULL, ''), Arr::get($filters, 'type')); ?>
			</div>
		</div>
		<?php echo Form::submit(NULL, ___('form.show'), array('class' => 'btn')) ?>
		<?php echo Form::close() ?>
	</div>
	
	<hr/>
	
	<table class="table tablesorter">
		<thead>
			<tr>
				<th><?php echo ___('email_alias') ?></th>
				<th><?php echo ___('email_description') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($emails as $e): ?>
				<tr>
					<td><?php echo $e->email_alias ?></td>
					<td><?php echo $e->email_description ?></td>
					<td>
						<a href="<?php echo URL::site('/admin/emails/edit/' . $e->email_id) ?>"><?php echo ___('admin.table.edit') ?></a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>