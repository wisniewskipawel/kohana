<div id="offer_coupons_box" class="box primary">
	<h2><?php echo ___('offers.profile.coupons.title') ?></h2>
	<div class="content">
		<?php if(count($coupons)): ?>
		
		<?php echo $pagination ?>
		
		<table id="offer_coupons">
			<thead>
				<tr>
					<th class="token"><?php echo ___('offers.profile.coupons.table.token') ?></th>
					<th class="email"><?php echo ___('offers.profile.coupons.table.email') ?></th>
					<th class="date"><?php echo ___('offers.profile.coupons.table.date') ?></th>
				</tr>
			</thead>
			
			<tbody>
			<?php foreach($coupons as $coupon): ?>
			<tr>
				<td><?php echo $coupon->token ?></td>
				<td><?php echo HTML::mailto($coupon->email) ?></td>
				<td><?php echo Date::my($coupon->date_created) ?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php echo $pagination ?>
		
		<?php else: ?>
		<div class="no_results"><?php echo ___('offers.profile.coupons.no_results') ?></div>
		<?php endif; ?>
	</div>
</div>
