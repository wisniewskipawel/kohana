<div id="about_box" class="box primary">
	<h2><?php echo ___('catalog.subdomain.about.title') ?></h2>
	
	<div class="content">
		<?php
		$content = $current_company->company_description;
		$content = Text::linkify($content);
		echo $content;
		?>
	</div>
</div>

<?php if($current_company->company_products): ?>
<div id="products_box" class="box gray">
	<h2><?php echo ___('catalog.companies.products.title') ?></h2>
	
	<div class="content">
		<?php
		$content = $current_company->company_products;
		$content = Text::linkify($content);
		echo $content;
		?>
	</div>
</div>
<?php endif; ?>