<?php if($count_products = count($products)):
$i = 0;
if(empty($no_ads) AND Modules::enabled('site_ads'))
{
	$ad = ads::show(ads::PLACE_F);
	$count_rows = (round(round($count_products / 2) / 2, 0));
}
?>
<ul class="products_list list_box">
	<?php foreach($products as $product): 
		$product_link = products::uri($product);
	?>
	<li class="<?php if ($product->is_promoted()) echo 'promoted'; ?>">

		<section class="header">
			<div class="title_side">
				<h4 class="title">
					<?php echo HTML::anchor($product_link, Text::limit_chars($product->product_title, 30, '...')) ?>
				</h4>

				<?php if($product->product_manufacturer): ?>
				<div class="manufacturer">
					<span class="label"><?php echo ___('products.forms.product_manufacturer') ?>:</span>
					<span class="value"><?php echo HTML::chars($product->product_manufacturer) ?></span>
				</div>
				<?php endif; ?>
			</div>

			<div class="actions">
				<a href="<?php echo Route::url('site_products/profile/products/add_to_closet', array(
					'id' => $product->pk(),
				)) ?>" class="closet"><?php echo ___('profile.closet') ?></a>
			</div>
		</section>

		<section class="content">
			<div class="image-wrapper">
				<?php 
				$image = $product->get_first_image();

				echo HTML::anchor($product_link, 
					HTML::image(($image AND $image->exists('product_list')) ?
						$image->get_uri('product_list') : 'media/img/no_photo.jpg',
						array('alt' => $product->product_title)),
					array('class' => 'image_box')
				); ?>
			</div>

			<div class="info">

				<?php if($product->product_price !== NULL): ?>
				<div class="price">
					<span class="label"><?php echo ___('price') ?>:</span>
					<span class="value"><?php echo payment::price_format($product->product_price) ?></span>
				</div>
				<?php endif; ?>

				<div class="state">
					<?php echo Arr::get(Products::states(), $product->product_state) ?>
				</div>

				<div class="type">
					<?php echo Arr::get(Products::types(), $product->product_type) ?>
				</div>

				<div class="description">
					<?php echo Text::limit_chars(strip_tags($product->product_content), 100, '...', TRUE) ?>
				</div>
			</div>
		</section>

		<section class="actions">
			<?php echo HTML::anchor($product_link, ___('products.list.see_more_btn'), array('class' => 'see_more_btn btn')) ?>

			<?php if($product->has_company()): ?>
			<?php echo HTML::anchor(Route::get('site_products/frontend/products/show_by_company')->uri(array(
				'company_id' => $product->catalog_company->pk(),
			)), ___('products.list.company_products_btn'), array('class' => 'company_products_btn btn')) ?>
			<?php endif; ?>
		</section>
	</li>
	<?php $i++ ?>
	<?php if(!empty($ad) AND ($count_products == 1 OR $i/2 == $count_rows)): ?>
	<li class="banner">
		<?php echo $ad; ?>
	</li>
	<?php endif; ?>
	<?php endforeach ?>
</ul>
<?php else: ?>
<div class="no_results">
	<?php echo ___('products.list.no_results') ?>
</div>
<?php endif; ?>
