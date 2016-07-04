<div class="box announcements-recommended catalog">
	<div class="box-header"><?php echo ___('catalog.boxes.sidebar_promoted.title') ?></div>
	<div class="content">

		<ul>
			<?php $i = 1; ?>
			<?php foreach ($companies as $c): $company_link = catalog::url($c); ?>
				<li<?php if ($i == 1): ?> class="first"<?php endif ?><?php if ($i == count($companies)): ?> class="last"<?php endif ?>>
					<a href="<?php echo $company_link ?>">
						<?php $logo = $c->get_logo(); if($logo AND $logo->exists('catalog_company_list')): ?>
						<?php 
						echo HTML::image(
							$logo->get_uri('catalog_company_list'),
							array('alt' => $c->company_name)
						);
						?>
						<?php else: ?>
						<img src="<?php echo URL::site('/media/img/no-photo.jpg'); ?>" alt="" />
						<?php endif; ?>
					</a>
					<p class="title"><a href="<?php echo $company_link ?>"><span class="orange"><?php echo $c->company_name ?></span></a></p>
				</li>
				<?php $i++ ?>
		   <?php endforeach; ?>
		</ul>
		
		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_BB) ?>

		<a href="<?php echo Route::url('site_catalog/frontend/catalog/promoted') ?>" class="orange box-content-link"><?php echo ___('catalog.boxes.sidebar_promoted.all') ?></a>
		<div class="clearfix"></div>
	</div>
</div>