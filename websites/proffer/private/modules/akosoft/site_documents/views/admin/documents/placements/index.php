<h2><?php echo ___('documents.placements.index.title') ?></h2>

<div class="box">

	<h3><?php echo ___('documents.placements.add.title') ?></h3>

	<?php echo $form ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('documents.forms.document_title') ?></th>
				<th><?php echo ___('documents.forms.document_url') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($links as $l): ?>
				<tr>
					<td><?php echo $l->document_placement_id ?></td>
					<td><?php echo $l->document->document_title ?></td>
					<td>
						<a target="_blank" href="<?php echo Route::url('site_documents/frontend/documents/show', array('url' => $l->document->document_url)) ?>">
							<?php if ($l->document->document_url): ?>
								<?php echo Route::url('site_documents/frontend/documents/show', array('url' => $l->document->document_url)) ?>
							<?php else: ?>
								<a href="<?php echo URL::site('/') ?>">/</a>
							<?php endif ?>
						</a>
					</td>
					<td>
						<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/documents/placements/delete/' . $l->document_placement_id) ?>"><?php echo ___('admin.table.delete') ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div id="confirmDelete"></div>
</div>