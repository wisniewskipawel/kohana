<ul class="products_list list_box">
	<?php foreach ($products as $product): 
		$product_link = Products::uri($product);
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
					<div class="description">
						<?php echo Text::limit_chars(strip_tags($product->product_content), 100, '...', TRUE) ?>
						<?php echo HTML::anchor($product_link, ___('more')) ?>
					</div>
				</div>
			</section>
			
			<section class="actions">
				<?php echo HTML::anchor($product_link, ___('products.list.see_more_btn'), array('class' => 'see_more_btn btn')) ?>
				
				<?php echo HTML::anchor('#', ___('products.list.company_products_btn'), array('class' => 'company_products_btn btn')) ?>
			</section>
		</li>
   <?php endforeach; ?>
</ul>