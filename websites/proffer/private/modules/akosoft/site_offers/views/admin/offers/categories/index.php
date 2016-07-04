<h2><?php echo ___('offers.admin.categories.index.title') ?></h2>

<div class="box">

	<h3><?php echo ___('admin.list') ?></h3>

	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('offers.forms.categories.category_name') ?></th>
				<th><?php echo ___('offers.admin.count_offers') ?></th>
				<th><?php echo ___('admin.ordering.title') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categories as $c): ?>
				<tr>
					<td><?php echo $c->category_id ?></td>
					<td>
						<?php if ($c->has_children): ?>
							<a href="<?php echo URL::site('/admin/offer/categories/index/' . $c->category_id) ?>">
						<?php endif ?>
						<?php echo $c->category_name ?>
						<?php if ($c->has_children): ?>
							</a>
						<?php endif ?>
					</td>
					<td><?php echo $c->offers_category_count ?></td>
					<td>
						<?php if ($auth->permissions('admin/offer/categories/ordering')): ?>
							<?php if ($id = $c->has_prev_sibling()): ?>
								<p><a href="<?php echo URL::site('/admin/offer/categories/ordering/' . $c->category_id . '?prev=' . $id) ?>"><?php echo ___('admin.ordering.up') ?></a></p>
							<?php endif ?>
							<?php if ($id = $c->has_next_sibling()): ?>
								<p><a href="<?php echo URL::site('/admin/offer/categories/ordering/' . $c->category_id . '?next=' . $id) ?>"><?php echo ___('admin.ordering.down') ?></a></p>
							<?php endif ?>
						<?php endif ?>
					</td>
					<td>
						<?php if ($auth->permissions('admin/offer/categories/edit')): ?>
							<a href="<?php echo URL::site('/admin/offer/categories/edit/' . $c->category_id) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						<?php if ($auth->permissions('admin/offer/categories/delete')): ?>
							<a href="<?php echo URL::site('/admin/offer/categories/delete/' . $c->category_id) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<div id="confirmDelete"></div>
</div>