<h2><?php echo ___('newsletter.admin.show.title') ?></h2>

<div class="box">
	<p style="margin-bottom: 20px;"><strong><?php echo ___('subject') ?>:</strong></p>

	<p style="margin-bottom: 15px;"><?php echo $letter->letter_subject ?></p>

	<p style="margin-bottom: 20px;"><strong><?php echo ___('message') ?>:</strong></p>

	<div>
		<?php echo $letter->letter_message ?>
	</div>
</div>