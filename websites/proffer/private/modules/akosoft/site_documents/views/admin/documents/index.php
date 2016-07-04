<h2><?php echo ___('documents.title') ?></h2>

<div class="box">

	<?php echo $pager ?>

	<form class="form-many" action="<?php echo URL::site('/admin/documents/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>[x]</th>
					<th>#</th>
					<th><?php echo ___('documents.forms.document_title') ?></th>
					<th><?php echo ___('documents.forms.document_url') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($documents as $d): ?>
					<tr>
						<td><input class="checkbox-list" type="checkbox" name="documents[]" <?php if (!$d->document_is_deletable): ?>disabled="disabled"<?php endif ?> value="<?php echo $d->document_id ?>" /></td>
						<td><?php echo $d->document_id ?></td>
						<td><?php echo $d->document_title ?></td>
						<td>
							<?php echo HTML::anchor(
								Route::get('site_documents/frontend/documents/show')
									->uri(array('url' => $d->document_url)),
								$d->document_url,
								array(
									'target' => '_blank',
								)
							); ?>
						</td>
						<td>
							<?php if ($auth->permissions('admin/documents/edit')): ?>
								<a href="<?php echo URL::site('/admin/documents/edit/' . $d->document_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($d->document_is_deletable && $auth->permissions('admin/documents/delete')): ?>
								<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/documents/delete/' . $d->document_id) ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<?php if ($auth->permissions('admin/documents/many')): ?>
				<tfoot>
					<tr>
						<td colspan="5">
							<a href="#" class="check-all"><?php echo ___('admin.table.select_all') ?></a>
							<select name="action" class="form-many-actions">
								<option value=""><?php echo ___('select.choose') ?></option>
								<?php if ($auth->permissions('admin/documents/delete')): ?>
									<option value="delete"><?php echo ___('admin.table.select.delete') ?></option>
								<?php endif ?>
							</select>
							<input type="submit" value="OK" />
						</td>
					</tr>
				</tfoot>
			<?php endif ?>
		</table>
	</form>
	<div id="confirmDelete"></div>

	<?php echo $pager ?>

</div>