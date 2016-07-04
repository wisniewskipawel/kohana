<?php 
$event_link = URL::site($event->get_uri(), 'http');
?>
<div id="event_show_box" class="box primary" itemscope itemtype="http://data-vocabulary.org/Event">
	<h2 itemprop="summary"><?php echo HTML::chars($event->title) ?></h2>
	<div class="box-content">
		
		<div class="details">
			
			<span class="date_event">
				<?php echo ___('posts.events.date_event') ?>: 
				<time itemprop="startDate" datetime="<?php echo $event->date_event ?>"><?php echo date('Y-m-d H:i', strtotime($event->date_event)) ?></time>
			</span>
			
			<?php if($event->location): ?>
			<span class="location">
				<?php echo ___('posts.events.location') ?>: 
				<span itemprop="location"><?php echo HTML::chars($event->location) ?></span>
			</span>
			<?php endif; ?>
			
			<span class="date_added">
				<?php echo ___('posts.events.added') ?>:
				<time datetime="<?php echo $event->date_added ?>"><?php echo Date::fuzzy_span(strtotime($event->date_added)) ?></time>
			</span>
			
		</div>
		
		<?php 
		$image_lead = $event->get_images(1, 'event_lead');
		
		if($image_lead && img::image_exists('events', 'event_lead', $image_lead['image_id'], $image_lead['image'])): ?>
		<div class="lead_image">
			<div class="image-wrapper">
				<img src="<?php echo img::path('events', 'event_lead', $image_lead['image_id'], $image_lead['image']) ?>" alt="<?php echo HTML::chars($event->title) ?>" itemprop="photo" />
			</div>
		</div>
		<?php endif; ?>
		
		<div class="content text" itemprop="description">
			<?php echo $event->content;?>
		</div>
		
		<div class="meta">
			
			<div class="share pull-left">
				<label><?php echo ___('share') ?>:</label>
				<?php
				$share = new Share(
					$event_link, 
					$event->title
				);
				
				if($image_lead && img::image_exists('events', 'event_lead', $image_lead['image_id'], $image_lead['image']))
					$share->add_image(URL::site(img::path_uri('events', 'event_lead', $image_lead['image_id'], $image_lead['image']), 'http'));
						
				echo $share->render();
				?>
			</div>
		</div>
		
		<?php 
		if(Posts::config('events.comments.enabled'))
		{
			echo Widget_Box::factory('events/comments', array(
				'event' => $event,
				'order' => $current_request->query('c_order'),
				'view' => $current_request->query('c_view'),
			))->render();
		}
		?>
		
	</div>
</div>
