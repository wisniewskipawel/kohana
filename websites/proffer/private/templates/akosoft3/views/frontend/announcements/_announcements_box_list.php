<ul class="announcements_list_box">
	<?php foreach ($announcements as $a): 
		$announcement_link = announcements::url($a);
	?>
		<li>
			<div class="image-wrapper">
				<a href="<?php echo $announcement_link ?>">
					<?php $image = $a->get_images(1); if($image AND $image->exists('announcement_list')): ?>
					<?php 
					echo HTML::image(
						$image->get_uri('announcement_list'),
						array('alt' => $a->annoucement_title)
					);
					?>
					<?php else: ?>
					<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo">
					<?php endif; ?>
				</a>
			</div>
			<div class="info">
				<h3>
					<a href="<?php echo $announcement_link ?>" title="<?php echo HTML::chars($a->annoucement_title) ?>"><?php echo Text::limit_chars($a->annoucement_title, 40, '...') ?></a>
				</h3>
				<div class="meta">
					<?php if($a->has_category()): ?>
					<div class="category">
						<a href="<?php echo Route::url('site_announcements/frontend/announcements/category', array('category_id' => $a->last_category->pk(), 'title' => URL::title($a->last_category->category_name))) ?>"><?php echo $a->last_category->category_name ?></a>
					</div>
					<?php endif; ?>
					
					<?php if($a->can_show_price()): ?>
					<div class="price_side">
						<?php echo payment::price_format($a->annoucement_price, FALSE) ?>
						<span class="currency"><?php echo payment::currency() ?></span>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</li>
	<?php endforeach ?>
</ul>