<h2><?php echo ___('jobs.admin.comments.show.title') ?></h2>
<div class="box">
	
	<table class="entry_show">
		<tbody>
			<tr>
				<th>#</th>
				<td><?php echo $comment->pk() ?></td>
			</tr>
			<tr>
				<th><?php echo ___('content') ?></th>
				<td><?php echo HTML::chars($comment->body) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('author') ?></th>
				<td>
					<?php if($comment->has_user()): ?>
					<?php 
					echo HTML::mailto($comment->get_user()->get_email_address()).' - '.HTML::chars($comment->get_user()->user_name) 
					?>
					<br/>
					<?php endif; ?>

					IP: <?php echo $comment->ip_address ?>
				</td>
			</tr>
			<tr>
				<th><?php echo ___('date_added') ?></th>
				<td><?php echo HTML::chars($comment->date_added) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('job') ?></th>
				<td>
				<?php
				if($comment->job->loaded())
					echo HTML::anchor(Jobs::uri($comment->job), $comment->job->title);
				?>
				</td>
			</tr>
			<?php if($comment->has_parent()): ?>
			<tr>
				<th><?php echo ___('jobs.admin.comments.reply_to') ?>:</th>
				<td>
				<?php echo HTML::anchor('admin/job/comments/show/'.$comment->parent_comment->pk(), ___('admin.table.show'), array('target' => '_blank')) ?>
				</td>
			</tr>
			<?php endif; ?>
			
		</tbody>
	</table>
	
	<div class="entry_actions">
		
		<ul>
			<?php if ($auth->permissions('admin/job/comments/edit')): ?>
			<li><?php echo HTML::anchor(
				'admin/job/comments/edit/' . $comment->pk(),
				___('admin.table.edit'),
				array('class' => 'btn')
			) ?></li>
			<?php endif ?>
			
			<?php if ($auth->permissions('admin/job/comments/delete')): ?>
			<li><?php echo HTML::anchor(
				'admin/job/comments/delete/' . $comment->pk(),
				___('admin.table.delete'),
				array(
					'class' => 'btn confirm', 
					'title' => ___('admin.delete.confirm'),
				)
			) ?></li>
			<?php endif ?>
		</ul>
		
		<div id="confirmDelete"></div>
	</div>
</div>