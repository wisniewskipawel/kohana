<div class="company_hours_field">
	<?php 
	$values = $driver->get_value();
	
	foreach($driver->get_days() as $day => $label): ?>
	<div class="days day_<?php echo $day ?>">
		<span class="day_of_week"><?php echo $label ?>:</span>
		<?php echo Form::select(
			$driver->html('name').'['.$day.'][open]', 
			array(TRUE => ___('catalog.forms.company_hours.open.1'), FALSE => ___('catalog.forms.company_hours.open.0')),
			(int)Arr::path($values, array($day, 'open'), Model_Catalog_Company::COMPANY_HOURS_OPEN),
			array(
				'class' => $driver->html('class').' is_open',
			)
		) ?>
		<span>
			<label class="from">
				<?php echo ___('form.range.from') ?>: 
				<?php echo Form::input(
					$driver->html('name').'['.$day.'][from]', 
					Arr::path($values, array($day, 'from')), 
					array(
						'list' => 'hours_list',
						'class' => $driver->html('class'),
					)) ?>
			</label>
			<label class="to">
				<?php echo ___('form.range.to') ?>: 
				<?php echo Form::input(
					$driver->html('name').'['.$day.'][to]', 
					Arr::path($values, array($day, 'to')), 
					array(
						'list' => 'hours_list',
						'class' => $driver->html('class'),
					)) ?>
			</label>
		</span>
	</div>
	<?php endforeach; ?>

	<datalist id="hours_list">
		<?php for($i=0; $i < 24; $i++): ?>
		<option value="<?php echo $i ?>">
		<?php endfor; ?>
	</datalist>
	
	<script type="text/javascript">
	$(function() {
		
		$('.company_hours_field select.is_open').on('change', change_is_open).each(change_is_open);
		
		function change_is_open() {
			var $is_open = $(this);
			
			if($is_open.val() == 1) {
				$is_open.next().show();
			} else {
				$is_open.next().hide();
			}
		}
	});
	</script>
</div>