<h2><?php echo ___('jobs.admin.fields.title') ?></h2>

<div class="box">

	<form action="<?php echo URL::site('/admin/job/categories/fields/index') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo ___ ('jobs.admin.fields.name') ?></th>
					<th><?php echo ___ ('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($fields as $field): ?>
					<tr>
						<td><?php echo $field->pk() ?></td>
						<td><?php echo $field->name ?></td>
						<td>
							<?php echo HTML::anchor(
								'admin/job/fields/edit/'.$field->pk(),
								___('admin.table.edit')
							); ?>
							<?php echo HTML::anchor(
								'admin/job/fields/delete/'.$field->pk(),
								___('admin.table.delete')
							); ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>
	<div id="confirmDelete"></div>
</div>