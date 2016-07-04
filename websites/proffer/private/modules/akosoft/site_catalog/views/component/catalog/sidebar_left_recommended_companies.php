<?php if(count($companies)): ?>
<div id="recommended_companies_box" class="box">
	<div class="box-header"><?php echo ___('catalog.boxes.sidebar_recommended.title') ?></div>
	<div class="content">
		
		<?php echo View::factory('frontend/catalog/_companies_box_list')->set('companies', $companies) ?>
		
	</div>
</div>
<?php endif; ?>