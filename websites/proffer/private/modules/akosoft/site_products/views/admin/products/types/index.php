<h2><?php echo ___('products.admin.types.index.title') ?></h2>

<div class="box">
	
	<?php if ($auth->permissions('admin/product/types/add')): ?>
	
		<h3><a href="#" onclick="$('#form-add').toggle(); return false;"><?php echo ___('products.admin.types.add.title') ?></a></h3>

		<div id="form-add" <?php if ( ! isset($_GET['add']) AND ! ($form->is_sent() AND $validated == FALSE)): ?>style="display:none;"<?php endif ?>>
			<?php echo $form ?>
		</div>
		
	<?php endif ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('products.admin.types.index.name') ?></th>
				<th><?php echo ___('products.admin.types.index.count_products') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($types as $t): ?>
				<tr>
					<td><?php echo $t->id ?></td>
					<td>
						<?php echo $t->name ?>
					</td>
					<td><?php echo $t->products_count ?></td>
					<td>
						<a href="<?php echo URL::site('/admin/product/types/edit/' . $t->id) ?>"><?php echo ___('admin.table.edit') ?></a>
						<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/product/types/delete/' . $t->id) ?>"><?php echo ___('admin.table.delete') ?></a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<div id="confirmDelete"></div>
</div>