<h2><?php echo ___('payments.admin.index.title') ?></h2>

<div class="box">

	<?php echo $pager ?>

	<form action="<?php echo URL::site('/admin/payment/many') ?>" method="post">
		<table class="table tablesorter">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo ___('payments.admin.table.token') ?></th>
					<th><?php echo ___('admin.table.details') ?></th>
					<th><?php echo ___('status') ?></th>
					<th><?php echo ___('admin.table.actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($payments as $payment): 
					if(!payment::is_registered_module($payment->module) 
						OR !payment::is_registered_provider($payment->method)) 
						continue;
					
					$payment_module = payment::load_payment_module(NULL, $payment);
					$payment_data = $payment_module->get_payment_data();
				?>
				<tr>
					<td><?php echo $payment->pk() ?></td>
					<td><?php echo $payment->token ?></td>
					<td>
						<div class="total_price">
							<label><?php echo ___('payments.total_price') ?>:</label>
							<?php echo $payment_module->show_price() ?>
						</div>

						<?php if($discount = Arr::get($payment_module->get_params(), 'discount', 0)): ?>
						<div class="discount">
							<label><?php echo ___('payments.discount') ?>:</label>
							<?php echo $discount ?> %
						</div>
						<?php endif; ?>

						<div class="provider">
							<label><?php echo ___('payments.forms.payment_method.label') ?>:</label> 
							<?php echo $payment_module->provider()->get_label() ?>
						</div>

						<div class="module"><label><?php echo Arr::get($payment_data, 'description'); ?></div>
						<div class="date_created">
							<label><?php echo ___('payments.date_created') ?></label> 
							<?php echo $payment->date_created ?>
						</div>
					</td>
					<td class="actions">
						<?php echo Model_Payment::status_to_text($payment->status) ?>

						<?php if($payment->status == Model_Payment::STATUS_NEW): ?>
						<div class="finish">
							<div><?php echo ___('payments.admin.status.finish') ?>:</div>
							<?php echo HTML::anchor('admin/payment/set_status/'.$payment->pk().'?status='.Model_Payment::STATUS_SUCCESS, ___('payments.admin.status.success')); ?>
							<?php echo HTML::anchor('admin/payment/set_status/'.$payment->pk().'?status='.Model_Payment::STATUS_ERROR, ___('payments.admin.status.error')); ?>
						</div>
						<?php endif; ?>
					</td>
					<td>
						<?php echo HTML::anchor(
							'admin/payment/delete/'.$payment->pk(),
							___('admin.table.delete'),
							array(
								'title' => ___('admin.delete.confirm'),
								'class' => 'confirm_delete',
							)); ?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>

	<?php echo $pager ?>

	<div id="confirmDelete"></div>
</div>