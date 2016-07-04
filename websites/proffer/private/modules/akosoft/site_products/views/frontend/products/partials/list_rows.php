<?php
$context = isset($context) ? $context : NULL;
if(empty($no_ads) AND Modules::enabled('site_ads')) $ad = ads::show(ads::PLACE_F);
?>
<?php if (count($products)): ?>
	<?php $i = 1; ?>
	<ul class="products_list list_rows <?php if($context == 'my' OR $context == 'closet') echo 'actions_list'; ?>">
		<?php 
		foreach ($products as $product): 
			$product_link = products::uri($product, TRUE);
		?>
			<li class="<?php if ($product->is_promoted()) echo 'promoted'; ?>">
				
				<?php if($context == 'my'): ?>
				<div class="entry_actions">
					<div class="pull-left">
						<?php 
						$days_left = $product->get_availability_days_left();
						
						echo $days_left > 0 ? ___('products.profile.my.list.days_left', $days_left, array(
							':days_left' => $days_left,
						)) : ___('products.profile.my.list.inactive') ?>
					</div>
					
					<ul class="actions pull-right">
						<li><a href="<?php echo Route::url('site_products/profile/products/edit', array('id' => $product->pk())) ?>"><?php echo ___('edit') ?></a></li>

						<?php if ($product->can_renew()): ?>
						<li><a href="<?php echo Route::url('site_products/profile/products/renew', array('id' => $product->pk())) ?>"><?php echo ___('prolong') ?></a></li>
						<?php endif; ?>

						<?php if ( ! $product->is_promoted()): ?>
							<li><a href="<?php echo Route::url('site_products/frontend/products/promote', array('product_id' => $product->pk())) . '?from=my' ?>"><?php echo ___('promote') ?></a></li>
						<?php endif ?>
						<li><a href="<?php echo Route::url('site_products/profile/products/delete', array('id' => $product->pk())) ?>"><?php echo ___('delete') ?></a></li>
						<li class="last"><a href="<?php echo Route::url('site_products/profile/products/statistics', array('id' => $product->pk())) ?>"><?php echo ___('statistics') ?></a></li>
					</ul>
				</div>
				<?php elseif($context == 'closet'): ?>
				<ul class="actions">
					<li><a href="<?php echo Route::url('site_products/frontend/products/send', array('id' => $product->pk())) ?>"><?php echo ___('share_friend') ?></a></li>
					<li><a href="<?php echo Route::url('site_products/profile/products/delete_from_closet', array('id' => $product->pk())) ?>"><?php echo ___('delete_from_closet') ?></a></li>
				</ul>
				<?php endif; ?>
				
				<div class="entry">
					
					<div class="image-wrapper">
						<a href="<?php echo $product_link ?>">
							<?php $image = $product->get_first_image(); if($image AND $image->exists('product_list')): ?>
							<?php echo HTML::image(
								$image->get_uri('product_list'),
								array('alt' => $product->product_title)
							) ?>
							<?php else: ?>
							<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
							<?php endif; ?>
						</a>
					</div>
					
					<div class="info">
						
						<div class="header">
							<h3>
								<a href="<?php echo $product_link ?>" tite="<?php echo HTML::chars($product->product_title) ?>">
									<?php echo Text::limit_chars($product->product_title, $context == 'company' ? 26 : 36, '...', TRUE) ?>
								</a>
							</h3>
							<div class="header_info">
								<span class="date_added">
									<label><?php echo ___('date_added') ?>:</label>
									<span><?php echo Date::my($product->product_date_added, 'product') ?></span>
								</span>
								
								<?php if($product->has_category()): ?>
									<span class="category">
										&verbar;
										<label><?php echo ___('category') ?>:</label> 
										<span><a href="<?php echo Route::url('site_products/frontend/products/category', array('category_id' => $product->last_category->pk(), 'title' => URL::title($product->last_category->category_name))) ?>"><?php echo $product->last_category->category_name ?></a>
									</span>
								<?php endif; ?>
									
								<?php if (Kohana::$config->load('modules.site_products.provinces_enabled') AND $product->product_province): ?>
									<span class="province">
										&verbar;
										<label><?php echo ___('province') ?>:</label>
										<span><?php echo Regions::province($product->product_province) ?></span>
									</span>
								<?php endif ?>
							</div>
						</div>
						
						<div class="content">
							<div class="description">
								<?php echo Text::limit_chars(strip_tags($product->product_content), 160, '...',TRUE) ?>
							</div>
							
							<a href="<?php echo $product_link ?>" class="more_btn"><?php echo ___('products.list.show_btn') ?></a>
						</div>
					</div>
				
					<div class="details">
						<div class="info_group_header">
							<?php if($context != 'my' && $context != 'closet' && $context != 'company'): ?>
							<?php if (!$product->is_promoted()): ?>
								<a class="first promote" href="<?php echo Route::url('site_products/frontend/products/promote', array('product_id' => $product->pk())) . '?from=list' ?>"><?php echo ___('products.list.promote') ?></a>
							<?php endif ?>
							<a class="closet" href="<?php echo Route::url('site_products/profile/products/add_to_closet', array('id' => $product->pk())) ?>"><?php echo ___('products.list.closet') ?></a>
							<?php endif; ?>
						</div>

						<div class="info_group">
							
							<?php if($product->product_price !== NULL): ?>
							<div class="price_side">
								<label><?php echo ___('price') ?>:</label>
								<span class="price">
									<?php echo payment::price_format($product->product_price, FALSE) ?>
									<span class="currency"><?php echo payment::currency() ?></span>
								</span>
							</div>
							<?php endif; ?>
							
						</div>
					</div>
					
				</div>
				
			</li>
			<?php if ($i == (round(count($products) / 2, 0)) AND ! empty($ad)): ?>
				<li class="banner">
					<?php echo $ad; ?>
				</li>
			<?php endif; ?>
			<?php $i++ ?>
		<?php endforeach ?>
	</ul>
<?php else: ?>
	<div class="no_results">
		<?php echo ___('products.list.no_results') ?>
	</div>
<?php endif ?>