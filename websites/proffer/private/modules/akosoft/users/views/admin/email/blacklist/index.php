<h2><?php echo ___('users.admin.blacklist.index.title') ?></h2>

<div class="box">

	<?php echo $pagination ?>

	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('email') ?></th>
				<th class="actions"><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($emails as $email): ?>
				<tr>
					<td><?php echo $email->pk() ?></td>
					<td><?php echo URL::idna_decode($email->email) ?></td>
					<td>
						<?php if ($auth->permissions('admin/email/blacklist/edit')): ?>
							<a href="<?php echo URL::site('/admin/email/blacklist/edit/' . $email->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						<?php if ($auth->permissions('admin/email/blacklist/delete')): ?>
							<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/email/blacklist/delete/' . $email->pk()) ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?php echo $pagination ?>

	<div id="confirmDelete"></div>
</div>
