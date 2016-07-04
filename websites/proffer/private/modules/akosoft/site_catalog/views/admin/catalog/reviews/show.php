<h2><?php echo ___('catalog.admin.reviews.show.title') ?></h2>
<div class="box">
	
	<table class="entry_show">
		<tbody>
			<tr>
				<th><?php echo ___('ID') ?></th>
				<td><?php echo $review->pk() ?></td>
			</tr>
			<tr>
				<th><?php echo ___('catalog.reviews.rating') ?></th>
				<td><?php echo $review->rating ?></td>
			</tr>
			<tr>
				<th><?php echo ___('catalog.reviews.comment_body') ?></th>
				<td><?php echo HTML::chars($review->comment_body) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('author') ?></th>
				<td>
				<?php echo HTML::mailto($review->email, URL::idna_decode($review->email)) ?>

				<?php if(!empty($review->comment_author)): ?>
				<br/><?php echo HTML::chars($review->comment_author) ?>
				<?php endif; ?>

				<?php if(!empty($review->ip_address)): ?>
				<br/>IP: <?php echo HTML::chars($review->ip_address) ?>
				<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><?php echo ___('date_added') ?></th>
				<td><?php echo HTML::chars($review->date_created) ?></td>
			</tr>
			<tr>
				<th><?php echo ___('status') ?></th>
				<td>
					<?php if($review->status == Model_Catalog_Company_Review::STATUS_ACTIVE): ?>
					<?php echo ___('catalog.reviews.status.accepted') ?>
					<?php else: ?>
					<?php echo ___('catalog.reviews.status.not_accepted') ?>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><?php echo ___('catalog.company') ?></th>
				<td>
					<?php if($review->has_company())
						echo HTML::anchor(catalog::url($review->company), $review->company->company_name); ?>
				</td>
			</tr>
			
		</tbody>
	</table>
	
	<div class="entry_actions">
		
		<ul>
			<?php if($review->status != Model_Catalog_Company_Review::STATUS_ACTIVE): ?>
			<li><?php echo HTML::anchor(
				'admin/catalog/reviews/status/'.$review->pk().'?status='. Model_Catalog_Company_Review::STATUS_ACTIVE, 
				___('catalog.reviews.status.accept'),
				array('class' => 'btn')
			) ?></li>
			<?php endif; ?>
			
			<li><?php echo HTML::anchor(
				'admin/catalog/reviews/edit/'.$review->pk(),
				___('admin.table.edit'),
				array('class' => 'btn')
			) ?></li>
			
			<li><?php echo HTML::anchor(
				'admin/catalog/reviews/delete/'.$review->pk(),
				___('admin.table.delete'),
				array(
					'class' => 'btn confirm', 
					'title' => ___('admin.delete.confirm'),
				)
			) ?></li>
		</ul>
		
		<div id="confirmDelete"></div>
	</div>
</div>