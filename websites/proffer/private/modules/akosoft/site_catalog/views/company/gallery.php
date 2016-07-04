<div id="gallery_box" class="box primary">
	<h2><?php echo ___('catalog.subdomain.gallery.title') ?></h2>
	
	<div class="content">
		<div id="announcement-photos">
			<?php if (count($images)): ?>
			<div class="slider-gallery">
				<div class="big-photo">
					<a class="photo_big" title="<?php echo Security::xss_clean($current_company->company_name) ?>" href="<?php echo $images->first()->get_url('catalog_company_big') ?>" >
						<?php 
						echo HTML::image(
							$images->first()->get_uri('catalog_company_thumb_big'),
							array('alt' => $current_company->company_name)
						);
						?>
					</a>
				</div>
				<div class="nav">
					<a class="prev browse left"></a>
					<div class="slider">
						<div class="items">
							<?php foreach(new LimitIterator($images, 0, $current_company->get_promotion_type_limit('images')) as $image): ?>
								<a class="slide_photo" href="<?php echo $image->get_url('catalog_company_big') ?>" data-big_thumb="<?php echo $image->get_url('catalog_company_thumb_big') ?>">
									<?php 
									echo HTML::image(
										$image->get_url('catalog_company_list'),
										array('alt' => $current_company->company_name)
									);
									?>
								</a>
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
	</div>
</div>
