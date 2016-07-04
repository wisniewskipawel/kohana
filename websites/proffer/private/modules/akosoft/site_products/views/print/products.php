<?php
Media::css('products.print.css', 'products/css');
?>
<div class="box primary entry_show_box">
	<div class="content">

		<div class="product entry_body" itemscope itemtype="http://data-vocabulary.org/Product">

			<h1 itemprop="name"><?php echo HTML::chars($product->product_title) ?></h1>

			<div class="content">
				
				<div class="entry_row">
					<div class="entry_row_col">
						
						<div class="product-info" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">

							<div class="entry_content_box product_details">
								<h3><?php echo ___('products.show.product_info') ?>:</h3>

								<div class="entry_content_box_body">

									<?php if($product->product_price !== NULL OR $product->product_price_to_negotiate): ?>
									<div class="price_box">
										<label><?php echo ___('price') ?>:</label>

										<?php if($product->product_price !== NULL): ?>
										<span class="price">
											<span itemprop="price"><?php echo payment::price_format($product->product_price, FALSE) ?></span>
											<span itemprop="currency"><?php echo payment::currency() ?></span>
										</span>
										<?php endif; ?>

										<?php if ($product->product_price_to_negotiate): ?>
											<?php echo ___('products.show.price_negotiable') ?>
										<?php endif ?>
									</div>
									<?php endif; ?>

									<div class="availability_box">
										<label><?php echo ___('products.show.availability') ?>:</label>
										<span><?php echo Arr::get(Products::states(), $product->product_state) ?></span>
									</div>

									<?php if($product->product_manufacturer): ?>
									<div class="manufacturer">
										<label><?php echo ___('products.show.manufacturer') ?>:</label>
										<span><?php echo HTML::chars($product->product_manufacturer) ?></span>
									</div>
									<?php endif; ?>

								</div>

							</div>

							<div class="entry_content_box product_announcer_box">
								<h3>
								<?php if ($product->contact_data() instanceof Contact_Person): ?>
									<?php echo ___('products.show.person_info.person') ?>:
								<?php elseif ($product->contact_data() instanceof Contact_Company): ?>
									<?php echo ___('products.show.person_info.company') ?>:
								<?php endif ?>
								</h3>

								<div class="address entry_content_box_body">
									<h2><?php echo $product->contact_data()->display_name() ?></h2>

									<div>
										<?php if ($product->contact_data()->address->postal_code): ?>
										<span class="postal_code"><?php echo $product->contact_data()->address->postal_code ?></span>
										<?php endif ?>

										<?php if ($product->contact_data()->address->city): ?>
										<span class="city"><?php echo $product->contact_data()->address->city ?></span>
										<?php endif ?>
									</div>

									<?php if ($product->contact_data()->address->street): ?>
									<div class="street"><?php echo $product->contact_data()->address->street ?></div>
									<?php endif ?>

									<?php if (Products::config('provinces_enabled') && $product->contact_data()->address->province): ?>
									<div class="province">
										<label><?php echo ___('province') ?>: </label>
										<span><?php echo $product->contact_data()->address->province ?></span>
									</div>
									<?php if($product->contact_data()->address->county AND $product->contact_data()->address->province_id != Regions::ALL_PROVINCES): ?>
									<div class="county">
										<label><?php echo ___('county') ?>: </label>
										<span><?php echo $product->contact_data()->address->county ?></span>
									</div>
									<?php endif ?>
									<?php endif ?>

									<br/>

									<?php if ($product->contact_data()->phone): ?>
									<div class="phone">
										<label><?php echo ___('telephone') ?>:</label>
										<span><?php echo $product->contact_data()->phone ?></span>
									</div>
									<?php endif ?>

									<?php if (!Products::config('email_view_disabled') && $product->contact_data()->email): ?>
									<div class="email">
										<label><?php echo ___('email') ?>:</label>
										<span><?php echo $product->contact_data()->email ?></span>
									</div>
									<?php endif ?>

									<?php if ($product->contact_data()->www): ?>
									<div class="www">
										<label><?php echo ___('www') ?>:</label>
										<span><a target="_blank" href="<?php echo Tools::link($product->contact_data()->www) ?>"><?php echo URL::idna_decode($product->contact_data()->www) ?></a></span>
									</div>
									<?php endif ?>
								</div>
							</div>
						</div>
						
					</div>
					<div class="entry_row_col">
						
						<?php $images = $product->get_images(); if (count($images)): ?>
						<div class="slider-gallery">
							<div class="big-photo">
								<a class="photo_big" title="<?php echo Security::xss_clean($product->product_title) ?>" href="<?php echo $images->first()->get_url('product_big') ?>">
									<img src="<?php echo $images->first()->get_url('product_show_big') ?>" alt="<?php echo HTML::chars($product->product_title) ?>" border="0" itemprop="image">
								</a>
							</div>
							<div class="nav">
								<a class="prev browse left"></a>
								<div class="slider">
									<div class="items">
										<?php foreach ($images as $image): ?>
										<div class="image-wrapper">
											<a class="slide_photo inner" title="<?php echo Security::xss_clean($product->product_title) ?>" href="<?php echo $image->get_url('product_big') ?>">
												<img src="<?php echo $image->get_url('product_list') ?>" data-showbig="<?php echo $image->get_url('product_show_big') ?>" alt="<?php echo HTML::chars($product->product_title) ?>" />
											</a>
										</div>
										<?php endforeach ?>
									</div>
								</div>
								<a class="next browse right"></a>
							</div>
						</div>
						<?php endif ?>
						
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="product-content">
					<h3><?php echo ___('products.show.product_content') ?>:</h3>
					<div itemprop="description">
						<?php
							$content = $product->product_content;
							$content = Text::linkify($content);
							echo $content;
						?>
					</div>
				</div>

			</div>

		</div>

	</div>

</div>