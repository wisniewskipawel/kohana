<ul class="products_list list_box_small">
<?php foreach ($products as $product): 
	$product_link = products::uri($product);
?>
	<li>
		<div class="image-wrapper">
			<?php 
			$image = $product->get_first_image();

			echo HTML::anchor($product_link, 
				HTML::image(($image AND $image->exists('product_list')) ?
					$image->get_uri('product_list') : 'media/img/no_photo.jpg'),
				array('class' => 'image_box')
			); ?>
			
			
		</div>

		<div class="info">
			<div class="title">
				<?php echo HTML::anchor($product_link, Text::limit_chars($product->product_title, 30, '...'), array('title' => $product->product_title)) ?>
			</div>
			<div class="meta">
				<div class="type_state info-entry">
					<span class="info-label type"><?php echo Arr::get(Products::types(), $product->product_type) ?>:</span>
					<span class="info-value state"><?php echo Arr::get(Products::states(), $product->product_state) ?></span>
				</div>
				<div class="price_side">
					<?php echo payment::price_format($product->product_price, FALSE) ?>
					<span class="currency"><?php echo payment::currency() ?></span>
				</div>
			</div>
		</div>
	</li>
<?php endforeach; ?>
</ul>