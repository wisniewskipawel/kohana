<?php echo View::factory('frontend/products/partials/list_rows')
	->set('products', $products)
	->set('context', isset($context) ? $context : NULL)
	->set('no_ads', isset($no_ads) ? $no_ads : NULL)
?>