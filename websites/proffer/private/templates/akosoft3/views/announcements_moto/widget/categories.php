<div id="categories_side">
	
	<button type="button" class="btn btn-default btn-block collapse-btn" data-toggle="collapse" data-target="#categories_box">
		<?php echo ___('template.browse_categories') ?>
		<span class="caret"></span>
	</button>
	
	<div id="categories_box" class="box collapse">
		<div class="box-header"><?php echo ___('template.browse_categories') ?></div>
		<div class="box-content">
			<nav id="categories_nav">
				<?php if($parent_category): ?>
				<ul class="nav nav-pills nav-stacked">
					<li class="category_up expanded">
						<?php 

						if(!$parent_category->is_root())
						{
							$parent_uri = $current_module->route('frontend/announcements/category')->uri(array(
								'category_id' => $parent_category->category_id, 
								'title' => URL::title($parent_category->category_name)
							));
						}
						else
						{
							$parent_uri = $current_module->route('frontend/announcements/index')->uri();
						}

						echo HTML::anchor($parent_uri.URL::query(array(
							'city' => !empty($query['city']) ?$query['city'] : NULL,
							'province' => !empty($query['province']) ?$query['province'] : NULL,
						), FALSE), $current_module->trans('boxes.categories.category_up'));
						
						echo $current_module->view('widget/partials/categories_list')
							->set('categories', $categories)
							->set('parent_category', $parent_category); 
						?>
					</li>
				</ul>
				<?php else: ?>
				<?php 
				echo $current_module->view('widget/partials/categories_list')
					->set('categories', $categories)
					->set('parent_category', FALSE); 
				?>
				<?php endif; ?>
			</nav>
		</div>
	</div>
	
</div>
