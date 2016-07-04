<?php if (count($ads)): ?>
<div id="sponsored-links" class="bottom_links">
	<div class="container">
		<span>Linki Sponsorowane: </span>
		<?php if (count($ads)): ?>
		<ul>
			<?php $i = 1; ?>
			<?php foreach ($ads as $ad): ?>
				<li <?php if ($i == count($ads)): ?>class="last"<?php endif ?>>
					<a href="<?php echo Route::url('site_ads/frontend/ads/go_to', array('id' => $ad->ad_id)) ?> " target="_blank" title="<?php echo HTML::chars($ad->ad_description) ?>"><?php echo $ad->ad_title ?></a>
				</li>
				<?php $i++ ?>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
	</div>
</div> <!-- end #sponsored-links -->
<?php endif; ?>

<div class="container">
	<?php echo ads::show(ads::PLACE_AC) ?>
</div>