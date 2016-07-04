<div id="posts_events_box" class="box">
	<div class="box-header">
		<?php echo ___('posts.boxes.events.title') ?>
		
		<?php echo HTML::anchor(
			Route::get('site_posts/frontend/events/add')->uri(),
			___('posts.events.add.btn'),
			array(
				'class' => 'add_event_btn more_btn',
			)
		); ?>
	</div>
	<div class="content">
		
		<div class="events_calendar_container">
			<?php echo $widget->render_events_calendar() ?>
		</div>
		
		<script>
		$(function() {
			$('.events_calendar_container').on('click', '.calendar a', function(e) {
				e.preventDefault();
				
				$.ajax({
					url: this.href,
					success: function(data) {
						$('.events_calendar_container').html(data);
					}
				});
			});
		});
		</script>
		
	</div>
</div>