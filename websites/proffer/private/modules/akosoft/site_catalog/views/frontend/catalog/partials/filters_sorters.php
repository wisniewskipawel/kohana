<?php
$current_uri = Request::current()->uri();
if(!isset($context))
	$context = 'list';

$filters_sorters['bar'] = (bool)Arr::get($_COOKIE, 'filters_bar', FALSE);
?>
<div class="toggle_visability_box <?php echo !$filters_sorters['bar'] ? "collapsed" : "expanded" ?>">
	<a href="#" class="toggle_visability_btn btn" data-toggle-text="<?php echo ___(!$filters_sorters['bar'] ? "toggle_visability_box.collapse" : "toggle_visability_box.expand") ?>"><?php echo ___($filters_sorters['bar'] ? "toggle_visability_box.collapse" : "toggle_visability_box.expand") ?></a>
	
	<div class="filter_entries toggle_visability_target"<?php if(!$filters_sorters['bar']) echo ' style="display: none;"' ?>>
		<form action="" method="get" class="sort auto_submit_form">

			<fieldset class="view">
				<legend><?php echo ___('filters.view') ?>:</legend>

				<div class="control-group">
					<label><?php echo ___('filters.on_page') ?>:</label>
					<?php echo Form::select('on_page', array(20 => 20, 30 => 30, 50 => 50), Arr::get($filters_sorters, 'on_page', 20), array('class' => 'sort custom')) ?>
				</div>
			</fieldset>

			<?php if($context == 'list'): ?>
			<fieldset class="filters">
				<legend><?php echo ___('filters.title') ?></legend>

				<?php 
				if (Kohana::$config->load('modules.site_catalog.map')): 
					$provinces = Regions::provinces();
				?>
				<div class="control-group">
					<label><?php echo ___('province') ?>:</label>
					<?php echo Form::select(
						'province', 
						Arr::unshift($provinces, NULL, '---'), 
						Arr::get($filters_sorters, 'province'), 
						array('class' => 'sort clearable custom')
					) ?>
				</div>
				
				<div class="control-group">
					<label><?php echo ___('county') ?>:</label>
					<?php 
					$counties = !empty($filters_sorters['province']) ? 
						Regions::counties($filters_sorters['province']) : array();
					
					$counties = $counties ? $counties : array();
					
					echo Form::select(
						'county', 
						Arr::unshift($counties, NULL, '---'), 
						Arr::get($filters_sorters, 'county'), 
						array('class' => 'sort clearable custom counties')
					) ?>
				</div>
				<?php endif ?>

				<div class="control-group">
					<label><?php echo ___('city') ?>:</label>
					<?php  echo Form::input('city', Arr::get($filters_sorters, 'city'), array('class' => 'sort clearable')) ?>
				</div>

				<div class="control-group">
					<?php if (!empty($filters_sorters['city']) || !empty($filters_sorters['province'])): ?>
					<a href="<?php echo URL::site($current_uri) ?>" class="clear_btn"><?php echo ___('filters.clear') ?></a>
					<?php else: ?>
					<input type="submit" value="<?php echo ___('form.show') ?>" />
					<?php endif ?>
				</div>

				<div class="control-group">
				</div>

			</fieldset>
			<?php endif; ?>

		</form>
	</div>
</div>