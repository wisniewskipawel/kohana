<h2><?php echo ___('catalog.admin.companies.title') ?></h2>

<div class="box">

	<h3><?php echo ___('admin.filters') ?></h3>

	<?php echo $form->param('class', 'form-horizontal') ?>

	<h3><?php echo ___('admin.list') ?></h3>

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/catalog/companies/many') ?>" method="post" class="form-many">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/catalog/companies/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('catalog.admin.companies.table.company_name') ?></th>
					<th><?php echo ___('catalog.admin.companies.table.promotion') ?></th>
					<th><?php echo ___('catalog.admin.companies.table.approved') ?></th>
					<th><?php echo ___('catalog.admin.companies.table.user') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($companies as $c): ?>
					<tr>
						<?php if ($auth->permissions('admin/catalog/companies/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="companies[]" value="<?php echo $c->company_id ?>" /></td>
						<?php endif ?>
						<td><?php echo $c->company_id ?></td>
						<td>
							<?php echo $c->company_name ?>
						</td>
						<td>
							<p>
								<?php if ($c->company_is_promoted): ?>
									<?php if (strtotime($c->company_promotion_availability) < time()): ?>
										<?php echo ___('catalog.admin.companies.table.promotion_expired') ?>
									<?php else: ?>
										<span class="red"><?php echo ___('catalog.admin.companies.table.promotion_yes') ?></span><br/>
										<?php echo ___('catalog.admin.companies.table.promotion_to') ?>: <?php echo $c->company_promotion_availability ?>
									<?php endif ?>
								<?php else: ?>
									<?php echo ___('catalog.admin.companies.table.promotion_no') ?>
								<?php endif ?>
							</p>
						</td>
						<td>
							<p>
								<?php if ( ! $c->company_is_approved): ?>
									<span class="red"><?php echo ___('catalog.admin.companies.table.approved_no') ?></span> 
									<?php if ($auth->permissions('admin/catalog/companies/approve')): ?> 
										<a href="<?php echo URL::site('/admin/catalog/companies/approve/' . $c->company_id) ?>"><?php echo ___('catalog.admin.companies.table.approve') ?></a>
									<?php endif ?>
								<?php else: ?>
									<?php echo ___('catalog.admin.companies.table.approved_yes') ?>
								<?php endif ?>
							</p>
						</td>
						<td>
							<?php if ($c->user->user_id): ?>
								<?php echo $c->user->user_name ?><br/>
								<?php echo HTML::mailto($c->user->user_email, URL::idna_decode($c->user->user_email)) ?>
							<?php endif ?>
							
							<?php if(Kohana::$environment != Kohana::DEMO): ?>
							<div class="ip_address">
								IP: <?php echo HTML::chars($c->ip_address) ?>
							</div>
							<?php endif ?>
						</td>
						<td>
							<?php if($c->is_promoted()) echo HTML::anchor(catalog::url($c), ___('admin.table.show')) ?>
							
							<?php if ($auth->permissions('admin/catalog/companies/edit')): ?>
							<a href="<?php echo URL::site('/admin/catalog/companies/edit/' . $c->company_id) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif; ?>
							
							<?php if ($auth->permissions('admin/catalog/companies/delete')): ?>
							<a href="<?php echo URL::site('/admin/catalog/companies/delete/' . $c->company_id) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm') ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="8" >
						<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
						<select class="form-many-actions" name="action">
							<option value=""><?php echo ___('select.choose') ?></option>
							<?php if ($auth->permissions('admin/catalog/companies/approve')): ?>
								<option value="approve"><?php echo ___('admin.table.select.approve') ?></option>
							<?php endif ?>
							<?php if ($auth->permissions('admin/catalog/companies/delete')): ?>
								<option value="delete"><?php echo ___('admin.table.select.delete') ?></option>
							<?php endif ?>
						</select>											
						<input type="submit" value="OK" />
					</td>
				</tr>
			</tfoot>
		</table>
	</form>

	<?php echo $pager ?>

	<div id="confirmDelete"></div>
</div>