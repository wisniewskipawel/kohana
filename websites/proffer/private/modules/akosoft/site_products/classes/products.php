<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Products {
	
	protected static $_config = NULL;
	
	public static function config($key = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Arr::merge(
				(array)Kohana::$config->load('products'),
				(array)Kohana::$config->load('modules.site_products')
			);
		}
		
		if($key === NULL)
			return self::$_config;
		
		return Arr::path(self::$_config, $key, $default);
	}
	
	public static function promo_packets()
	{
		return array(
			NULL	=> ___('select.choose'),
			5	   => 5,
			10	  => 10,
			20	  => 20,
		);
	}

	public static function province_to_text($province)
	{
		if(!$province)
			return NULL;
		
		$provinces = self::provinces();
		unset($provinces[NULL]);
		
		return Arr::get($provinces, $province, '');
	}
	
	public static function provinces()
	{
		$select = Regions::provinces();
		
		return Arr::unshift($select, NULL, ___('select.choose'));
	}
	
	public static function distinctions($with_none = FALSE)
	{
		$distinctions = array(
			Model_Product::DISTINCTION_PREMIUM => ___('products.distinctions.'.Model_Product::DISTINCTION_PREMIUM),
		);
		
		if ($with_none)
		{
			Arr::unshift($distinctions, Model_Product::DISTINCTION_NONE, ___('products.distinctions.'.Model_Product::DISTINCTION_NONE));
		}
		
		return $distinctions;
	}
	
	public static function person_types()
	{
		return array(
			NULL		=> ___('select.choose'),
			'person'		=> ___('products.forms.person_types.person'),
			'company'		=> ___('products.forms.person_types.company'),
		);
	}
	
	public static function types()
	{
		$model = new Model_Product_Type();
		return $model->get_for_select();
	}
	
	public static function availabilites()
	{
		$model = new Model_Product_Availability;
		$availabilites = $model->get_for_select();
		
		foreach($availabilites as &$availability)
		{
			$availability = ___('date.days_nb', (int)$availability, array(':nb' => $availability));
		}
		
		return $availabilites;
	}
	
	public static function states()
	{
		return array(
			1 => ___('products.forms.product_states.1'),
			2 => ___('products.forms.product_states.2'),
			0 => ___('products.forms.product_states.0'),
		);
	}
	
	public static function breadcrumbs(Model_Product_Category $category, $admin = FALSE) 
	{
		$breadcrumbs = array();
		$categories_ids = array();
		$categories_ids[] = $category->category_id;
		
		$parents = $category->get_parents(FALSE, TRUE);
		
		foreach ($parents as $c) {
			if ($admin) {
				$breadcrumbs[$c->category_name] = '/admin/product/categories/index/' . $c->category_id;
			} else {
				$breadcrumbs[$c->category_name] = Route::url('site_products/frontend/products/category', array('category_id' => $c->category_id, 'title' => URL::title($c->category_name)), 'http');
			}
			$categories_ids[] = $c->category_id;
		}

		return array($breadcrumbs, $categories_ids);
	}
	
	public static function uri(Model_Product $product, $with_base_url = FALSE)
	{
		$category = $product->get_last_category();
		
		if($category)
		{
			$category = $category->category_name;
		}
		
		$uri = Route::get('site_products/frontend/products/show')->uri(array(
			'product_id' => $product->pk(),
			'title' => URL::title($product->product_title),
			'category_name' => URL::title($category, '-', TRUE),
		));
		
		if(Request::$subdomain)
		{
			return URL::site($uri, 'http', FALSE, Route::SUBDOMAIN_EMPTY);
		}
		
		return $with_base_url ? URL::site($uri, $with_base_url == 'http' ? 'http' : NULL) : $uri;
	}

	/**
	 * @param Model_Product $product
	 * @param $place
	 * @param $title
	 * @return string
	 */
	public static function curtain(Model_Product $product, $place, $title)
	{
		return HTML::anchor(
			Route::url('ajax', array(
				'controller' => 'products',
				'action' => 'curtain',
				'id' => $product->pk(),
			), 'http').'?show='.$place,
			___($title),
			array(
				'class' => 'ajax_curtain',
				'rel' => 'nofollow',
			)
		);
	}
	
	public static function promotion_limits($company_promotion_type)
	{
		return Kohana::$config->load('modules.site_products.free_promotion.'.$company_promotion_type);
	}
	
	public static function which()
	{
		return array(
			NULL => ___('products.admin.which.all'),
			'standard' => ___('products.admin.which.standard'),
			'promoted' => ___('products.admin.which.promoted'),
			'not_active' => ___('products.admin.which.not_active'),
			'active' => ___('products.admin.which.active'),
			'not_approved' => ___('products.admin.which.not_approved'),
		);
	}
	
	public static function meta_tags(Model_Product $product)
	{
		$meta = array();
		
		$meta['og:title'] = array(
			'property' => 'og:title',
			'content' => $product->product_title,
		);
		
		$meta['og:type'] = array(
			'property' => 'og:type',
			'content' => 'object',
		);
		
		$meta['og:url'] = array(
			'property' => 'og:url',
			'content' => Products::uri($product, 'http'),
		);
		
		if($images = $product->get_images())
		{
			foreach($images as $image)
			{
				$meta[] = array(
					'property' => 'og:image',
					'content' => $image->get_url('product_big', 'http'),
				);
			}
		}
		
		return $meta;
	}

	/**
	 * @return ImageManagerSimple
	 */
	public static function get_category_icon_manager()
	{
		return new ImageManagerSimple(Upload::$default_directory.'/product_categories/');
	}
	
}
