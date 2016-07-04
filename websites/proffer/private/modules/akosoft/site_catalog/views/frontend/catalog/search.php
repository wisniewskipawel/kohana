<?php if ( ! count($companies)): ?>
	<div class="box">
		<h2><?php echo ___('catalog.companies.search.title') ?></h2>
		<div class="content">
			<?php echo $form ?>
		</div>
	</div>
<?php endif ?>

<div class="box primary announcements companies">
	<h2><?php echo ___('catalog.companies.search.results') ?></h2>
	<div class="content">
	   <?php echo $pager ?>
	
		<?php echo View::factory('frontend/catalog/_list')->set('companies', $companies) ?>

		<?php echo $pager ?>
	</div>
</div>