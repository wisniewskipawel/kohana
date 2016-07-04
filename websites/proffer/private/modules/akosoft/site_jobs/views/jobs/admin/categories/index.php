<h2><?php echo ___('jobs.admin.categories.title') ?></h2>

<div class="box">

	<form action="<?php echo URL::site('/admin/job/categories/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo ___('category_name') ?></th>
					<th><?php echo ___('jobs.jobs_count') ?></th>
					<th><?php echo ___('admin.ordering.title') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($categories as $c): ?>
					<tr>
						<td><?php echo $c->pk() ?></td>
						<td>
							<?php if ($c->has_children()): ?>
								<a href="<?php echo URL::site('/admin/job/categories/index/' . $c->pk()) ?>">
							<?php endif ?>
							<?php echo $c->category_name ?>
							<?php if ($c->has_children()): ?>
								</a>
							<?php endif ?>
						</td>
						<td><?php echo $c->count_jobs ?></td>
						<td>
							<?php if ($auth->permissions('admin/job/categories/ordering')): ?>
								<?php if ($id = $c->has_prev_sibling()): ?>
									<p><a href="<?php echo URL::site('/admin/job/categories/ordering/' . $c->category_id . '?prev=' . $id) ?>"><?php echo ___('admin.ordering.up') ?></a></p>
								<?php endif ?>
								<?php if ($id = $c->has_next_sibling()): ?>
									<p><a href="<?php echo URL::site('/admin/job/categories/ordering/' . $c->category_id . '?next=' . $id) ?>"><?php echo ___('admin.ordering.down') ?></a></p>
								<?php endif ?>
							<?php endif ?>
						</td>
						<td>
							<?php if ($auth->permissions('admin/job/categories/add')): ?>
								<a href="<?php echo URL::site('/admin/job/categories/add?parent_id=' . $c->category_id) ?>"><?php echo ___('jobs.admin.categories.add_subcategory') ?></a>
							<?php endif ?>
							<?php if ($c->has_children): ?>
								<a href="<?php echo URL::site('/admin/job/categories/index/' . $c->category_id) ?>"><?php echo ___('jobs.admin.categories.show_subcategories') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/job/categories/edit')): ?>
								<a href="<?php echo URL::site('/admin/job/categories/edit/' . $c->category_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/job/categories/delete')): ?>
								<a href="<?php echo URL::site('/admin/job/categories/delete/' . $c->category_id) ?>" class="confirm" title="<?php echo ___('jobs.admin.categories.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
							<?php if (!$c->has_children() AND $auth->permissions('admin/job/categories/fields/index')): ?>
								<a href="<?php echo URL::site('/admin/job/fields/category/'.$c->category_id) ?>"><?php echo ___('jobs.admin.categories.show_fields') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>
	<div id="confirmDelete"></div>
</div>