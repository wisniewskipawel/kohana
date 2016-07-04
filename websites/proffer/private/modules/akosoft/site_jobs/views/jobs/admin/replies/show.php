<h2><?php echo ___('jobs.admin.replies.show.title') ?></h2>
<div class="box">
	
	<table class="entry_show">
		<tbody>
			<tr>
				<th>#</th>
				<td><?php echo $reply->pk() ?></td>
			</tr>
			<tr>
				<th><?php echo ___('jobs.replies.forms.content') ?></th>
				<td><?php echo HTML::chars($reply->content) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('jobs.replies.forms.price') ?></th>
				<td><?php echo HTML::chars($reply->price) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('jobs.replies.forms.price_unit') ?></th>
				<td><?php echo Arr::get(Model_Job_Reply::get_price_units(), $reply->price_unit) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('author') ?></th>
				<td>
					<?php if($reply->has_user()): ?>
					<?php 
					echo HTML::mailto($reply->get_user()->get_email_address()).' - '.HTML::chars($reply->get_user()->user_name) 
					?>
					<br/>
					<?php endif; ?>

					IP: <?php echo $reply->ip_address ?>
				</td>
			</tr>
			<tr>
				<th><?php echo ___('date_added') ?></th>
				<td><?php echo HTML::chars($reply->date_added) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('job') ?></th>
				<td>
				<?php
				if($reply->job->loaded())
					echo HTML::anchor(Jobs::uri($reply->job), $reply->job->title);
				?>
				</td>
			</tr>
			
		</tbody>
	</table>
	
	<div class="entry_actions">
		
		<ul>
			<?php if ($auth->permissions('admin/job/replies/edit')): ?>
			<li><?php echo HTML::anchor(
				'admin/job/replies/edit/' . $reply->pk(),
				___('admin.table.edit'),
				array('class' => 'btn')
			) ?></li>
			<?php endif ?>
			
			<?php if ($auth->permissions('admin/job/replies/delete')): ?>
			<li><?php echo HTML::anchor(
				'admin/job/replies/delete/' . $reply->pk(),
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