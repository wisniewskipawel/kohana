<div class="box primary categories">
	<div class="box-header"><?php echo ___('catalog.boxes.categories.title') ?></div>
	<div class="content">

		<?php $i = 0; ?>
		<?php $opened = array(); ?>
		<?php foreach ($categories as $c): ?>
		
			<?php if ($i % 3 == 0): ?>
				<?php $opened[] = $c->category_id ?>
				<div class="row<?php if (count($categories) - $i <= 3):?> last <?php endif ?>">
			<?php endif ?>
					
			<div class="category<?php if ($i % 3 == 2):?> last<?php endif ?>">
				<div class="main_category">
					<a href="<?php echo Route::url('site_catalog/frontend/catalog/show_category', array('category_id' => $c->category_id, 'title' => URL::title($c->category_name))) ?>"><?php echo $c->category_name ?></a> (<?php echo $c->count_companies ?>)</div>
				<?php if (count($c->subcategories)): ?>

					<?php $j = 1; ?>
					<ul>
						<?php foreach ($c->subcategories as $id => $category): ?>
							<li<?php if ($j === 1): ?> class="first"<?php endif ?><?php if ($j === 5 OR ($j < 5 AND $j === count($c->subcategories))): ?> class="last"<?php endif ?> id="menu_category-<?php echo $id.'-'.$category->has_children ?>" <?php if ($j > 5): ?>style="display: none;"<?php endif ?>>
								<a href="<?php echo Route::url('site_catalog/frontend/catalog/show_category', array('category_id' => $id, 'title' => URL::title($category->category_name))) ?>"><?php echo $category->category_name ?></a> (<?php echo $category->count_companies ?>)
							</li>
							<?php $j++ ?>
						<?php endforeach ?>
					</ul>
					<?php if ($j > 6): ?>
						<a href="#" class="more" data-toggle-text="<?php echo ___('catalog.boxes.categories.collapse') ?>"><?php echo ___('catalog.boxes.categories.expand') ?></a>
					<?php endif ?>
				<?php endif ?>
			</div>
			<?php if ($i % 3 == 2):?>
				<?php array_pop($opened) ?>
				</div>
			<?php endif ?>
			<?php $i++ ?>
		<?php endforeach ?>
		
		<?php if (count($opened)): ?>
			</div>
		<?php endif ?>
			
	</div>
</div>

<div class="clearfix"></div>
