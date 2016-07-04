<h2><?php echo ___('newsletter.admin.subscribers.title') ?></h2>

<div class="box">

	<h3><?php echo ___('admin.filters') ?></h3>

	<?php echo $form->param('class', 'form-horizontal') ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<?php echo $pager ?>

	<form class="form-many" action="<?php echo URL::site('/admin/newsletter/subscribers/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/newsletter/subscribers/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('email') ?></th>
					<th><?php echo ___('newsletter.accept_ads') ?></th>
					<th><?php echo ___('newsletter.is_active') ?></th>
					<th><?php echo ___('newsletter.emails_sent_counter') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($subscribers as $s): ?>
					<tr>
						<?php if ($auth->permissions('admin/newsletter/subscribers/many')): ?>
							<td><input type="checkbox" class="checkbox-list" value="<?php echo $s->email_id ?>" name="subscribers[]" /></td>
						<?php endif ?>
						<td><?php echo $s->email_id ?></td>
						<td><?php echo $s->email ?></td>
						<td><?php echo $s->accept_ads ? ___('newsletter.yes') : ___('newsletter.no') ?></td>
						<td><?php echo $s->status ? ___('newsletter.yes') : ___('newsletter.no') ?></td>
						<td><?php echo $s->email_sent_count ?></td>
						<td>
							<?php if ($auth->permissions('admin/newsletter/subscribers/delete')): ?>
								<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/newsletter/subscribers/delete/' . $s->email_id) ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<?php if ($auth->permissions('admin/newsletter/subscribers/many')): ?>
			<tfoot>
				<tr>
					<td colspan="5">
						<a href="#" class="check-all"><?php echo ___('admin.table.select_all') ?></a>
						<select name="action" class="form-many-actions">
							<option value=""><?php echo ___('select.choose') ?></option>
							<?php if ($auth->permissions('admin/newsletter/subscribers/delete')): ?>
								<option value="delete"><?php echo ___('admin.table.select.delete') ?></option>
							<?php endif ?>
						</select>
						<input type="submit" value="OK" />
					</td>
				</tr>
			</tfoot>
		<?php endif ?>
	</form>
	<?php echo $pager ?>

	<div id="confirmDelete"></div>
	<div id="alertMessage"></div>
</div>