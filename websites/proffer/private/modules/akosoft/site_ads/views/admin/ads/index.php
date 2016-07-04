<h2><?php echo ___('ads.admin.index.title') ?></h2>

<div class="box">

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/ads/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/ads/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('ad_title') ?></th>
					<th><?php echo ___('user') ?></th>
					<th><?php echo ___('ad_type') ?></th>
					<th><?php echo ___('ads.admin.table.details') ?></th>
					<th><?php echo ___('ad_clicks_count') ?></th>
					<th><?php echo ___('ad_display_count') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($ads as $a): ?>
					<tr>
						<?php if ($auth->permissions('admin/ads/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="ads[]" value="<?php echo $a->ad_id ?>" /></td>
						<?php endif ?>
						<td><?php echo $a->ad_id ?></td>
						<td><?php echo $a->ad_title ?></td>
						<td>
							<?php if($a->user->loaded()): ?>
							<div class="user_name"><?php echo $a->user->user_name ?></div>
							<a href="mailto:<?php echo $a->user->user_email ?>"><?php echo $a->user->user_email ?></a>
							<?php endif; ?>
						</td>
						<td><?php echo ads::type($a->ad_type) ?></td>
						<td>
							<div class="date_added">
								<?php echo ___('date_added') ?>:
								<div><?php echo $a->ad_date_added ?></div>
							</div>
							<br/>
							<div class="date_added">
								<?php echo ___('ads.admin.table.ad_date_start') ?>:
								<div><?php echo $a->ad_date_start ?></div>
							</div>
							<br/>
							<div class="date_added">
								<?php echo ___('date_availability') ?>:
								<div><?php echo $a->ad_availability ?></div>
							</div>
						</td>
						<td><?php echo $a->ad_clicks_count ?></td>
						<td><?php echo $a->ad_display_count ?></td>
						<td>
							<?php if ($a->user->loaded()): ?>
								<a href="<?php echo URL::site('/admin/ads/send_promotions/' . $a->user->pk()) ?>"><?php echo ___('ads.admin.send_promotions.btn') ?></a>
							<?php endif ?>
							<a href="<?php echo URL::site('/admin/ads/renew/' . $a->ad_id) ?>"><?php echo ___('admin.table.prolong') ?></a>
							<a href="<?php echo URL::site('/admin/ads/edit/' . $a->ad_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<a class="confirm" title="<?php echo ___('admin.delete.confirm') ?>" href="<?php echo URL::site('/admin/ads/delete/' . $a->ad_id) ?>"><?php echo ___('admin.table.delete') ?></a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<?php if ($auth->permissions('admin/ads/many')): ?>
				<tfoot>
					<tr>
						<td colspan="10">
							<a href="#" class="check-all"><?php echo ___('admin.table.select_all') ?></a>
							<?php echo Form::select('action', array(
								NULL => ___('select.choose'), 
								'delete' => ___('admin.table.select.delete'),
							), NULL, array('class' => 'form-many-actions')) ?>
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