<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class offers {
	
	protected static $_config = NULL;
	
	public static function config($key = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Arr::merge(
				(array)Kohana::$config->load('offers'),
				(array)Kohana::$config->load('modules.site_offers.settings')
			);
		}
		
		if($key === NULL)
			return self::$_config;
		
		return Arr::path(self::$_config, $key, $default);
	}
	
	public static function payment_place($distinction)
	{
		if ($distinction == Model_Offer::DISTINCTION_PREMIUM)
		{
			return 'premium';
		}
		elseif ($distinction == Model_Offer::DISTINCTION_PREMIUM_PLUS)
		{
			return 'premium_plus';
		}
		elseif ($distinction == Model_Offer::DISTINCTION_DISTINCTION)
		{
			return 'distinction';
		}
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
			Model_Offer::DISTINCTION_PREMIUM_PLUS	=> ___('offers.distinctions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS),
		);
		
		if ($with_none)
		{
			Arr::unshift($distinctions, Model_Offer::DISTINCTION_NONE, ___('offers.distinctions.'.Model_Offer::DISTINCTION_NONE));
		}
		
		Arr::unshift($distinctions, NULL, ___('select.choose'));
		
		return $distinctions;
	}
	
	public static function person_types()
	{
		return array(
			NULL	=> ___('select.choose'),
			'person'	=> ___('offers.forms.person_types.person'),
			'company'	=> ___('offers.forms.person_types.company'),
		);
	}
	
	public static function filters($name, & $session, $object = NULL)
	{
		$saved_filters = $session->get($name, array());

		if ($object instanceof Model_Offer_Category)
		{
			$category_id = $object->category_id;
			if ($category_id != Arr::get($saved_filters, 'category_id', 0)) {
				$session->delete($name);
				$saved_filters = array();
			}
			$saved_filters['category_id'] = $category_id;
			
			$index_filters = $session->get('index_filters');
			if ( ! empty($index_filters['province']))
			{
				$saved_filters['province'] = $index_filters['province'];
			}
		} elseif ($object instanceof Model_Users) {
			$user_id = $object->user_id;
			if ($user_id != Arr::get($saved_filters, 'user_id', 0)) {
				$session->delete($name);
				$saved_filters = array();
			}
			$saved_filters['user_id'] = $user_id;
		} 
		
		if ($name == 'index_filters') {
			$province_id = $object;
			if ($province_id != Arr::get($saved_filters, 'province', 0)) {
				$session->delete($name);
				$saved_filters = array();
			}
			$saved_filters['province_id'] = $province_id;
		}
		
		if (isset($_GET['sort_by']))
		{
			$sort_by = $_GET['sort_by'];
		}
		else
		{
			$sort_by = Arr::get($saved_filters, 'sort_by', TRUE);
		}
		$saved_filters['sort_by'] = $sort_by;
		
		
		
		if (isset($_GET['sort_direction']))
		{
			$sort_direction = $_GET['sort_direction'];
		}
		else
		{
			$sort_direction = Arr::get($saved_filters, 'sort_direction', 'desc');
		}
		if ($sort_direction !== 'desc' AND $sort_direction !== 'asc')
		{
			$sort_direction = 'desc';
		}
		$saved_filters['sort_direction'] = $sort_direction;
		
		
		
		if (isset($_GET['on_page']))
		{
			$saved_filters['on_page'] = $_GET['on_page'];
		}
		else
		{
			$saved_filters['on_page'] = Arr::get($saved_filters, 'on_page', 20);
		}
		if ($saved_filters['on_page'] > 50)
		{
			$saved_filters['on_page'] = 50;
		}

		
	 	if (isset($_GET['type']))
		{
			$saved_filters['type'] = $_GET['type'];
		}
		else
		{
			$saved_filters['type'] = Arr::get($saved_filters, 'type', '');
		}
		$saved_filters['type'] = intval($saved_filters['type']);
		
		

		if (isset($_GET['sort_by_price']))
		{
			$saved_filters['sort_by_price'] = $_GET['sort_by_price'];
		}
		else
		{
			$saved_filters['sort_by_price'] = Arr::get($saved_filters, 'sort_by_price', '');
		}
		$saved_filters['sort_by_price'] = Security::xss_clean($saved_filters['sort_by_price']);
		
		

		if (isset($_GET['sort_by_date_added']))
		{
			$saved_filters['sort_by_date_added'] = $_GET['sort_by_date_added'];
		}
		else
		{
			$saved_filters['sort_by_date_added'] = Arr::get($saved_filters, 'sort_by_date_added', '');
		}
		$saved_filters['sort_by_date_added'] = Security::xss_clean($saved_filters['sort_by_date_added']);
		
		
		
		if (isset($_GET['province']))
		{
			$saved_filters['province'] = $_GET['province'];
		}
		else
		{
			$saved_filters['province'] = Arr::get($saved_filters, 'province', '');
		}
		$saved_filters['province'] = intval($saved_filters['province']);
		
		
		if (isset($_GET['from']))
		{
			$saved_filters['from'] = $_GET['from'];
		}
		else
		{
			$saved_filters['from'] = Arr::get($saved_filters, 'from', 'all');
		}
		$saved_filters['from'] = Security::xss_clean($saved_filters['from']);
		
		
		if (isset($_GET['status']))
		{
			$saved_filters['status'] = $_GET['status'];
		}
		else
		{
			$saved_filters['status'] = Arr::get($saved_filters, 'status', '');
		}
		if ($saved_filters['status'] !== 'active' AND $saved_filters['status'] !== 'not_active')
		{
			$saved_filters['status'] = '';
		}
		
		if (isset($_GET['city']))
		{
			$saved_filters['city'] = $_GET['city'];
		}
		else
		{
			$saved_filters['city'] = Arr::get($saved_filters, 'city', '');
		}
		
		$session->set($name, $saved_filters);

		return $saved_filters;
	}

	public static function breadcrumbs(Model_Offer_Category $category, $admin = FALSE) 
	{
		$breadcrumbs = array();
		$categories_ids = array();
		$categories_ids[] = $category->category_id;
		
		$parents = $category->get_parents(FALSE, TRUE);
		
		foreach ($parents as $c)
		{
			if ($admin) {
				$breadcrumbs[$c->category_name] = '/admin/offers/categories/index/' . $c->category_id;
			} else {
				$breadcrumbs[$c->category_name] = Route::url('site_offers/frontend/offers/category', array('category_id' => $c->category_id, 'title' => URL::title($c->category_name)), 'http');
			}
			$categories_ids[] = $c->category_id;
		}

		return array($breadcrumbs, $categories_ids);
	}
	
	public static function which()
	{
		return array(
			NULL => ___('offers.which.all'),
			'standard' => ___('offers.which.standard'),
			'promoted' => ___('offers.which.promoted'),
			'not_active' => ___('offers.which.not_active'),
			'active' => ___('offers.which.active'),
			'not_approved' => ___('offers.which.not_approved'),
		);
	}

	/**
	 * @param Model_Offer $offer
	 * @param $place
	 * @param $title
	 * @return string
	 */
	public static function curtain(Model_Offer $offer, $place, $title)
	{
		return HTML::anchor(
			Route::url('ajax', array(
				'controller' => 'offers',
				'action' => 'curtain',
				'id' => $offer->pk(),
			), 'http').'?show='.$place,
			___($title),
			array(
				'class' => 'ajax_curtain',
				'rel' => 'nofollow',
			)
		);
	}
	
	public static function uri(Model_Offer $offer)
	{
		return Route::get('site_offers/frontend/offers/show')
				->uri(array(
					'offer_id' => $offer->pk(), 
					'title' => URL::title($offer->offer_title)
				));
	}
	
	public static function meta_tags(Model_Offer $offer)
	{
		$meta = array();
		
		$meta['og:title'] = array(
			'property' => 'og:title',
			'content' => $offer->offer_title,
		);
		
		$meta['description'] = array(
			'property' => 'description',
			'content' => Text::limit_chars(strip_tags($offer->offer_content), 160, '...', TRUE),
		);
		
		$meta['og:type'] = array(
			'property' => 'og:type',
			'content' => 'object',
		);
		
		$meta['og:url'] = array(
			'property' => 'og:url',
			'content' => URL::site(offers::uri($offer), 'http'),
		);
		
		if($images = $offer->get_images())
		{
			foreach($images as $image)
			{
				$meta[] = array(
					'property' => 'og:image',
					'content' => $image->get_url('offer_big', 'http'),
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
		return new ImageManagerSimple(Upload::$default_directory.'/offers_categories/');
	}
	
}

