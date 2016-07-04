<?php
$context = isset($context) ? $context : NULL;
if(empty($no_ads) AND Modules::enabled('site_ads')) $ad = ads::show(ads::PLACE_F);
?>
<?php if (count($announcements)): ?>
<?php $i = 1; ?>
<ul class="announcements_list actions_list entries_list">
	<?php 
	foreach ($announcements as $a): 
		$announcement_link = announcements::url($a);
	?>
	<li class="entry_list_item <?php if ($a->is_promoted()) echo 'promoted'; elseif($a->is_distinct()) echo 'distinct'; ?>">

		<div class="entry_actions">
			<?php if($context == 'my'): ?>
			<div class="pull-left">
				<?php 
				$days_left = $a->get_availability_days_left();

				echo ($days_left > 0 AND $a->is_approved()) ? ___('announcements.profile.my.list.days_left', $days_left, array(
					':days_left' => $days_left,
				)) : ___('announcements.profile.my.list.inactive') ?>
			</div>

			<ul class="actions pull-right">
				<li><a href="<?php echo Route::url('site_announcements/profile/announcements/edit', array('id' => $a->annoucement_id)) ?>"><?php echo ___('edit') ?></a></li>
				<?php if ($a->can_renew()): ?>
				<li><a href="<?php echo Route::url('site_announcements/profile/announcements/renew', array('id' => $a->annoucement_id)) ?>"><?php echo ___('prolong') ?></a></li>
				<?php endif; ?>
				<?php if (announcements::is_distinction_enabled(TRUE) AND !$a->is_promoted()): ?>
					<li><a href="<?php echo Route::url('site_announcements/frontend/announcements/promote', array('announcement_id' => $a->annoucement_id)) . '?from=my' ?>"><?php echo ___('promote') ?></a></li>
				<?php endif ?>
				<li><a href="<?php echo Route::url('site_announcements/profile/announcements/delete', array('id' => $a->annoucement_id)) ?>"><?php echo ___('delete') ?></a></li>
				<li class="last"><a href="<?php echo Route::url('site_announcements/profile/announcements/statistics', array('id' => $a->annoucement_id)) ?>"><?php echo ___('statistics') ?></a></li>
			</ul>
			<?php elseif($context == 'closet'): ?>
			<ul class="actions">
				<li><a href="<?php echo Route::url('site_announcements/frontend/announcements/send', array('id' => $a->annoucement_id)) ?>"><?php echo ___('share_friend') ?></a></li>
				<li><a href="<?php echo Route::url('site_announcements/profile/announcements/delete_from_closet', array('id' => $a->annoucement_id)) ?>"><?php echo ___('delete') ?></a></li>
			</ul>
			<?php endif; ?>
		</div>

		<div class="entry">

			<div class="entry_list_item-side">
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
				
				<div class="date_added info-entry">
					<span class="info-label"><?php echo ___('date_added') ?>:</span>
					<span class="info-val"><?php echo date('d.m.Y', strtotime($a->annoucement_date_added)) ?></span>
				</div>
			</div>

			<div class="entry_list_item-body">

				<div class="header">
					<h4 class="entry_list_item-heading">
						<a href="<?php echo $announcement_link ?>" tite="<?php echo HTML::chars($a->annoucement_title) ?>">
							<?php echo Text::limit_chars($a->annoucement_title, $context == 'company' ? 26 : 36, '...', TRUE) ?>
						</a>
					</h4>
							
					<div class="header_info info-entries">
								
						<?php if($a->has_category()): ?>
						<span class="category info-entry">
							<a href="<?php echo Route::url(
								'site_announcements/frontend/announcements/category', 
								array('category_id' => $a->last_category->pk(), 'title' => URL::title($a->last_category->category_name))
							) ?>" class="info-val"><?php echo $a->last_category->category_name ?></a>
						</span>
						<?php endif; ?>
					
						<?php if($a->can_show_price()): ?>
						<div class="price_side info-entry">
							<span><?php echo ___('price') ?>:</span>
							<span class="price">
								<?php echo payment::price_format($a->annoucement_price, FALSE) ?>
								<span class="currency"><?php echo payment::currency() ?></span>
							</span>
						</div>
						<?php endif; ?>
						
						<?php if($location = $a->contact_data()->address->render('list_short')): ?>
						<div class="location info-entry">
							<i class="glyphicon glyphicon-map-marker"></i> <?php echo $location ?>
						</div>
						<?php endif; ?>
								
						<div class="pull-right">
							<span class="actions info-entry">

								<?php if($current_user AND $a->user_id == $current_user->pk()): ?>

								<?php if (announcements::is_distinction_enabled(TRUE) AND !$a->is_promoted()): ?>
								<a href="<?php echo Route::url('site_announcements/frontend/announcements/promote', array(
									'announcement_id' => $a->annoucement_id,
									)) . '?from=my' ?>" title="<?php echo ___('promote') ?>"><i class="glyphicon glyphicon-ok"></i></a>
								<?php endif ?>

								<a href="<?php echo Route::url('site_announcements/frontend/announcements/dig_up', array(
									'id' => $a->annoucement_id,
								)) . '?from=my' ?>" title="<?php echo ___('announcements.list.digup') ?>"><i class="glyphicon glyphicon-arrow-up"></i></a>

								<?php else: ?>

								<a href="<?php echo Route::url('site_announcements/profile/announcements/add_to_closet', array(
									'id' => $a->annoucement_id,
								)) ?>" title="<?php echo ___('announcements.list.closet') ?>"><i class="glyphicon glyphicon-folder-open"></i></a>

								<?php endif; ?>

							</span>
						</div>

					</div>
				</div>

				<div class="content">
					<div class="description">
						<?php echo Text::limit_chars(strip_tags($a->annoucement_content), 160, '...',TRUE) ?>
					</div>
					<a href="<?php echo $announcement_link ?>" class="more_btn"><?php echo ___('announcements.list.show') ?> &raquo;</a>
				</div>
			</div>

		</div>

	</li>
	<?php if ($i == (round(count($announcements) / 2, 0)) AND ! empty($ad)): ?>
	<li class="banner">
		<?php echo $ad; ?>
	</li>
	<?php endif; ?>
	<?php $i++ ?>
	<?php endforeach ?>
</ul>
<?php else: ?>
	<div class="no_results">
		<?php echo ___('announcements.list.no_results') ?>
	</div>
<?php endif ?>
