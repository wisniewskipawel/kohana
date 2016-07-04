<h2><?php echo ___('products.admin.availabilites.index.title') ?></h2>

<div class="box">
	
	<?php if ($auth->permissions('admin/product/availabilities/add')): ?>
	
		<h3><a href="#" onclick="$('#form-add').toggle(); return false;"><?php echo ___('products.admin.availabilites.add.title') ?></a></h3>

		<div id="form-add" <?php if ( ! isset($_GET['add']) AND ! ($form->is_sent() AND $validated == FALSE)): ?>style="display:none;"<?php endif ?>>
			<?php echo $form ?>
		</div>
		
	<?php endif ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('products.admin.availabilites.index.availability') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($availabilities as $a): ?>
				<tr>
					<td><?php echo $a->id ?></td>
					<td>
						<?php echo $a->availability ?>
					</td>
					<td>
						<?php if ($auth->permissions('admin/product/availabilities/edit')): ?>
							<a href="<?php echo URL::site('/admin/product/availabilities/edit/' . $a->id) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						<?php if ($auth->permissions('admin/product/availabilities/delete')): ?>
							<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/product/availabilities/delete/' . $a->id) ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
		
	<div id="confirmDelete"></div>
</div>