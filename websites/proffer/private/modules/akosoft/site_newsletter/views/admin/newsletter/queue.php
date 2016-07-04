<h2><?php echo ___('newsletter.admin.queue.title') ?></h2>

<div class="box">
	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('subject') ?></th>
				<th><?php echo ___('newsletter.admin.start_date') ?></th>
				<th><?php echo ___('newsletter.admin.emails_left') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($queue as $q): ?>
				<tr>
					<td><?php echo $q->letter_id ?></td>
					<td><?php echo $q->letter->letter_subject ?></td>
					<td>
						<?php if (strtotime($q->queue_send_at) < time()): ?>
							<span class="red"><?php echo $q->queue_send_at ?></span>
						<?php else: ?>
							<?php echo $q->queue_send_at ?>
						<?php endif ?>
					</td>
					<td><?php echo $q->count ?></td>
					<td>
						<?php if ($auth->permissions('admin/newsletter/cancel')): ?>
							<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/newsletter/cancel/' . $q->letter_id) ?>"><?php echo ___('newsletter.admin.cancel.btn') ?></a>
						<?php endif ?>
						<?php if ($auth->permissions('admin/newsletter/show')): ?>
							<a href="<?php echo URL::site('/admin/newsletter/show/' . $q->letter_id) ?>"><?php echo ___('admin.table.show') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<div id="confirmDelete"></div>
</div>