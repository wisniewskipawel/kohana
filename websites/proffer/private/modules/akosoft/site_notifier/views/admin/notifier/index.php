<h2><?php echo ___('notifiers.admin.index.title') ?></h2>

<div class="box">
	
	<h3><?php echo ___('admin.list') ?></h3>
	
	<?php echo $pagination ?>
	
	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('email') ?></th>
				<th><?php echo ___('notifiers.module') ?></th>
				<th><?php echo ___('status') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($subscribers as $s): ?>
				<tr>
					<td><?php echo $s->pk() ?></td>
					<td><?php echo $s->notify_email ?></td>
					<td><?php echo $s->module ?></td>
					<td>
						<?php if($s->is_active()): ?>
						<?php echo ___('notifiers.forms.status.active') ?>
						<?php else: ?>
						<?php echo ___('notifiers.forms.status.not_active') ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if ($auth->permissions('admin/notifier/edit')): ?>
							<a href="<?php echo URL::site('/admin/notifier/edit/' . $s->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						<?php if ($auth->permissions('admin/notifier/delete')): ?>
							<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/notifier/delete/' . $s->pk()) ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<?php echo $pagination ?>
	
	<div id="confirmDelete"></div>
	<div id="alertMessage"></div>
</div>