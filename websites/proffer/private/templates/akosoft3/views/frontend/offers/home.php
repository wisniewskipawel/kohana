<div id="offers_index_box" class="box">
	<div class="box-header">
		<span class="box-header-title"><?php echo ___('offers.boxes.home.title') ?></span>

		<span class="box-tabs">
			<?php 
			echo HTML::anchor(
				Request::initial()->uri().URL::query(array('from' => NULL)),
				___('offers.boxes.home.promoted'),
				array(
					'class' => (!$from ? 'active': ''),
				)
			);
			?>
			<?php 
			echo HTML::anchor(
				Request::initial()->uri().URL::query(array('from' => 'recommended')),
				___('offers.boxes.home.recommended'),
				array(
					'class' => ($from == 'recommended' ? 'active': ''),
				)
			);
			?>
		</span>
	</div>
	
	<div class="content">

		<?php echo View::factory('frontend/offers/_offers_list')->set('offers', $offers) ?>

	</div>

</div>