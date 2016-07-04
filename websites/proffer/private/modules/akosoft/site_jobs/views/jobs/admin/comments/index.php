<h2><?php echo ___('jobs.admin.comments.title') ?></h2>

<div class="box">
	
	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/job/comments/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/job/comments/many')): ?>
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
				<?php foreach ($comments as $comment): ?>
					<tr>
						<?php if ($auth->permissions('admin/job/comments/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="comments[]" value="<?php echo $comment->pk() ?>" /></td>
						<?php endif ?>
						<td><?php echo $comment->pk() ?></td>
						<td>
							<?php
							if($comment->job->loaded())
								echo HTML::anchor(Jobs::uri($comment->job), $comment->job->title);
							?>
						</td>
						<td>
							<?php if($comment->has_user()): ?>
							<?php 
							echo HTML::mailto($comment->get_user()->get_email_address()).' - '.HTML::chars($comment->get_user()->user_name) 
							?>
							<br/>
							<?php endif; ?>
							
							IP: <?php echo $comment->ip_address ?>
						</td>
						<td>
							<?php echo $comment->date_added ?>
						</td>
						<td>
							<?php echo HTML::anchor('admin/job/comments/show/'.$comment->pk(), ___('admin.table.show'), array('target' => '_blank')) ?>
							
							<?php if ($auth->permissions('admin/job/comments/edit')): ?>
								<a href="<?php echo URL::site('/admin/job/comments/edit/' . $comment->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/job/comments/delete')): ?>
								<a href="<?php echo URL::site('/admin/job/comments/delete/' . $comment->pk()) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<?php if ($auth->permissions('admin/job/comments/many')): ?>
				<tfoot>
					<tr>
						<td colspan="8">
							<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
							<select class="form-many-actions" name="action">
								<option value=""><?php echo ___('select.choose') ?></option>
								<?php if ($auth->permissions('admin/job/comments/delete')): ?>
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