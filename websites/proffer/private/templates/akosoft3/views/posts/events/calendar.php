<div class="events_calendar">
	<?php
	$next_month = mktime(0, 0, 0, $month + 1, 1, $year);
	$prev_month = mktime(0, 0, 0, $month - 1, 1, $year);
	?>
	
	<div class="calendar_caption">
		<div class="current_month">
			<?php echo Date::format(mktime(0, 0, 0, $month, 1, $year), '%B %Y') ?>
		</div>
	</div>
	
	<table class="calendar">
		<thead>
			<tr>
				<?php foreach (array(1,2,3,4,5,6,0) as $day): ?>
				<th><?php echo ___('date.days.abbr.'.$day) ?></th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($weeks as $week): ?>
			<tr>
				<?php foreach ($week as $day):

				$now = (int)date('Ymd');
				$current_day = (int)date('Ymd', $day['time']);
				
				$classes = array(
					$day['active_month'] ? 'is_active_month' : 'is_not_active_month',
					Arr::path($events, date('Y.m.d', $day['time'])) ? 'has_event' : '',
					$current_day == $now ? 'today' : '',
					$current_day < $now ? 'day_past' : '',
				);

				?>
				<td class="<?php echo implode(' ', $classes) ?>">
					<?php echo $day['number'] ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr>
				<td class="prev" colspan="3"><?php 
				echo HTML::anchor(
					Route::get('site_posts/frontend/events/index')->uri().URL::query(array(
						'year' => date('Y', $prev_month), 
						'month' => date('n', $prev_month)
					), FALSE), 
					'&laquo; '.Date::format($prev_month, '%B %Y')
				); 
				?></td>
				<td>&nbsp;</td>
				<td class="next" colspan="3"><?php 
				echo HTML::anchor(
					Route::get('site_posts/frontend/events/index')->uri().URL::query(array(
						'year' => date('Y', $next_month), 
						'month' => date('n', $next_month)
					), FALSE), 
					Date::format($next_month, '%B %Y').' &raquo;'
				);
				?></td>
			</tr>
		</tfoot>
	</table>

	<?php if(count($events)): ?>
	<div class="events">
		<?php foreach($events as $year => $events_year): ?>
		<?php foreach($events_year as $month => $events_month): ?>
		<?php foreach($events_month as $day => $events_day): ?>
		<div class="events_day">
			<div class="day_label"><?php echo Date::format(mktime(1, 0, 0, $month, $day, $year), '%d %B') ?></div>

			<ul class="events_list">
				<?php foreach($events_day as $event): ?>
				<li>
					<time datetime="<?php echo $event->date_event ?>"><?php echo date('H:i', strtotime($event->date_event)) ?></time>
					<?php echo HTML::anchor($event->get_uri(), $event->title) ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endforeach; ?>
		<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
