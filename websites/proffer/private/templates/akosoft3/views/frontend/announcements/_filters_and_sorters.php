<?php
if(isset($filters_sorters))
{
	$filters = $filters_sorters;
}
else
{
	$filters = $session->get($name, array());
}

$provinces = Regions::provinces();

$show_clear_link = FALSE;
if ( ! empty($filters['type']) OR ! empty($filters['province']) OR ! empty($filters['city']))
{
	$show_clear_link = TRUE;
}

$current_uri = Request::current()->uri();

$filters_sorters['bar'] = (bool)Arr::get($_COOKIE, 'filters_bar', FALSE);
?>
<div class="toggle_visability_box <?php echo !$filters_sorters['bar'] ? "collapsed" : "expanded" ?>">
	<a href="#" class="toggle_visability_btn btn" data-toggle-text="<?php echo ___(!$filters_sorters['bar'] ? "toggle_visability_box.collapse" : "toggle_visability_box.expand") ?>"><?php echo ___($filters_sorters['bar'] ? "toggle_visability_box.collapse" : "toggle_visability_box.expand") ?></a>
	
	<div class="toggle_visability_target"<?php if(!$filters_sorters['bar']) echo ' style="display: none;"' ?>>
		<div class="filter_entries">
			<form action="" method="get" class="sort auto_submit_form">

				<fieldset class="view">
					<legend><?php echo ___('filters.view') ?>:</legend>

					<div class="control-group">
						<label><?php echo ___('filters.on_page') ?>:</label>
						<?php echo Form::select('on_page', array(20 => 20, 30 => 30, 50 => 50), Arr::get($filters, 'on_page', 20), array('class' => 'sort custom')) ?>
					</div>
				</fieldset>
				
				<?php if((in_array($name, array('category_filters', 'index_filters'))
						AND Kohana::$config->load('modules.site_announcements.sort_by_type')
					)
					OR $name == 'my_filters'
				): ?>
				<fieldset class="filters">
					<legend><?php echo ___('filters.title') ?>:</legend>

					<?php if(in_array($name, array('category_filters', 'index_filters'))
					AND Kohana::$config->load('modules.site_announcements.sort_by_type')): ?>
					<div class="control-group">
						<label><?php echo ___('announcements.filters.type') ?>:</label>
						<?php 
						$announcements_types = ORM::factory('Announcement_Type')->get_for_select();
						
						echo Form::select(
							'type', 
							$announcements_types, 
							Arr::get($filters, 'type', NULL), 
							array('class' => 'sort clearable custom')
						); ?>
					</div>
					<?php endif; ?>
					
					<?php if ($name == 'my_filters'): ?>
					<div class="control-group">
						<label><?php echo ___('status') ?>:</label>
						<?php echo Form::select('status', array(
							NULL => ___('select.choose'), 
							'active' => ___('status.active'), 
							'not_active' => ___('status.not_active'), 
						), Arr::get($filters, 'status', NULL), array('class' => 'sort clearable custom')) ?>
					</div>
					<?php endif ?>
				</fieldset>
				<?php endif ?>

				<?php if($name == 'category_filters' OR $name == 'index_filters'): ?>
				<fieldset class="localization">
					<legend><?php echo ___('filters.localization') ?>:</legend>

					<?php if (Kohana::$config->load('modules.site_announcements.map')): ?>
					<div class="province-field-row control-group">
						<label><?php echo ___('province') ?>:</label>
						<?php echo Form::select('province', Arr::unshift($provinces, NULL, '---'), Arr::get($filters, 'province', NULL), array('class' => 'sort clearable custom')) ?>
					</div>

					<div class="county-field-row control-group">
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

					<div id="city-field-row" class="control-group">
						<label><?php echo ___('city') ?>:</label>
						<?php  echo Form::input('city', Arr::get($filters, 'city'), array('class' => 'sort clearable')) ?>
					</div>

					<div class="control-group buttons">

						<?php if ($show_clear_link): ?>
						<a href="<?php echo URL::site($current_uri) ?>" class="clear_btn"><?php echo ___('filters.clear') ?></a>
						<?php else: ?>
						<input type="submit" value="<?php echo ___('form.show') ?>" />
						<?php endif ?>
						
					</div>

				</fieldset>
				<?php endif; ?>

				<?php foreach(Arr::extract($filters, array('sort_by', 'sort_direction', 'from')) as $name => $value)
					if(!empty($value)) echo Form::hidden($name, $value) ?>
			</form>

		</div>

		<?php if (isset($category) && !empty($category->category_text)): ?>
			<div class="category-text">
				<?php echo $category->category_text ?>
			</div>
		<?php endif ?>

		<?php
		$filters['sort_by'] = Arr::get($filters, 'sort_by');
		$filters['sort_direction'] = Arr::get($filters, 'sort_direction', 'asc');
		?>
		<div class="sorting">
			<label><?php echo ___('sort') ?>:</label>

			<?php if ($name == 'closet_filters'): ?>
			<div class="sort_type">
				<label><?php echo ___('announcements.sort.closet') ?></label>
				<a class="asc sort <?php if ($filters['sort_by'] === "closet" AND $filters['sort_direction'] == 'asc'): ?> active <?php endif ?>" href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => 'closet', 'sort_direction' => 'asc')) ?>"></a>
				<a class="desc sort <?php if ($filters['sort_by'] === "closet" AND $filters['sort_direction'] == 'desc'): ?> active <?php endif ?>"href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => 'closet', 'sort_direction' => 'desc')) ?>"></a>
			</div>
			<?php endif ?>

			<div class="sort_type">
				<label><?php echo ___('price') ?></label>
				<a class="asc sort <?php if ($filters['sort_by'] === "price" AND $filters['sort_direction'] == 'asc'): ?> active <?php endif ?>" href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => 'price', 'sort_direction' => 'asc')) ?>"></a>
				<a class="desc sort <?php if ($filters['sort_by'] === "price" AND $filters['sort_direction'] == 'desc'): ?> active <?php endif ?>" href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => 'price', 'sort_direction' => 'desc')) ?>"></a>
			</div>

			<div class="sort_type">
				<label><?php echo ___('date_added') ?></label>
				<a class="asc sort <?php if ($filters['sort_by'] === "date_added" AND $filters['sort_direction'] == 'asc'): ?> active <?php endif ?>" href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => 'date_added', 'sort_direction' => 'asc')) ?>"></a>
				<a class="desc sort <?php if ($filters['sort_by'] === "date_added" AND $filters['sort_direction'] == 'desc'): ?> active <?php endif ?>" href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => 'date_added', 'sort_direction' => 'desc')) ?>"></a>
			</div>

			<?php if(!empty($filters['sort_by']) && $filters['sort_by'] !== TRUE): ?>
			<a href="<?php echo URL::site($current_uri).URL::query(array('sort_by' => NULL, 'sort_direction' => NULL)) ?>" class="clear-sort"><?php echo ___('sort.clear') ?></a>
			<?php endif ?>
		</div>
	</div>
</div>
