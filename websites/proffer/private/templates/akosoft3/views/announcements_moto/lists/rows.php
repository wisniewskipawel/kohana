<?php 
$announcements->load_attributes();

$context = isset($context) ? $context :NULL;

if (count($announcements)): 
	$ad = (!empty($show_ads) AND Modules::enabled('site_ads')) ? ads::show(ads::PLACE_F) : NULL;
?>
	<?php $i = 1; ?>
	<ul class="announcements_list actions_list">
		<?php 
		foreach ($announcements as $a): 
			$announcement_link = URL::site($a->get_uri());
			$attributes = $a->get_fields();
		?>
		<li class="<?php if($a->is_promoted()) echo 'promoted'; elseif($a->is_distinct()) echo 'distinct'; ?>">
			<?php if($context == 'my'): ?>
			<div class="entry_actions">
				<div class="pull-left">
					<?php 
					$days_left = $a->get_availability_days_left();

					echo $days_left > 0 ? $current_module->trans('profile.my.list.days_left', $days_left, array(
						':days_left' => $days_left,
					)) : $current_module->trans('profile.my.list.inactive') ?>
				</div>
				
				<ul class="actions pull-right">
					<li><a href="<?php echo $current_module->route_url('profile/announcements/edit', array('id' => $a->annoucement_id)) ?>"><?php echo ___('edit') ?></a></li>
					<?php if ($a->can_renew()): ?>
					<li><a href="<?php echo $current_module->route_url('profile/announcements/renew', array('id' => $a->annoucement_id)) ?>"><?php echo ___('prolong') ?></a></li>
					<?php endif; ?>
					<?php if ( ! $a->is_promoted()): ?>
						<li><a href="<?php echo $current_module->route_url('frontend/announcements/promote', array('announcement_id' => $a->annoucement_id)) . '?from=my' ?>"><?php echo ___('promote') ?></a></li>
					<?php endif ?>
					<li><a href="<?php echo $current_module->route_url('profile/announcements/delete', array('id' => $a->annoucement_id)) ?>"><?php echo ___('delete') ?></a></li>
					<li class="last"><a href="<?php echo $current_module->route_url('profile/announcements/statistics', array('id' => $a->annoucement_id)) ?>"><?php echo ___('statistics') ?></a></li>
				</ul>
			</div>
			<?php elseif($context == 'closet'): ?>
			<div class="entry_actions">
				<ul class="actions">
					<li><a href="<?php echo $current_module->route_url('frontend/announcements/send', array('id' => $a->annoucement_id)) ?>"><?php echo ___('share_friend') ?></a></li>
					<li><a href="<?php echo $current_module->route_url('profile/announcements/delete_from_closet', array('id' => $a->annoucement_id)) ?>"><?php echo ___('delete') ?></a></li>
				</ul>
			</div>
			<?php endif; ?>
			<div class="entry">
				<div class="left">
					<div class="photo image-wrapper">
						<a href="<?php echo $announcement_link ?>">
							<?php $image = $a->get_images(1); if(!empty($image) && $image->exists('announcement_list')): ?>
							<img src="<?php echo $image->get_url('announcement_list') ?>" alt="" />
							<?php else: ?>
							<img src="<?php echo URL::site('/media/img/no_photo.jpg'); ?>" alt="" class="announcement-photo no-photo" />
							<?php endif; ?>
						</a>
					</div>
					<div class="date_added">
						<?php echo $current_module->trans('list.date_added') ?>: 
						<?php echo date('d.m.Y', strtotime($a->annoucement_date_added)) ?>
					</div>
				</div>
				<div class="right">
					<h1>
						<a href="<?php echo $announcement_link ?>" title="<?php echo HTML::chars($a->annoucement_title) ?>">
							<?php echo HTML::chars($a->annoucement_title) ?>
						</a>
					</h1>
					
					<div class="header_info info-entries">

						<?php if($a->annoucement_price): ?>
						<div class="price_side info-entry">
							<span><?php echo ___('price') ?>:</span>
							<span class="price">
								<?php echo payment::price_format($a->annoucement_price, FALSE) ?>
								<span class="currency"><?php echo payment::currency() ?></span>
							</span>
						</div>
						<?php endif; ?>

						<?php if($location = $a->get_contact()->address->render('list_short')): ?>
						<div class="location info-entry">
							<i class="glyphicon glyphicon-map-marker"></i> <?php echo $location ?>
						</div>
						<?php endif; ?>

						<div class="pull-right">
							<span class="actions info-entry">

								<?php if($current_user AND $a->user_id == $current_user->pk()): ?>

								<?php if (!$a->is_promoted()): ?>
								<a href="<?php echo $current_module->route_url('frontend/announcements/promote', array(
									'announcement_id' => $a->annoucement_id,
									)) . '?from=my' ?>" title="<?php echo ___('promote') ?>"><i class="glyphicon glyphicon-ok"></i></a>
								<?php endif ?>

								

								<?php else: ?>
								
								<a class="closet" href="<?php echo $current_module->route_url('profile/announcements/add_to_closet', array(
									'id' => $a->pk(),
								)) ?>" title="<?php echo $current_module->trans('list.closet') ?>"><i class="glyphicon glyphicon-folder-open"></i></a>
								
								<?php endif; ?>

							</span>
						</div>

					</div>
					
					<?php if($attributes): ?>
					<ul class="params">
						<?php $year = $attributes->get('year', TRUE); if($year AND $year->display_value()): ?>
						<li><?php echo $year->label() ?>: <strong><?php echo $year->display_value() ?></strong></li>
						<?php endif; ?>

						<?php $gas_type = $attributes->get('gas_type', TRUE); if($gas_type AND $gas_type->display_value()): ?>
						<li><strong><?php echo $gas_type->display_value() ?></strong></li>
						<?php endif; ?>

						<?php $body_type = $attributes->get('body_type', TRUE); if($body_type AND $body_type->display_value()): ?>
						<li><strong><?php echo $body_type->display_value() ?></strong></li>
						<?php endif; ?>

						<?php $mileage = $attributes->get('mileage', TRUE); if($mileage AND $mileage->display_value()): ?>
						<li><?php echo $mileage->label() ?>: <strong><?php echo $mileage->display_value() ?></strong></li>
						<?php endif; ?>
					</ul>
					<?php endif; ?>
					
					<div class="description">
						<?php echo $a->get_description_short(100); ?>
					</div>
				</div>
			</div>
		</li>
		<?php if ($i == (round(count($announcements) / 2, 0)) AND ! empty($ad)): ?>
		<li class="banner">
			<?php echo $ad ?>
		</li>
		<?php endif; ?>
		<?php $i++ ?>
		<?php endforeach ?>
	</ul>
<?php else: ?>
	<div class="no_results">
		<?php echo $current_module->trans('advanced_search.no_results') ?>
	</div>
<?php endif ?>