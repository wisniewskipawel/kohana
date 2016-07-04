<div id="product_show_box" class="box" itemscope itemtype="http://data-vocabulary.org/Product">
	
	<div class="box-header">
		<span><?php echo ___('products.product') ?>:</span> 
		<h1 itemprop="name">
			<?php echo HTML::chars($product->product_title) ?>
		</h1>
	</div>
	
	<div class="content" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
		
		<div class="meta">
			<span class="date_added"><?php echo ___('products.show.date_added') ?>: <?php echo date('Y.m.d', strtotime($product->product_date_added)) ?></span>
			<span class="date_availability"><?php echo ___('products.show.date_availability') ?>: <?php echo date('Y.m.d', strtotime($product->product_availability)) ?></span>
			<span class="visits"><?php echo ___('products.show.visits') ?>: <?php echo $product->product_visits ?></span>
		</div>
		
		<div class="row">
			<div class="col-md-7">
				<div class="price_box">

					<?php if($product->product_price !== NULL): ?>
					<span class="price-inner">
						<label><?php echo ___('price') ?>:</label>
						<span class="price">
							<span itemprop="price"><?php echo payment::price_format($product->product_price, FALSE) ?></span>
							<span itemprop="currency"><?php echo payment::currency() ?></span>
						</span>
					</span>
					<?php endif; ?>

				</div>

				<div class="product_details">

					<div class="availability_box">
						<label><?php echo ___('products.show.availability') ?>:</label>
						<span><?php echo Arr::get(Products::states(), (int)$product->product_state) ?></span>
					</div>

					<?php if($product->product_manufacturer): ?>
					<div class="manufacturer">
						<label><?php echo ___('products.show.manufacturer') ?>:</label>
						<span><?php echo HTML::chars($product->product_manufacturer) ?></span>
					</div>
					<?php endif; ?>

				</div>
			</div>
			<div class="col-md-5">
				<?php if($product->product_shop_url OR $product->product_allegro_url OR $product->product_buy): ?>
				<div class="buy_options_box">
					<h5><?php echo ___('products.show.buy') ?>:</h5>

					<ul class="buy_options">

						<?php if($product->product_shop_url): ?>
						<li>
							<?php 
							echo HTML::anchor(Tools::link($product->product_shop_url), ___('products.show.buy_shop'), array(
								'class' => 'buy_shop_btn btn',
								'target' => '_blank',
							)); 
							?>
						</li>
						<?php endif; ?>

						<?php if($product->product_allegro_url): ?>
						<li>
							<?php 
							echo HTML::anchor(Tools::link($product->product_allegro_url), ___('products.show.buy_allegro'), array(
								'class' => 'buy_allegro_btn btn',
								'target' => '_blank',
							)); 
							?>
						</li>
						<?php endif; ?>

						<?php if($product->product_buy): ?>
						<li>
							<?php 
							echo HTML::anchor(Route::get('site_products/frontend/products/order')->uri(array(
								'id' => $product->pk(),
							)), ___('products.show.buy_here'), array(
								'class' => 'buy_here_btn btn',
							)); 
							?>
						</li>
						<?php endif; ?>
					</ul>

				</div>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="product-content entry_content_box">
			<h5><?php echo ___('products.show.details') ?>:</h5>
			<div class="entry_content_box_body" itemprop="description">
				<?php
					$content = $product->product_content;
					$content = Text::linkify($content);
					echo $content;
				?>
			</div>
		</div>
			
		<?php if ($images = $product->get_images()): ?>
		<div class="entry_content_box">
			<div id="slider-gallery" class="slider">
				<div class="slider-track">
					<ul>
						<?php foreach ($images as $image): ?>
						<li>
							<div class="image-wrapper">
								<a class="slide_photo inner" title="<?php echo Security::xss_clean($product->product_title) ?>" href="<?php echo $image->get_url('product_big') ?>">
									<img src="<?php echo $image->get_url('product_list') ?>" data-showbig="<?php echo $image->get_url('product_show_big') ?>" alt="" />
								</a>
							</div>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
				<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
				<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
			</div>
		</div>
		<?php endif ?>

		<div class="entry_content_box" itemprop="seller" itemscope itemtype="http://schema.org/Person">
			<h5><?php echo ___('contact') ?></h5>

			<div class="entry_content_box_body">
				
				<div class="contact-details">
					<div class="author" itemprop="name"><?php echo $product->contact_data()->display_name() ?></div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="address">
								<?php
								$contact = $product->contact_data();
								echo $contact->address->render('single_line');
								?>
								
								<?php if($contact->address->province_id != Regions::ALL_PROVINCES): ?>
								<span class="show_map_container">
									(<a href="#" class="show_dialog_btn show_map_btn" data-dialog-target="#dialog_map"><span class="glyphicon glyphicon-globe"></span> <?php echo ___('show_on_map') ?></a>)
								</span>

								<div id="dialog_map" class="dialog hidden box dialog_map">
									<div class="dialog-title box-header"><?php echo ___('map') ?></div>
									<div id="map" data-map_lat="<?php echo $product->product_map_lat ?>" data-map_lng="<?php echo $product->product_map_lng ?>" data-map_addr="<?php echo HTML::chars($contact->address->city.', '.$contact->address->street) ?>" data-map_point_title="<?php echo HTML::chars($contact->display_name()) ?>"></div>
								</div>

								<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
								<script type="text/javascript">
								$(function() {

									$('#map').css({
										width: $(window).width()*0.8,
										height: $(window).height()*0.6
									});

									$(document)
										.on('dialog.showed', '.dialog_map', function(event, $btn) {
											var $map = $(this).find('#map');
											var data = $map.data();

											if(data['map_lat'] && data['map_lng']) {
												init_map($map[0], new google.maps.LatLng(data['map_lat'], data['map_lng']), data['map_point_title']);
												$.fancybox.resize();
												$.fancybox.center();
											} else if(data['map_addr']) {
												var geocoder = new google.maps.Geocoder();
												geocoder.geocode({address: data['map_addr']}, function(results, status) {
													if(status == google.maps.GeocoderStatus.OK) {
														var point = results[0].geometry.location;
														init_map($map[0], point, data['map_point_title']);
														$.fancybox.resize();
														$.fancybox.center();
													}
												});
											}
										});
								});

								function init_map($map, center_point, point_title) {
									var map_options = {
									  zoom: 14,
									  center: center_point,
									  mapTypeId: google.maps.MapTypeId.ROADMAP
									};

									var mapa = new google.maps.Map($map, map_options);

									var marker_options =
									{
										position: center_point,
										map: mapa,
										title: point_title
									}
									var marker = new google.maps.Marker(marker_options);
								}
								</script>
								<?php endif; ?>
							</div>

							<a href="<?php echo $contact_url = Route::url('site_products/frontend/products/contact', array('id' => $product->pk())) ?>" class="contact_btn btn btn-default btn-block show_dialog_btn" data-dialog-target="#dialog_product_contact"><?php echo ___('contact') ?></a>
							<div id="dialog_product_contact" class="dialog hidden box">
								<div class="dialog-title box-header"><?php echo ___('contact') ?></div>
								<?php echo Bform::factory('Frontend_Product_SendMessage', array(
									'product' => $product,
								))->action($contact_url)->render() ?>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="contact-meta">
								<?php if ( !Products::config('email_view_disabled') && $product->contact_data()->email): ?>
								<div class="email">
									<span><?php echo ___('email') ?>:</span>
									<?php echo Products::curtain($product, 'email', ___('email.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if ($product->contact_data()->phone): ?>
								<div class="telephone">
									<span><?php echo ___('telephone') ?>:</span>
									<?php echo Products::curtain($product, 'telephone', ___('telephone.curtain')) ?>
								</div>
								<?php endif ?>

								<?php if($product->contact_data()->www): ?>
								<div class="www">
									<span><?php echo ___('www') ?>:</span>
									<a href="<?php echo Tools::link($product->contact_data()->www) ?>" target="_blank"><?php echo URL::idna_decode($product->contact_data()->www) ?></a>
								</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				
					<?php
					$user = $product->user;
					$other_products_count = $user ? Model_Product::factory()
						->filter_by_user($user)
						->where('product_id', '!=', $product->pk())
						->add_active_conditions()
						->count_all() : 0;

					if($other_products_count OR ($product->has_company() AND $product->catalog_company->is_promoted())):
					?>
					<div class="user_other_entries">
						<ul>
							<?php if ($product->has_company() AND $product->catalog_company->is_promoted()): ?>
							<li class="company_link">
								<?php echo HTML::anchor(catalog::url($product->catalog_company), '<i class="glyphicon glyphicon-briefcase"></i> '.___('catalog.module_links.btn'), array(
									'target' => ($product->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
								)) ?>
							</li>
							<?php endif; ?>
							<?php if($other_products_count): ?>
							<li><?php echo HTML::anchor(Route::get('site_products/frontend/products/show_by_user')->uri(array(
								'id' => $user->pk(),
							)), ___('template.user_products')) ?></li>
							<?php endif ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
				
			</div>
		</div>

		<div class="bottom">
			<ul class="product-actions">
				<li class="closet"><a href="<?php echo Route::url('site_products/profile/products/add_to_closet', array('id' => $product->product_id)) ?>"><?php echo ___('to_closet') ?></a></li>
				<li class="print"><a href="<?php echo Route::url('site_products/frontend/products/print', array(
					'id' => $product->pk(),
				)) ?>" target="_blank"><?php echo ___('print') ?></a></li>
				<li class="report"><a rel="nofollow" href="<?php echo Route::url('site_products/frontend/products/report', array('id' => $product->product_id)) ?>"><?php echo ___('report') ?></a></li>
			</ul>

			<div class="share">
				<span class="l"><?php echo ___('share') ?>:</span>
				<?php
				$share = new Share(
					products::uri($product, 'http'), 
					$product->product_title
				);
				
				if($images AND $images->first() AND $images->first()->exists('product_big'))
					$share->add_image($images->first()->get_url('product_big', 'http'));
				
				$share->add_send_friend_form(
					$send_url = Route::url('site_products/frontend/products/send', array('id' => $product->pk())),
					Bform::factory(new Form_Frontend_Product_Send, array(
						'product' => $product,
					))->action($send_url)->render(),
					___('products.send.title')
				);

				echo $share->render();
				?>
			</div>
		</div>
		
	</div>

</div>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>

<?php if(isset($similar_products) AND count($similar_products)): ?>
<div id="similar_products_box" class="box primary">
	<div class="box-header"><?php echo ___('products.boxes.similar.title') ?></div>
	<div class="content">
		<?php echo View::factory('frontend/products/partials/list_box_small')
			->set('products', $similar_products); 
		?>
	</div>
</div>
<?php endif; ?>