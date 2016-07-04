<h2><?php echo ___('products.admin.categories.title') ?></h2>

<div class="box">

	<form class="form-many" action="<?php echo URL::site('/admin/product/categories/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/product/categories/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('category') ?></th>
					<th><?php echo ___('products.admin.categories.products_count') ?></th>
					<th><?php echo ___('admin.ordering.title') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($categories as $c): ?>
					<tr>
						<?php if ($auth->permissions('admin/product/categories/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="categories[]" value="<?php echo $c->category_id ?>" /></td>
						<?php endif ?>
						<td><?php echo $c->category_id ?></td>
						<td>
							<?php if ($c->has_children()): ?>
								<a href="<?php echo URL::site('/admin/product/categories/index/' . $c->category_id) ?>">
							<?php endif ?>
							<?php echo $c->category_name ?>
							<?php if ($c->has_children()): ?>
								</a>
							<?php endif ?>
						</td>
						<td>
							<?php echo $c->count_products ?>
						</td>
						<td>
							<?php if ($auth->permissions('admin/product/categories/ordering')): ?>
								<?php if ($id = $c->has_prev_sibling()): ?>
									<p><a href="<?php echo URL::site('/admin/product/categories/ordering/' . $c->category_id . '?prev=' . $id) ?>"><?php echo ___('admin.ordering.up') ?></a></p>
								<?php endif ?>
								<?php if ($id = $c->has_next_sibling()): ?>
									<p><a href="<?php echo URL::site('/admin/product/categories/ordering/' . $c->category_id . '?next=' . $id) ?>"><?php echo ___('admin.ordering.down') ?></a></p>
								<?php endif ?>
							<?php endif ?>
						</td>
						<td>
							<?php if ($auth->permissions('admin/product/companies/index')): ?>
								<a href="<?php echo URL::site('/admin/product/companies?category_id=' . $c->category_id) ?>"><?php echo ___('products.admin.categories.show_products_btn') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/product/categories/add')): ?>
								<a href="<?php echo URL::site('/admin/product/categories/add?parent_id=' . $c->category_id) ?>"><?php echo ___('products.admin.categories.subcategory_add_btn') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/product/categories/edit')): ?>
								<a href="<?php echo URL::site('/admin/product/categories/edit/' . $c->category_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/product/categories/delete')): ?>
								<a href="<?php echo URL::site('/admin/product/categories/delete/' . $c->category_id) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
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