<?php 
$categories = (new Model_Post_Category)->find_root()->find_childrens();

if(count($categories)): ?>
<div id="posts_categories_side">
	
	<button type="button" class="btn btn-default btn-block collapse-btn" data-toggle="collapse" data-target="#posts_categories_nav">
		<?php echo ___('template.browse_categories') ?>
		<span class="caret"></span>
	</button>
	
	<nav id="posts_categories_nav" class="collapse">
		<ul class="posts_categories_menu nav navbar-nav">
			<?php foreach($categories as $category):
				$category_uri = Route::get('site_posts/frontend/posts/category')->uri(array(
					'id' => $category->pk(),
					'name' => URL::title($category->category_name),
				));
				$is_active = (isset($current_category) 
					AND (
						$current_category->pk() == $category->pk()
						OR $current_category->parent_id == $category->pk()
					));
			?>
			<li <?php if($category->has_childrens()): ?>class="dropdown"<?php endif; ?>>
				<div class="btn">
					<a href="<?php echo URL::site($category_uri) ?>" class="btn-link">
						<?php echo HTML::chars($category->category_name) ?>
					</a>

					<?php if($category->has_childrens()): ?>
					<a href="<?php echo URL::site($category_uri) ?>" class="dropdown-toggle btn-caret" data-toggle="dropdown">
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php foreach($category->find_childrens() as $subcategory): ?>
						<li>
							<?php echo HTML::anchor(Route::get('site_posts/frontend/posts/category')->uri(array(
								'id' => $subcategory->pk(),
								'name' => URL::title($subcategory->category_name),
							)), $subcategory->category_name, array(
								'class' => (isset($current_category) AND $current_category->pk() == $subcategory->pk()) ? 'active' : '',
							)) ?>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</div>
<?php endif; ?>