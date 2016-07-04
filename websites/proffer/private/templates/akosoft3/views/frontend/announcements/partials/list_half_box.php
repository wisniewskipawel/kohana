<ul class="announcements-list-half entries_list">
	<?php foreach ($announcements as $a): 
		$announcement_link = announcements::url($a);
	?>
		<li class="entry_list_item">
			<a class="image_box pull-left" href="<?php echo $announcement_link ?>">
				<?php $image = $a->get_images(1); if($image AND img::image_exists('announcements', 'announcement_list', $image['image_id'], $image['image'])): ?>
				<img src="<?php echo img::path('announcements', 'announcement_list', $image['image_id'], $image['image']) ?>" alt="" class="entry_list_item-object" />
				<?php else: ?>
				<img src="<?php echo URL::site('/media/img/no_photo.jpg'); ?>" alt="" class="no-photo" class="entry_list_item-object" />
				<?php endif; ?>
			</a>
			
			<div class="entry_list_item-body">
				<h4 class="entry_list_item-heading title">
					<a href="<?php echo $announcement_link ?>" title="<?php echo HTML::chars($a->annoucement_title) ?>"><?php echo HTML::chars($a->annoucement_title) ?></a>
				</h4>
				
				<div class="price_side">
					<?php echo ___('price') ?>: 
					<span class="price"><?php echo payment::price_format($a->annoucement_price) ?></span>
				</div>
				
				<div class="details">
					<div class="date_added">
						<?php echo ___('date_added') ?>: <?php echo Date::my($a->annoucement_date_added) ?>
					</div>

					<?php if($a->has_category()): ?>
					<div class="category">
						<?php echo ___('category') ?>: 
						<a href="<?php echo Route::url('site_announcements/frontend/announcements/category', array('category_id' => $a->last_category->pk(), 'title' => URL::title($a->last_category->category_name))) ?>"><?php echo Text::limit_chars($a->last_category->category_name, 20, '...') ?></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</li>
   <?php endforeach; ?>
</ul>