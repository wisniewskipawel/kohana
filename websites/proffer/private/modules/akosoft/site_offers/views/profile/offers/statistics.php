<div class="box primary">
	<h2><?php echo ___('offers.profile.statistics.title') ?></h2>
	<div class="content">
		<p>
			<?php echo ___('offers.profile.statistics.offer_visits') ?>: <?php echo $offer->offer_visits ?>
		</p>
		<p>
			<?php echo ___('date_added') ?>: <?php echo date('d.m.Y', strtotime($offer->offer_date_added)) ?>
		</p>
		<p>
			<?php echo ___('date_availability') ?>: <?php echo date('d.m.Y', strtotime($offer->offer_availability)) ?>
		</p>
	</div>
</div>