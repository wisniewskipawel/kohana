<h2><?php echo Arr::get(Products::which(), Arr::get($filters, 'which'), ___('products.title')) ?></h2>

<div class="box">

	<div class="table_filters clearfix">
		<?php echo Form::open(NULL, array('method' => 'GET', 'id' => 'search_products_form', 'class' => 'pull-left bform form-horizontal')) ?>
		<div class="control-group">
			<?php echo Form::label('search_pk', ___('products.admin.index.search_pk').': ') ?>
			<div class="controls">
				<?php echo Form::input('search_pk', Arr::get($filters, 'primary_key')) ?>
			</div>
		</div>
		<?php echo Form::submit(NULL, ___('form.search'), array('class' => 'btn')) ?>
		<?php echo Form::close() ?>

		<?php echo Form::open(NULL, array('method' => 'GET', 'id' => 'show_products_form', 'class' => 'pull-right bform form-horizontal')) ?>
		<div class="control-group">
			<?php echo Form::label('which', ___('products.admin.index.which').': ') ?>
			<div class="controls">
				<?php echo Form::select('which', Products::which(), Arr::get($filters, 'which')); ?>
			</div>
		</div>
		<?php echo Form::submit(NULL, ___('form.show'), array('class' => 'btn')) ?>
		<?php echo Form::close() ?>
	</div>
	
	<hr/>

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/products/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/products/many')): ?>
						<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('products.admin.index.product_title') ?></th>
					<th><?php echo ___('admin.table.details') ?></th>
					<th><?php echo ___('products.admin.index.promotion.title') ?></th>
					<th><?php echo ___('products.admin.index.user') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($products as $a): ?>
					<tr>
						<?php if ($auth->permissions('admin/products/many')): ?>
							<td><input type="checkbox" class="checkbox-list" name="products[]" value="<?php echo $a->pk() ?>" /></td>
						<?php endif ?>
						<td><?php echo $a->pk() ?></td>
						<td><?php echo $a->product_title ?></td>
						<td>
							<div class="date_added">
								<label><?php echo ___('date_added') ?>:</label>
								<div><?php echo date('Y-m-d', strtotime($a->product_date_added)) ?></div>
							</div>
							<br/>
							<div class="date_availability" style="font-weight: bold;">
								<label><?php echo ___('date_availability') ?>:</label>
								<div>
									<?php if (strtotime($a->product_availability) < time()): ?>
										<span class="red"><?php echo date('Y-m-d', strtotime($a->product_availability)) ?></span>
									<?php else: ?>
										<?php echo date('Y-m-d', strtotime($a->product_availability)) ?>
									<?php endif ?>
								</div>
							</div>
						</td>
						<td class="actions" style="width:auto;">
							<?php if ($a->is_promoted()): ?>
								<span class="red">
									<strong><?php echo ___('products.admin.index.promotion.yes') ?>:</strong>
									<br/>
									<?php echo Arr::get(products::distinctions(), $a->product_distinction) ?>
								</span>
							<?php else: ?>
							<?php echo ___('products.admin.index.promotion.no') ?>
							<br/>
							<?php if($auth->permissions('admin/products/promote')): ?>
							<a href="<?php echo URL::site('/admin/products/promote/' . $a->pk()) ?>"><?php echo ___('products.admin.index.promotion.promote') ?></a>
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
							<?php if ( ! $a->product_is_approved AND $auth->permissions('admin/products/approve')): ?>
								<a href="<?php echo URL::site('/admin/products/approve/' . $a->pk()) ?>"><?php echo ___('products.admin.index.approve') ?></a>
							<?php endif ?>
								<a target="_blank" href="<?php echo products::uri($a, TRUE) . '?preview=true' ?>"><?php echo ___('admin.table.show') ?></a>
							<?php if ($auth->permissions('admin/products/renew')): ?>
								<a href="<?php echo URL::site('/admin/products/renew/' . $a->pk()) ?>"><?php echo ___('admin.table.prolong') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/products/edit')): ?>
								<a href="<?php echo URL::site('/admin/products/edit/' . $a->pk()) ?>"><?php echo ___('admin.table.edit') ?></a>
							<?php endif ?>
							<?php if ($auth->permissions('admin/products/delete')): ?>
								<a href="<?php echo URL::site('/admin/products/delete/' . $a->pk()) ?>" class="confirm" title="<?php echo ___('admin.delete.confirm' ) ?>"><?php echo ___('admin.table.delete') ?></a>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
			<?php if ($auth->permissions('admin/products/many')): ?>
				<tfoot>
					<tr>
						<td colspan="8">
							<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
							<select class="form-many-actions" name="action">
								<option value=""><?php echo ___('select.choose') ?></option>
								<?php if (Arr::get($filters, 'which') == 'not_approved' AND $auth->permissions('admin/products/approve')): ?>
									<option value="approve"><?php echo ___('admin.table.select.approve') ?></option>
								<?php endif ?>
								<?php if ($auth->permissions('admin/products/delete')): ?>
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