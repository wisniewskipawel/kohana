<div id="product_tags_box" class="box">
	<div class="box-header"><?php echo ___('products.boxes.tags.title') ?></div>
	<div class="content">
		<?php 
		
		$elements = array();
		
		foreach($tags as $tag)
		{
			$elements[] = array(
				'title' => $tag->tag,
				'link' => Route::get('site_products/frontend/products/tag')->uri(array('tag' => $tag->raw_tag)),
				'count' => $tag->counter,
			);
		}
		
		echo Tagcloud::factory($elements, 100, 200, TRUE);
		?>
	</div>
</div>
