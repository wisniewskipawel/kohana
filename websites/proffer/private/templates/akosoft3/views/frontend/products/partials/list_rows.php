<?php
$context = isset($context) ? $context : NULL;
if(empty($no_ads) AND Modules::enabled('site_ads')) $ad = ads::show(ads::PLACE_F);
?>
<?php if(count($products)): $i = 0; ?>
<ul class="products_listing_default <?php if($context == 'my' OR $context == 'closet') echo 'actions_list'; ?>">
	<?php foreach ($products as $product): 
		$product_uri = products::uri($product);
		$product_link = URL::site($product_uri);
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

			<div class="entry_list_item-side">
				<div class="image-wrapper">
					<?php 
					$image = $product->get_first_image();

					echo HTML::anchor($product_uri, 
						HTML::image(($image AND $image->exists('product_list')) ? $image->get_uri('product_list') : 'media/img/no_photo.jpg'),
						array('class' => 'image_box')
					); ?>
				</div>
			</div>

			<div class="entry_list_item-body">

				<div class="header">
					<h4 class="entry_list_item-heading">
						<?php echo HTML::anchor($product_uri, $product->product_title, array(
							'title' => $product->product_title,
						)) ?>
					</h4>
							
					<div class="header_info info-entries">
						
						<?php if($product->product_manufacturer): ?>
						<span class="manufacturer info-entry">
							<span class="info-label"><?php echo ___('products.forms.product_manufacturer') ?>:</span>
							<span class="info-value"><?php echo HTML::chars($product->product_manufacturer) ?></span>
						</span>
						<?php endif; ?>
						
						<div class="price_side info-entry">
							<span class="info-label"><?php echo ___('price') ?>:</span>
							<span class="info-value price">
								<?php echo payment::price_format($product->product_price, FALSE) ?>
								<span class="currency"><?php echo payment::currency() ?></span>
							</span>
						</div>

						<div class="type_state info-entry">
							<span class="info-label type"><?php echo Arr::get(Products::types(), $product->product_type) ?>:</span>
							<span class="info-value state"><?php echo Arr::get(Products::states(), $product->product_state) ?></span>
						</div>
								
						<div class="pull-right">
							<span class="actions info-entry">

								<a href="<?php echo Route::url('site_products/profile/products/add_to_closet', array(
									'id' => $product->pk(),
								)) ?>" title="<?php echo ___('profile.closet') ?>"><i class="glyphicon glyphicon-folder-open"></i></a>

							</span>
						</div>

					</div>
				</div>

				<div class="content">
					<div class="description">
						<?php echo Text::limit_chars(strip_tags($product->product_content), 100, '...', TRUE) ?>
					</div>
					
					<section class="buttons">
						<?php if($product->has_company()): ?>
						<?php echo HTML::anchor(Route::get('site_products/frontend/products/show_by_company')->uri(array(
							'company_id' => $product->catalog_company->pk(),
						)), ___('products.list.company_products_btn'), array('class' => 'company_products_btn')) ?>
						<?php endif; ?>
						
						<?php echo HTML::anchor($product_uri, ___('products.list.see_more_btn'), array('class' => 'see_more_btn button')) ?>
					</section>
					
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
<?php endif; ?>
