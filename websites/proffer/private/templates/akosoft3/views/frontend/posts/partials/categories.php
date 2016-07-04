<?php 
$categories = new Model_Post_Category;

if(isset($current_category) AND $current_category)
{
	$categories->filter_by_parent($current_category);
}
else
{
	$categories->filter_by_parent(NULL);
}

$categories = $categories->find_all();

if(count($categories)): ?>
<ul class="box-actions">
	<?php foreach($categories as $cat): ?>
	<li><?php echo HTML::anchor(Route::get('site_posts/frontend/posts/category')->uri(array(
		'id' => $cat->pk(),
		'name' => URL::title($cat->category_name),
	)), $cat->category_name) ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>