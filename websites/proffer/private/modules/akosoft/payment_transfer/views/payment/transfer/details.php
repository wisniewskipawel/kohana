<div id="payment_transfer_details">
	<div class="payment_title">
		<label><?php echo ___('transfer.details.payment_title') ?>:</label>
		<span><?php echo $payment_description ?></span>
	</div>

	<p><?php echo ___('transfer.details.info') ?>:</p>

	<div class="payment_details">
		
		<div class="bank_account_number">
			<label><?php echo ___('transfer.details.bank_account_number')?>:</label>
			<span><?php echo $bank_account_number ?></span>
		</div>

		<div class="transfer_title">
			<label><?php echo ___('transfer.details.transfer_title')?>:</label>
			<span><?php echo $transfer_title ?></span>
		</div>

		<div class="price">
			<label><?php echo ___('transfer.details.transfer_price')?>:</label>
			<span><?php echo $price ?></span>
		</div>

		<div class="address_information">
			<label><?php echo ___('transfer.details.address_information')?>:</label>
			<span><?php echo $address_information ?></span>
		</div>
		
	</div>
</div>