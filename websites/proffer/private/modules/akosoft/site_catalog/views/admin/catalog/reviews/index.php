<h2><?php echo ___('catalog.admin.reviews.title') ?></h2>

<div class="box">

	<?php echo $pager ?>

	<form action="<?php echo URL::site('admin/catalog/reviews/many') ?>" class="form-many" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<?php if ($auth->permissions('admin/catalog/reviews/many')): ?>
					<th>[x]</th>
					<?php endif ?>
					<th>#</th>
					<th><?php echo ___('catalog.company') ?></th>
					<th><?php echo ___('author') ?></th>
					<th><?php echo ___('catalog.reviews.rating') ?></th>
					<th><?php echo ___('date_added') ?></th>
					<th><?php echo ___('status') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($reviews as $review): ?>
				<tr>
					<?php if ($auth->permissions('admin/catalog/reviews/many')): ?>
					<td><input type="checkbox" class="checkbox-list" name="ids[]" value="<?php echo $review->pk() ?>" /></td>
					<?php endif ?>
					<td><?php echo $review->pk() ?></td>
					<td>
						<?php if($review->has_company())
							echo HTML::anchor(catalog::url($review->company), $review->company->company_name); ?>
					</td>
					<td>
						<?php echo HTML::mailto($review->email, URL::idna_decode($review->email)) ?>

						<?php if(!empty($review->comment_author)): ?>
						<br/><?php echo HTML::chars($review->comment_author) ?>
						<?php endif; ?>

						<?php if(!empty($review->ip_address)): ?>
						<br/>IP: <?php echo HTML::chars($review->ip_address) ?>
						<?php endif; ?>
					</td>
					<td>
						<?php echo $review->rating ?>
					</td>
					<td>
						<?php echo $review->date_created ?>
					</td>
					<td>
						<?php if($review->status == Model_Catalog_Company_Review::STATUS_ACTIVE): ?>
						<?php echo ___('catalog.reviews.status.accepted') ?>
						<?php else: ?>
						<?php echo ___('catalog.reviews.status.not_accepted') ?> <br/>
						(<?php echo HTML::anchor('admin/catalog/reviews/status/'.$review->pk().'?status='. Model_Catalog_Company_Review::STATUS_ACTIVE, ___('catalog.reviews.status.accept')) ?>)
						<?php endif; ?>
					</td>
					<td>
						<?php echo HTML::anchor('admin/catalog/reviews/show/'.$review->pk(), ___('admin.table.show')) ?>
						<?php echo HTML::anchor('admin/catalog/reviews/edit/'.$review->pk(), ___('admin.table.edit')) ?>
						<?php echo HTML::anchor('admin/catalog/reviews/delete/'.$review->pk(), ___('admin.table.delete'), array(
							'class' => 'confirm', 
							'title' => ___('admin.delete.confirm'),
						)) ?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
			
			<?php if ($auth->permissions('admin/catalog/reviews/many')): ?>
			<tfoot>
				<tr>
					<td colspan="8">
						<a class="check-all" href="#"><?php echo ___('admin.table.select_all') ?></a>
						<select class="form-many-actions" name="action">
							<option value=""><?php echo ___('select.choose') ?></option>
							<?php if ($auth->permissions('admin/catalog/reviews/delete')): ?>
							<option value="delete" data-title="<?php echo ___('admin.table.select_many.delete_confirm') ?>"><?php echo ___('admin.table.select.delete') ?></option>
							<?php endif ?>
							<?php if ($auth->permissions('admin/catalog/reviews/status')): ?>
							<option value="approve"><?php echo ___('catalog.admin.reviews.approve.select_many') ?></option>
							<?php endif ?>
						</select>											
						<input type="submit" value="OK" />
					</td>
				</tr>
			</tfoot>
			<?php endif ?>
			
		</table>
	</form>

	<?php echo $pager ?>

	<div id="confirmDelete"></div>
	<div id="alertMessage"></div>
</div>