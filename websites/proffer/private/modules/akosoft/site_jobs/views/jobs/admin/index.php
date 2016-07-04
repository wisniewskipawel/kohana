<h2><?php echo Arr::get($which, Arr::get($filters, 'which'), ___('jobs.module.name')) ?></h2>

<div class="box">

	<div class="table_filters clearfix">
		<?php echo Form::open(NULL, array('method' => 'GET', 'id' => 'search_jobs_form', 'class' => 'pull-left bform form-horizontal')) ?>
		<div class="control-group">
			<?php echo Form::label('search_pk', ___('jobs.search_pk').': ') ?>
			<div class="controls">
				<?php echo Form::input('search_pk', Arr::get($filters, 'primary_key')) ?>
			</div>
		</div>
		<?php echo Form::submit(NULL, ___('form.search'), array('class' => 'btn')) ?>
		<?php echo Form::close() ?>

		<?php echo Form::open(NULL, array('method' => 'GET', 'id' => 'show_jobs_form', 'class' => 'pull-right bform form-horizontal')) ?>
		<div class="control-group">
			<?php echo Form::label('which', ___('jobs.which').': ') ?>
			<div class="controls">
				<?php echo Form::select('which', $which, Arr::get($filters, 'which')); ?>
			</div>
		</div>
		<?php echo Form::submit(NULL, ___('form.show'), array('class' => 'btn')) ?>
		<?php echo Form::close() ?>
	</div>
	
	<hr/>

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/jobs/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/jobs/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('jobs.admin.title') ?></th>
					<th><?php echo ___('jobs.admin.details') ?></th>
					<th><?php echo ___('jobs.admin.promotion') ?></th>
					<th><?php echo ___('jobs.admin.user') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($jobs as $a): ?>
					<tr>
						<?php if ($auth->permissions('admin/jobs/many')): ?>
						<td><input type="checkbox" class="checkbox-list" name="jobs[]" value="<?php echo $a->pk() ?>" /></td>
						<?php endif ?>
						<td><?php echo $a->pk() ?></td>
						<td><?php echo $a->title ?></td>
						<td>
							<div class="date_added">
								<label><?php echo ___('date_added') ?>:</label>
								<div><?php echo date('Y-m-d', strtotime($a->date_added)) ?></div>
							</div>
							<br/>
							<div class="date_availability" style="font-weight: bold;">
								<label><?php echo ___('date_availability') ?>:</label>
								<div>
									<?php if (strtotime($a->date_availability) < time()): ?>
										<span class="red"><?php echo date('Y-m-d', strtotime($a->date_availability)) ?></span>
									<?php else: ?>
										<?php echo date('Y-m-d', strtotime($a->date_availability)) ?>
									<?php endif ?>
								</div>
							</div>
						</td>
						<td class="actions" style="width:auto;">
							<?php if ($a->is_promoted()): ?>
							<span class="red">
								<strong><?php echo ___('jobs.admin.promotion.yes') ?>:</strong><br/>
								<?php echo Arr::get(Jobs::distinctions(FALSE), $a->distinction) ?>
							</span>
							<?php if($auth->permissions('admin/jobs/promote')): ?>
							<a href="<?php echo URL::site('/admin/jobs/promote/' . $a->pk()) ?>"><?php echo ___('jobs.admin.promotion.promote_change') ?></a>
							<?php endif ?>
							<?php else: ?>
							<?php echo ___('jobs.admin.promotion.no') ?>
							<br/>
							<?php if($auth->permissions('admin/jobs/promote')): ?>
							<a href="<?php echo URL::site('/admin/jobs/promote/' . $a->pk()) ?>"><?php echo ___('jobs.admin.promotion.promote') ?></a>
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
							<?php if ( ! $a->is_approved AND $auth->permissions('admin/jobs/approve')): ?>
								<a href="<?php echo URL::site('/admin/jobs/approve/' . $a->pk()) ?>"><?php echo ___('admin.table.approve') ?></a>
							<?php endif ?>
								<a target="_blank" href="<?php echo URL::site(Jobs::uri($a)) . '?preview=true' ?>"><?php echo ___('admin.table.show') ?></a>
							<?php if ($auth->permissions('admin/jobs/renew')): ?>
								<a href="<?php echo URL::site('/admin/jobs/renew/' . $a->pk()) ?>"><?php echo ___('admin.table.prolong') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/jobs/edit')): ?>
								<a href="<?php echo URL::site('/admin/jobs/edit/' . $a->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/jobs/edit_attributes')): ?>
								<a href="<?php echo URL::site('/admin/jobs/edit_attributes/' . $a->pk()) ?>"><?php echo ___('jobs.admin.categories.show_fields') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/jobs/delete')): ?>
								<a href="<?php echo URL::site('/admin/jobs/delete/' . $a->pk()) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<?php if ($auth->permissions('admin/jobs/many')): ?>
				<tfoot>
					<tr>
						<td colspan="8">
							<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
							<select class="form-many-actions" name="action">
								<option value=""><?php echo ___('select.choose') ?></option>
								<?php if (Arr::get($filters, 'which') == 'not_approved' AND $auth->permissions('admin/jobs/approve')): ?>
									<option value="approve"><?php echo ___('admin.table.select.approve') ?></option>
								<?php endif ?>
								<?php if ($auth->permissions('admin/jobs/delete')): ?>
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