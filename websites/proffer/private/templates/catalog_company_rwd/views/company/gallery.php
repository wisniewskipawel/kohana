<div id="gallery_box" class="box primary">
	<h2><?php echo ___('catalog.subdomain.gallery.title') ?></h2>
	
	<div class="content">
		<div id="company_gallery">
			<?php if (count($images)): ?>
			<div class="big_image">
				<a title="<?php echo HTML::chars($current_company->company_name) ?>" href="<?php echo $images->first()->get_url('catalog_company_big') ?>" >
					<?php 
					echo HTML::image(
						$images->first()->get_uri('catalog_company_thumb_big'),
						array('alt' => $current_company->company_name)
					);
					?>
				</a>
			</div>

			<?php if(count($images) > 1): ?>
			<ul class="gallery_images_list">
				<?php foreach ($images as $image): ?>
				<li>
					<div class="image-wrapper">
						<a title="<?php echo HTML::chars($current_company->company_name) ?>" href="<?php echo $image->get_url('catalog_company_big') ?>">
							<img src="<?php echo $image->get_url('catalog_company_list') ?>" data-showbig="<?php echo $image->get_url('catalog_company_thumb_big') ?>" alt="" />
						</a>
					</div>
				</li>
				<?php endforeach ?>
			</ul>
			<?php endif ?>

			<?php else: ?>
			<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo" />
			<?php endif ?>

		</div>
	</div>
</div>
