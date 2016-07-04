<h2><?php echo ___('jobs.admin.replies.title') ?></h2>

<div class="box">
	
	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/job/replies/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/job/replies/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('job') ?></th>
					<th><?php echo ___('author') ?></th>
					<th><?php echo ___('date_added') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($replies as $reply): ?>
					<tr>
						<?php if ($auth->permissions('admin/job/replies/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="replies[]" value="<?php echo $reply->pk() ?>" /></td>
						<?php endif ?>
						<td><?php echo $reply->pk() ?></td>
						<td>
							<?php
							if($reply->job->loaded())
								echo HTML::anchor(Jobs::uri($reply->job), $reply->job->title);
							?>
						</td>
						<td>
							<?php if($reply->has_user()): ?>
							<?php 
							echo HTML::mailto($reply->get_user()->get_email_address()).' - '.HTML::chars($reply->get_user()->user_name) 
							?>
							<br/>
							<?php endif; ?>
							
							IP: <?php echo $reply->ip_address ?>
						</td>
						<td>
							<?php echo $reply->date_added ?>
						</td>
						<td>
							<?php echo HTML::anchor('admin/job/replies/show/'.$reply->pk(), ___('admin.table.show'), array('target' => '_blank')) ?>
							
							<?php if ($auth->permissions('admin/job/replies/edit')): ?>
								<a href="<?php echo URL::site('/admin/job/replies/edit/' . $reply->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/job/replies/delete')): ?>
								<a href="<?php echo URL::site('/admin/job/replies/delete/' . $reply->pk()) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<?php if ($auth->permissions('admin/job/replies/many')): ?>
				<tfoot>
					<tr>
						<td colspan="8">
							<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
							<select class="form-many-actions" name="action">
								<option value=""><?php echo ___('select.choose') ?></option>
								<?php if ($auth->permissions('admin/job/replies/delete')): ?>
								<option value="delete" data-title="<?php echo ___('admin.table.select_many.delete_confirm') ?>"><?php echo ___('admin.table.select.delete') ?></option>
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
	<div id="alertMessage"></div>

	<?php echo $pager ?>
	
</div>