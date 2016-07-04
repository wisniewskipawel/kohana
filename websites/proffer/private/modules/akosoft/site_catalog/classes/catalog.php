<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class catalog {
	
	protected static $_config = NULL;
	
	public static function config($key = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Arr::merge(
				(array)Kohana::$config->load('catalog'),
				(array)Kohana::$config->load('modules.site_catalog')
			);
		}
		
		if($key === NULL)
			return self::$_config;
		
		return Arr::path(self::$_config, $key, $default);
	}
	
	public static function breadcrumbs(Model_Catalog_Category $category, $is_admin = FALSE)
	{
		$breadcrumbs = array();
		foreach ($category->get_parents(FALSE, TRUE) as $c)
		{
			if ($is_admin)
			{
				$breadcrumbs[$c->category_name] = '/admin/catalog/categories/index/' . $c->category_id;
			}
			else
			{
				$breadcrumbs[$c->category_name] = Route::url('site_catalog/frontend/catalog/show_category', array('category_id' => $c->category_id, 'title' => URL::title($c->category_name)));
			}
		}
		return $breadcrumbs;
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
	
	public static function url(Model_Catalog_Company $company, $route_name = 'show', $params = array())
	{
		if($company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_BASIC OR !$company->is_promoted())
		{
			return NULL;
		}
		
		if($company->promotion_type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS && !empty($company->slug))
		{
			$params['subdomain'] = $company->slug;
			$uri = Route::get('site_catalog/company/'.$route_name)->uri($params);
			
			return URL::site($uri, 'http', FALSE, catalog::is_subdomain_enabled() ? $company->slug : NULL);
		}
		
		return Route::url('site_catalog/frontend/catalog/'.$route_name, array(
			'company_id' => $company->pk(), 
			'title' => URL::title($company->company_name)
		), 'http');
	}

	/**
	 * @param Model_Catalog_Company $company
	 * @param $place
	 * @param $title
	 * @return string
	 * @throws Kohana_Exception
	 */
	public static function curtain(Model_Catalog_Company $company, $place, $title)
	{
		return HTML::anchor(
			Route::get('ajax')->uri(array(
				'controller' => 'catalog',
				'action' => 'curtain',
				'id' => $company->pk(),
				'subdomain' => Request::$subdomain,
			)).'?show='.$place,
			___($title),
			array(
				'class' => 'ajax_curtain',
				'rel' => 'nofollow',
			)
		);
	}
	
	public static function is_subdomain_enabled()
	{
		return Site::current_subdomain_module() == 'site_catalog';
	}
	
	public static function meta_tags(Model_Catalog_Company $company)
	{
		$meta = array();
		
		$meta['og:title'] = array(
			'property' => 'og:title',
			'content' => $company->company_name,
		);
		
		$meta['description'] = array(
			'name' => 'description',
			'content' => Text::limit_chars(strip_tags($company->company_description), 160, '...', TRUE),
		);
		
		$meta['keywords'] = array(
			'name' => 'keywords',
			'content' => $company->get_tags_as_string(),
		);
		
		$meta['og:type'] = array(
			'property' => 'og:type',
			'content' => 'business.business',
		);
		
		$meta['og:url'] = array(
			'property' => 'og:url',
			'content' => catalog::url($company),
		);
		
		$address = $company->get_address();
		
		$meta['business:contact_data:street_address'] = array(
			'property' => 'business:contact_data:street_address',
			'content' => $address->street,
		);
		
		$meta['business:contact_data:locality'] = array(
			'property' => 'business:contact_data:locality',
			'content' => $address->city,
		);
		
		$meta['business:contact_data:region'] = array(
			'property' => 'business:contact_data:region',
			'content' => $address->province,
		);
		
		$meta['business:contact_data:postal_code'] = array(
			'property' => 'business:contact_data:postal_code',
			'content' => $address->postal_code,
		);
		
		$meta['business:contact_data:country_name'] = array(
			'property' => 'business:contact_data:country_name',
			'content' => 'Polska',
		);
		
		$meta['place:location:latitude'] = array(
			'property' => 'place:location:latitude',
			'content' => $company->company_map_lat,
		);
		
		$meta['place:location:longitude'] = array(
			'property' => 'place:location:longitude',
			'content' => $company->company_map_lng,
		);
		
		$image = $company->get_logo();
		
		if($image AND $image->exists('catalog_company_big'))
		{
			$meta[] = array(
				'property' => 'og:image',
				'content' => $image->get_url('catalog_company_big', 'http'),
			);
		}
		
		return $meta;
	}

	/**
	 * @return ImageManagerSimple
	 */
	public static function get_category_icon_manager()
	{
		return new ImageManagerSimple(Upload::$default_directory.'/catalog_categories/');
	}
	
}
