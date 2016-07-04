<h2><?php echo ___('users.admin.groups.index.title') ?></h2>

<div class="box">

	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('users.admin.groups.group_name') ?></th>
				<th><?php echo ___('admin.table.details') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($groups as $group): ?>
				<tr>
					<td><?php echo $group->pk() ?></td>
					<td><?php echo HTML::chars($group->group_name) ?></td>
					<td><?php echo HTML::chars($group->group_description) ?></td>
					<td>
						<?php if(!$group->is_default_group()): ?>
						
						<?php if ($auth->permissions('admin/groups/edit')): ?>
						<a href="<?php echo URL::site('admin/groups/edit/' . $group->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						
						<?php if ($auth->permissions('admin/groups/permissions')): ?>
						<a href="<?php echo URL::site('admin/groups/permissions/' . $group->pk()) ?>"><?php echo ___('users.admin.groups.permissions.btn') ?></a>
						<?php endif ?>
						
						<?php if ($auth->permissions('admin/groups/delete')): ?>
						<a href="<?php echo URL::site('admin/groups/delete/' . $group->pk()) ?>" class="confirm_delete" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
						
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>