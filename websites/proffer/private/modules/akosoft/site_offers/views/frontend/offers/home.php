<div id="offers_index_box" class="box primary">
	<h2><?php echo ___('offers.boxes.home.title') ?></h2>
	<div class="box-content">
		
		<ul id="offers_index_tabs" class="box-actions">
			<li>
				<?php 
				echo HTML::anchor(
					Request::initial()->uri().URL::query(array('from' => NULL)),
					___('offers.boxes.home.promoted'),
					array(
						'class' => (!$from ? 'active': ''),
					)
				);
				?>
			</li>
			<li>
				<?php 
				echo HTML::anchor(
					Request::initial()->uri().URL::query(array('from' => 'recommended')),
					___('offers.boxes.home.recommended'),
					array(
						'class' => ($from == 'recommended' ? 'active': ''),
					)
				);
				?>
			</li>
		</ul>

		<div class="clearfix"></div>
		
		<div class="content">

			<?php echo View::factory('frontend/offers/_offers_list')
				->set('offers', $offers)
				->set('no_ads', TRUE) 
			?>

		</div>

	</div>
</div>