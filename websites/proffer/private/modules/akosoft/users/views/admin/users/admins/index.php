<h2><?php echo ___('users.admin.admins.title') ?></h2>

<div class="box">

	<?php echo $pager ?>

	<table class="table tablesorter">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo ___('user_name') ?></th>
				<th><?php echo ___('status') ?></th>
				<th><?php echo ___('user_registration_date') ?></th>
				<th><?php echo ___('admin.table.details') ?></th>
				<th><?php echo ___('admin.table.actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($admins as $u): ?>
				<tr>
					<td><?php echo $u->user_id ?></td>
					<td><?php echo $u->user_name ?></td>
					<td>
						<?php if ($u->user_status == Model_User::STATUS_NOT_ACTIVE): ?>
						<?php echo ___('status.not_active') ?>
						<br/><br/>
						<a href="<?php echo URL::site('/admin/users/activate/'.$u->user_id) ?>">aktywuj</a>
						<?php elseif($u->user_status == Model_User::STATUS_ACTIVE): ?>
						<?php echo ___('status.active') ?>
						<?php endif ?>
					</td>
					<td>
						<?php echo date('Y-m-d H:i', $u->user_registration_date) ?>
					</td>
					<td>
						<?php echo ___('email') ?>: <a href="mailto:<?php echo $u->user_email ?>"><?php echo $u->user_email ?></a>
						<?php if(Kohana::$environment != Kohana::DEMO): ?>
						<div class="ip_address">
							IP: <?php echo HTML::chars($u->user_ip) ?>
						</div>
						<?php endif ?>
					</td>
					<td>
						<?php if ($auth->permissions('admin/admins/edit')): ?>
						<a href="<?php echo URL::site('/admin/admins/edit/' . $u->user_id) ?>"><?php echo ___('admin.table.edit') ?></a>
						<?php endif ?>
						
						<?php if ($auth->permissions('admin/admins/delete')): ?>
						<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/admins/delete/' . $u->user_id) ?>"><?php echo ___('admin.table.delete') ?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?php echo $pager ?>

	<div id="confirmDelete"></div>
</div>