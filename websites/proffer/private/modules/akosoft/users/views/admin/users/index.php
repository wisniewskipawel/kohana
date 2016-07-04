<h2><?php echo ___('users.title') ?></h2>

<div class="box">

	<h3><?php echo ___('admin.filters') ?></h3>

	<?php echo $form->param('class', 'form-horizontal') ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/users/many') ?>" method="post">
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
				<?php foreach ($users as $u): ?>
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
							<br/>
							<?php 
							$results = Events::fire('admin/users_index', array('action' => 'statistics', 'user_id' => $u->pk()), TRUE);
							$results = Arr::flatten($results);
							
							foreach($results as $label => $column): ?>
							<?php echo $label.': '.$u->{$column} ?><br/>
							<?php endforeach ?>
						</td>
						<td>
							<?php 
							$results = Events::fire('admin/users_index', array('action' => 'action_links', 'user_id' => $u->pk()), TRUE);
							
							foreach($results as $result)
								echo HTML::anchor($result['uri'], $result['title']); ?>
							
							<?php if (Modules::enabled('site_ads') AND $auth->permissions('admin/ads/add')): ?>
								<a href="<?php echo URL::site('/admin/ads/add?user_id=' . $u->user_id) ?>"><?php echo ___('ads.admin.table.action.add') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/users/edit')): ?>
								<a href="<?php echo URL::site('/admin/users/edit/' . $u->user_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/users/delete')): ?>
								<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/users/delete/' . $u->user_id) ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/users/promotions')): ?>
								<a href="<?php echo URL::site('/admin/users/promotions/' . $u->pk()) ?>"><?php echo ___('users.admin.table.promotions') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>

	<?php echo $pager ?>

	<div id="confirmDelete"></div>
</div>