<div class="box primary categories">
	<div class="box-header"><?php echo ___('catalog.boxes.categories.title') ?></div>
	<div class="content">

		<div class="categories_grid">
			<?php foreach ($categories as $c): ?>
			<ul class="category nav">
				<li class="main_category">
					<a href="<?php echo Route::url('site_catalog/frontend/catalog/show_category', array('category_id' => $c->category_id, 'title' => URL::title($c->category_name))) ?>">
						<?php if($image = catalog::get_category_icon_manager()->get_uri($c->category_id))
							echo HTML::image($image, array('alt' => $c->category_name)) ?>
						<?php echo $c->category_name ?>
						<span class="counter">(<?php echo $c->count_companies ?>)</span>
					</a>
				</li>

				<?php if (count($c->subcategories)): $j = 1; ?>
				<li class="subcategories">
					<ul class="nav">
						<?php foreach ($c->subcategories as $id => $category): ?>
						<li<?php if ($j === 1): ?> class="first"<?php endif ?><?php if ($j === 5 OR ($j < 5 AND $j === count($c->subcategories))): ?> class="last"<?php endif ?> id="menu_category-<?php echo $id.'-'.$category->has_children ?>" <?php if ($j > 5): ?>style="display: none;"<?php endif ?>>
							<a href="<?php echo Route::url('site_catalog/frontend/catalog/show_category', array('category_id' => $id, 'title' => URL::title($category->category_name))) ?>">
								<?php echo $category->category_name ?> (<?php echo $category->count_companies ?>)
							</a>
						</li>
						<?php $j++; endforeach ?>
					</ul>
				</li>
				
				<?php if ($j > 6): ?>
				<li class="show_more">
					<a href="#" class="show_more_btn" data-toggle-text="<?php echo ___('catalog.boxes.categories.collapse') ?>">
						<?php echo ___('catalog.boxes.categories.expand') ?>
					</a>
				</li>
				<?php endif ?>

				<?php endif ?>
			</ul>
			<?php endforeach ?>
		</div>
			
	</div>
</div>

<div class="clearfix"></div>
