<h2><?php echo ___('catalog.admin.categories.title') ?></h2>

<div class="box">

	<form class="form-many" action="<?php echo URL::site('/admin/catalog/categories/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/catalog/categories/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('category') ?></th>
					<th><?php echo ___('catalog.companies_count') ?></th>
					<th><?php echo ___('admin.ordering.title') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($categories as $c): ?>
					<tr>
						<?php if ($auth->permissions('admin/catalog/categories/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="categories[]" value="<?php echo $c->category_id ?>" /></td>
						<?php endif ?>
						<td><?php echo $c->category_id ?></td>
						<td>
							<?php if ($c->has_children): ?>
								<a href="<?php echo URL::site('/admin/catalog/categories/index/' . $c->category_id) ?>">
							<?php endif ?>
							<?php echo $c->category_name ?>
							<?php if ($c->has_children): ?>
								</a>
							<?php endif ?>
						</td>
						<td>
							<p>
								<?php echo $c->companies_count ?>
							</p>
							<?php if ($c->companies_not_approved_count): ?>
								<p>
									<?php echo ___('catalog.companies_not_approved_count') ?>: <span class="red"><?php echo $c->companies_not_approved_count ?></span>
								</p>
							<?php endif ?>
						</td>
						<td>
							<?php if ($auth->permissions('admin/catalog/categories/ordering')): ?>
								<?php if ($id = $c->has_prev_sibling()): ?>
									<p><a href="<?php echo URL::site('/admin/catalog/categories/ordering/' . $c->category_id . '?prev=' . $id) ?>"><?php echo ___('admin.ordering.up') ?></a></p>
								<?php endif ?>
								<?php if ($id = $c->has_next_sibling()): ?>
									<p><a href="<?php echo URL::site('/admin/catalog/categories/ordering/' . $c->category_id . '?next=' . $id) ?>"><?php echo ___('admin.ordering.down') ?></a></p>
								<?php endif ?>
							<?php endif ?>
						</td>
						<td>
							<?php if ($auth->permissions('admin/catalog/companies/index')): ?>
								<a href="<?php echo URL::site('/admin/catalog/companies?category_id=' . $c->category_id) ?>"><?php echo ___('catalog.admin.categories.show_companies_btn') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/catalog/categories/add')): ?>
								<a href="<?php echo URL::site('/admin/catalog/categories/add?parent_id=' . $c->category_id) ?>"><?php echo ___('catalog.admin.categories.subcategory_add_btn') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/catalog/categories/edit')): ?>
								<a href="<?php echo URL::site('/admin/catalog/categories/edit/' . $c->category_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/catalog/categories/delete')): ?>
								<a href="<?php echo URL::site('/admin/catalog/categories/delete/' . $c->category_id) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<a href="#" class="check-all"><?php echo ___('admin.table.select_all') ?></a>
						<?php echo Form::select('action', array('delete' => ___('admin.table.select.delete')), NULL, array('class' => 'form-many-actions')) ?>
						<input type="submit" value="OK" />
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
	<div id="confirmDelete"></div>
	<div id="alertMessage"></div>
</div>