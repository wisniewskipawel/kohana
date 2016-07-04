<ul class="companies_box_list">
	<?php foreach($companies as $c):  $company_link = catalog::url($c); ?>
		<li>
			<div class="image-wrapper">
			<?php $logo = $c->get_logo(); if($logo AND $logo->exists('catalog_company_list')): ?>
				<?php if ($c->is_promoted()): ?>
				<a href="<?php echo $company_link ?>"<?php if($c->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) echo ' target="_blank"'; ?>>
					<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="">
				</a>
				<?php else: ?>
				<div class="inner">
					<img src="<?php echo $logo->get_url('catalog_company_list') ?>" alt="">
				</div>
				<?php endif ?>
			<?php else: ?>
				<?php if ($c->is_promoted()): ?>
				<a href="<?php echo $company_link ?>"<?php if($c->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) echo ' target="_blank"'; ?>>
					<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo">
				</a>
				<?php else: ?>
				<div class="inner">
					<img src="<?php echo URL::site('/media/img/no_photo.jpg') ?>" alt="" class="no-photo">
				</div>
				<?php endif ?>
			<?php endif; ?>
			</div>
			
			<div class="entry">
				<div class="title">
					<a href="<?php echo $company_link ?>"<?php if($c->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) echo ' target="_blank"'; ?>>
						<?php echo HTML::chars($c->company_name) ?>
					</a>
				</div>
				
				<div class="meta">
					<?php if($c->has_first_category()): ?>
					<div class="category">
						<?php echo HTML::anchor(
							Route::get('site_catalog/frontend/catalog/show_category')->uri(array(
								'category_id' => $c->first_category->pk(),
								'title' => URL::title($c->first_category->category_name)
							)),
							$c->first_category->category_name
						) ?>
					</div>
					<?php endif; ?>
					
					
				</div>
			</div>
		</li>
	<?php endforeach ?>
</ul>