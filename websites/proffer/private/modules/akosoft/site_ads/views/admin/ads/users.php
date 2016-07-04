<h2><?php echo ___('ads.admin.users.title') ?></h2>

<div class="box">

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/ads/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo ___('user_name') ?></th>
					<th><?php echo ___('email') ?></th>
					<th><?php echo ___('telephone') ?></th>
					<th><?php echo ___('ads.admin.users.count_ads') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $u): ?>
					<tr>
						<td><?php echo $u->user_id ?></td>
						<td><?php echo $u->user_name ?></td>
						<td><?php echo $u->user_email ?></td>
						<td><?php echo $u->data->users_data_telephone ?></td>
						<td><?php echo $u->ads_count ?></td>
						<td>
							<?php if ($auth->permissions('admin/ads/add')): ?>
								<a href="<?php echo URL::site('/admin/ads/add?user_id=' . $u->user_id) ?>"><?php echo ___('ads.admin.users.add') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/ads/index')): ?>
								<a href="<?php echo URL::site('/admin/ads/index?user_id=' . $u->user_id) ?>"><?php echo ___('ads.admin.users.show') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/ads/send_promotions')): ?>
								<a href="<?php echo URL::site('/admin/ads/send_promotions/' . $u->user_id) ?>"><?php echo ___('ads.admin.send_promotions.btn') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>
	<div id="confirmDelete"></div>

	<?php echo $pager ?>

</div>