<?php if(count($companies)): ?>
<div id="recommended_companies_box" class="box">
	<div class="box-header"><?php echo ___('catalog.boxes.sidebar_recommended.title') ?></div>
	<div class="content">
		
		<ul class="index_companies_list">
			<?php foreach($companies as $a): ?>
			<li>
				<div class="entry">
					<a class="title" href="<?php echo catalog::url($a) ?>"<?php if($a->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) echo ' target="_blank"'; ?>><?php echo Text::limit_chars($a->company_name, 30, '...') ?></a>

					<p class="meta">
						<?php echo ___('catalog.trade') ?>: <?php if($a->has_first_category()): ?><?php echo  $a->first_category->category_name ?><?php endif; ?>
					</p>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		
	</div>
</div>
<?php endif; ?>