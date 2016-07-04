<div class="box primary entry_show_box">
	<div class="box-header"><?php echo ___('products.show.title') ?></div>
	<div class="content">
		
		<ul class="product-navigation-tabs">
			<?php if(!empty($product->user_id) && ORM::factory('product')->count_all_list(array('user_id' => $product->user_id))-1): ?>
			<li><a href="<?php echo Route::url('site_products/frontend/products/show_by_user', array('id' => $product->user_id)) ?>"><?php echo ___('products.show_by_user.btn') ?></a></li>
			<?php endif; ?>
		</ul>

		<div class="product entry_body" itemscope itemtype="http://data-vocabulary.org/Product">

			<h1 itemprop="name"><?php echo HTML::chars($product->product_title) ?></h1>

			<div class="content">
				
				
				
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

							<?php if (Kohana::$config->load('modules.site_products.provinces_enabled') && $product->contact_data()->address->province): ?>
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
								<span><?php echo Products::curtain($product, 'telephone', 'telephone.curtain') ?></span>
							</div>
							<?php endif ?>

							<?php if ( ! Kohana::$config->load('modules.site_products.email_view_disabled') && $product->contact_data()->email): ?>
							<div class="email">
								<label><?php echo ___('email') ?>:</label>
								<span><?php echo Products::curtain($product, 'email', 'email.curtain') ?></span>
							</div>
							<?php endif ?>

							<?php if ($product->contact_data()->www): ?>
							<div class="www">
								<label><?php echo ___('www') ?>:</label>
								<span><a target="_blank" href="<?php echo Tools::link($product->contact_data()->www) ?>"><?php echo URL::idna_decode($product->contact_data()->www) ?></a></span>
							</div>
							<?php endif ?>

							<?php if ($product->has_company() AND $product->catalog_company->is_promoted()): ?>
							<div class="modules_links">
								<div class="company_link">
									<?php echo HTML::anchor(catalog::url($product->catalog_company), ___('catalog.module_links.btn'), array(
										'target' => ($product->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
									)) ?>
								</div>

								<?php if(Modules::enabled('site_announcements') AND Model_Announcement::count_by_company($product->catalog_company)): ?>
								<div class="announcements">
								<?php echo HTML::anchor(catalog::url($product->catalog_company, 'announcements'), ___('announcements.module_links.btn'), array(
										'target' => ($product->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
									)) ?>
								</div>
								<?php endif; ?>
						
								<?php if(Modules::enabled('site_offers') AND Model_Offer::count_by_company($product->catalog_company)): ?>
								<div class="offers">
									<?php echo HTML::anchor(catalog::url($product->catalog_company, 'offers'), ___('offers.module_links.btn'), array(
										'target' => ($product->catalog_company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) ? '_blank' : NULL,
									)) ?></a>
								</div>
								<?php endif; ?>

							</div>
							<?php endif ?>
						</div>
					</div>
					
					<?php if($product->product_shop_url OR $product->product_allegro_url OR $product->product_buy): ?>
					<div class="entry_content_box buy_options_box">
						<h3><?php echo ___('products.show.buy') ?>:</h3>
						
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

				<div class="entry_tabs entry_tabs_side">

					<ul class="entry_tabs_headers">
						<li class="active"><a href="#product-photos"><?php echo ___('photos') ?></a></li>
						<li class="last"><a href="#product-contact"><?php echo ___('contact') ?></a></li>
					</ul>

					<div class="container">

						<div class="active" id="product-photos">
							<?php if ( ! empty($images)): ?>
								<div class="slider-gallery">
									<div class="big-photo">
										<?php if (count($images)): ?>
											<a class="photo_big" title="<?php echo Security::xss_clean($product->product_title) ?>" href="<?php echo $images->first()->get_url('product_big') ?>">
												<img src="<?php echo $images->first()->get_url('product_show_big') ?>" alt="<?php echo HTML::chars($product->product_title) ?>" border="0" itemprop="image">
											</a>
										<?php endif ?>
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

								<div class="clearfix"></div>
							<?php else: ?>
								<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
							<?php endif ?>

						</div>

						<div id="product-contact">
							<div class="entry_contact_form_info">
								<?php echo ___('products.contact.info') ?>
							</div>
							<?php echo $form->param('class', 'bform entry_contact_form') ?>
						</div>

						
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

				<div class="entry_top_bar">

					<p class="product-share">
						<?php 
						$product_link_raw = products::uri($product, 'http');
						$product_link = urlencode($product_link_raw); 
						?>

						
						<div class="share-buttons">
							<a id="fb-share" href="https://www.facebook.com/sharer/sharer.php<?php 
								$fb_params = array(
									's' => 100,
									'p' => array(
										'url' => $product_link_raw,
										'title' => $product->product_title,
										'summary' => Text::limit_chars(strip_tags($product->product_content), 100, '...'),
									),
								);
							
								if($images->first() AND $images->first()->exists('product_big'))
									$fb_params['p']['images'][0] = $images->first->get_url('product_big', 'http');
								
								echo URL::query($fb_params, FALSE) ?>" title="<?php echo ___('share.fb') ?>" target="_blank"></a>
							<a id="gg-share" href="gg:/set_status?description=<?php echo $product_link ?>" title="<?php echo ___('share.gg') ?>" target="_blank"></a>
							<a id="wykop-share" href="http://www.wykop.pl/dodaj?url=<?php echo $product_link ?>" title="<?php echo ___('share.wykop') ?>" target="_blank"></a>
							<a id="nk-share" href="http://nasza-klasa.pl/sledzik?shout=<?php echo $product_link ?>" title="<?php echo ___('share.nk') ?>" target="_blank"></a>
							<a id="blip-share" href="http://www.blip.pl/dashboard?body=<?php echo $product_link ?>" title="<?php echo ___('share.blip') ?>" target="_blank"></a>
							<a id="twitter-share" href="http://twitter.com/?status=<?php echo $product_link ?>" title="<?php echo ___('share.twitter') ?>" target="_blank"></a>
							<div style="float:left; margin-top: 4px; margin-left: 3px"><g:plusone size="small"></g:plusone></div>
							<script type="text/javascript">
							  window.____gcfg = {lang: 'pl'};

							  (function() {
								var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
								po.src = 'https://apis.google.com/js/plusone.js';
								var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
						</div>
					</p>


					<ul class="product-actions">
						<li class="closet">
							<a href="<?php echo Route::url('site_products/profile/products/add_to_closet', array(
								'id' => $product->product_id,
							)) ?>"><?php echo ___('to_closet') ?></a>
						</li>
						<li class="print">
							<a href="<?php echo Route::url('site_products/frontend/products/print', array(
								'id' => $product->product_id,
							)) ?>" target="_blank"><?php echo ___('print') ?></a>
						</li>
						<li class="recommend">
							<a href="<?php echo Route::url('site_products/frontend/products/send', array(
								'id' => $product->product_id,
							)) ?>"><?php echo ___('share_friend') ?></a>
						</li>
						<li class="report">
							<a rel="nofollow" href="<?php echo Route::url('site_products/frontend/products/report', array(
								'id' => $product->product_id,
							)) ?>"><?php echo ___('report') ?></a>
						</li>
					</ul>

				</div>
				
			</div>

			<?php if(isset($comments)) echo $comments ?>

			
		</div>

		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_G) ?>

	</div>

</div>

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