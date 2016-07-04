<div class="box primary companies">
	<h2><?php echo (isset($category) AND !$category->is_root()) ? 
		___('catalog.companies.category.title', array(':category_name' => HTML::chars($category->category_name))) : ___('catalog.companies.index.title') ?></h2>
	<div class="content">
		
		<?php echo View::factory('frontend/catalog/partials/filters_sorters')
				->set('filters_sorters', $filters_sorters);
		?>
		
		<?php echo $pager ?>
	
		<?php echo View::factory('frontend/catalog/_list')
				->set('companies', $companies)
		?>

		<?php echo $pager ?>
	</div>
</div>