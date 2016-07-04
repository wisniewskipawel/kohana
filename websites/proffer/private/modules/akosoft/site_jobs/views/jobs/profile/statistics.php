<div class="box primary">
	<h2><?php echo ___('jobs.profile.statistics.title') ?></h2>
	<div class="content">
		<p>
			<?php echo ___('visits') ?>: <?php echo $job->visits ?>
		</p>
		<p>
			<?php echo ___('date_added') ?>: <?php echo date('d.m.Y', strtotime($job->date_added)) ?>
		</p>
		<p>
			<?php echo ___('date_availability') ?>: <?php echo date('d.m.Y', strtotime($job->date_availability)) ?>
		</p>
	</div>
</div>