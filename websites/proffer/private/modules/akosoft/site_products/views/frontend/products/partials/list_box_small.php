<ul class="products_list list_box_small">
<?php foreach ($products as $product): 
	$product_link = products::uri($product);
?>
	<li>
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
				<h4 class="title">
					<?php echo HTML::anchor($product_link, Text::limit_chars($product->product_title, 30, '...')) ?>
				</h4>
				
				<?php if($product->product_price !== NULL): ?>
				<div class="price">
					<?php echo ___('price') ?>: <span class="price"><?php echo payment::price_format($product->product_price) ?></span>
				</div>
				<?php endif; ?>
			</div>
		</section>
	</li>
<?php endforeach; ?>
</ul>