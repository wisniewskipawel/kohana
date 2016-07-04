<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract  class Controller_Subdomain_Base extends Controller_Base {
	
	public $template_data = array();
	
	protected $_company = NULL;
	
	protected $_session = NULL;
	
	public function before()
	{
		$this->_session = Session::instance();
		
		$slug = $this->request->param('subdomain');
		
		if($slug == Route::SUBDOMAIN_WILDCARD)
		{
			$slug = Request::$subdomain;
		}		
		
		if(!$slug)
			throw new HTTP_Exception_404;
		
		$company = new Model_Catalog_Company();
		$company->with_reviews();
		$this->_company = $company->find_by_slug($slug);
		
		if(!$this->_company->loaded())
			throw new HTTP_Exception_404('Catalog company not found!');
		
		if(!$this->_company->is_promoted(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS))
			throw new HTTP_Exception_404('Catalog company is not Premium PLUS promoted!');
		
		$this->set_title($this->_company->company_name, FALSE);
		
		$this->template = View_Template::instance('catalog_company');
		$this->template->set_global('current_company', $this->_company);
		
		parent::before();
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			foreach($this->template_data as $name => $value)
			{
				$this->template->set($name, $value);
			}
			
			$this->template->set_meta_tags(catalog::meta_tags($this->_company));
		}
		
		parent::after();
	}
	
	public function set_title($title, $prepend = TRUE)
	{
		$title = UTF8::trim($title);
		
		if(empty($title))
			return NULL;
		
		if($prepend)
		{
			$this->template_data['meta_title'] = $title.' - '.Arr::get($this->template_data, 'meta_title');
		}
		else
		{
			$this->template_data['meta_title'] = $title;
		}
		
		return $title;
	}
	
}