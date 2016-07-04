<h2><?php echo ___('ads.adsystem.index.title') ?></h2>

<div class="box">

	<table class="table">
		<tr>
			<th>#</th>
			<th><?php echo ___('ad_title') ?></th>
			<th><?php echo ___('ad_clicks_count') ?></th>
			<th><?php echo ___('ad_display_count') ?></th>
		</tr>
		<?php foreach ($ads as $a): ?>
			<tr>
				<td><?php echo $a->ad_id ?></td>
				<td><?php echo $a->ad_title ?></td>
				<td><?php echo $a->ad_clicks_count ?></td>
				<td><?php echo $a->ad_display_count ?></td>
			</tr>
		<?php endforeach ?>
	</table>

</div>