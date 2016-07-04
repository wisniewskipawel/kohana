<h2><?php echo Arr::get(offers::which(), Arr::get($filters, 'which'), ___('offers.title')) ?></h2>

<div class="box">

	<div class="table_filters clearfix">
		<?php echo Form::open(NULL, array('method' => 'GET', 'id' => 'show_offers_form', 'class' => 'pull-right bform form-horizontal')) ?>
		<div class="control-group">
			<?php echo Form::label('which', ___('offers.which.label').': ')?>
			<div class="controls">
			<?php echo Form::select('which', offers::which(), Arr::get($filters, 'which')); ?>
			</div>
		</div>
		<?php echo Form::submit(NULL, ___('form.show'), array('class' => 'btn')) ?>
		<?php echo Form::close() ?>
	</div>
	
	<hr/>
	
	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/offers/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/offers/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('offers.forms.offer_title') ?></th>
					<th><?php echo ___('admin.table.details') ?></th>
					<th><?php echo ___('offers.admin.table.promotion') ?></th>
					<th><?php echo ___('offers.admin.table.user') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($offers as $a): ?>
					<tr>
						<?php if ($auth->permissions('admin/offers/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="offers[]" value="<?php echo $a->pk() ?>" /></td>
						<?php endif ?>
						<td><?php echo $a->pk() ?></td>
						<td><?php echo $a->offer_title ?></td>
						<td>
							<div class="date_added">
								<label><?php echo ___('date_added') ?>:</label>
								<div><?php echo date('Y-m-d', strtotime($a->offer_date_added)) ?></div>
							</div>
							<br/>
							<div class="date_availability" style="font-weight: bold;">
								<label><?php echo ___('date_availability') ?>:</label>
								<div>
									<?php if (strtotime($a->offer_availability) < time()): ?>
										<span class="red"><?php echo $a->offer_availability ?></span>
									<?php else: ?>
										<?php echo $a->offer_availability ?>
									<?php endif ?>
								</div>
							</div>
						</td>
						<td class="actions" style="width:auto;">
							<?php if ($a->is_promoted()): ?>
								<span class="red">
									<strong><?php echo ___('offers.admin.table.promotion_yes') ?>:</strong>
									<br/>
									<?php echo Arr::get(offers::distinctions(), $a->offer_distinction) ?>
								</span>
							<?php else: ?>
								<?php echo ___('offers.admin.table.promotion_no') ?>
								<br/>
								<?php if($auth->permissions('admin/offers/promote')): ?>
								<a href="<?php echo URL::site('/admin/offers/promote/' . $a->pk()) ?>"><?php echo ___('promote') ?></a>
								<?php endif ?>
							<?php endif ?>
						</td>
						<td>
							<?php if ($a->user->user_name): ?>
								<?php echo $a->user->user_name ?>
								<?php echo HTML::mailto($a->user->user_email, URL::idna_decode($a->user->user_email)) ?>
							<?php endif ?>
							
							<?php if(Kohana::$environment != Kohana::DEMO): ?>
							<div class="ip_address">
								IP: <?php echo HTML::chars($a->ip_address) ?>
							</div>
							<?php endif ?>
						</td>
						<td>
							<?php if ( ! $a->offer_is_approved AND $auth->permissions('admin/offers/approve')): ?>
								<a href="<?php echo URL::site('/admin/offers/approve/' . $a->pk()) ?>"><?php echo ___('offers.admin.table.approve') ?></a>
							<?php endif ?>
							<a target="_blank" href="<?php echo Route::url('site_offers/frontend/offers/show', array('offer_id' => $a->pk(), 'title' => URL::title($a->offer_title))) . '?preview=true' ?>"><?php echo ___('admin.table.show') ?></a>
							<?php if ($auth->permissions('admin/offers/renew')): ?>
								<a href="<?php echo URL::site('/admin/offers/renew/' . $a->pk()) ?>"><?php echo ___('offers.admin.table.renew') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/offers/edit')): ?>
								<a href="<?php echo URL::site('/admin/offers/edit/' . $a->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/offers/delete')): ?>
								<a href="<?php echo URL::site('/admin/offers/delete/' . $a->pk()) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<?php if ($auth->permissions('admin/offers/many')): ?>
				<tfoot>
					<tr>
						<td colspan="8">
							<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
							<select class="form-many-actions" name="action">
								<option value=""><?php echo ___('select.choose') ?></option>
								<?php if (Arr::get($filters, 'which') == 'not_approved' AND $auth->permissions('admin/offers/approve')): ?>
									<option value="approve"><?php echo ___('admin.table.select.approve') ?></option>
								<?php endif ?>
								<?php if ($auth->permissions('admin/offers/delete')): ?>
									<option value="delete"><?php echo ___('admin.table.select.delete') ?></option>
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