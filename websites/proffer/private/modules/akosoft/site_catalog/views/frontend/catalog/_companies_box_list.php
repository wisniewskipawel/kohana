<ul class="index_companies_list">
	<?php $count=count($companies); for($i=0; $i < $count;): ?>
		<li>
			<?php for($j=0; $j < 2 && $i < $count; $j++, $i++): $a=$companies[$i]; ?>
			<div class="entry">
				<a class="title" href="<?php echo catalog::url($a) ?>"<?php if($a->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) echo ' target="_blank"'; ?>><?php echo Text::limit_chars($a->company_name, 30, '...') ?></a>

				<p class="meta">
					<?php echo ___('catalog.trade') ?>: <?php if($a->has_first_category()): ?><?php echo  $a->first_category->category_name ?><?php endif; ?>
				</p>
			</div>
			 <?php endfor ?>
		</li>
	<?php endfor ?>
</ul>