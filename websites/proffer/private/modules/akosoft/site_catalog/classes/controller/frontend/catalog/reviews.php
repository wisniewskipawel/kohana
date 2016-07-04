<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Catalog_Reviews extends Controller_Catalog {
	
	public function action_add()
	{
		$company = new Model_Catalog_Company;
		$company->filter_by_promoted();
		$company->get_by_id($this->request->param('company_id'));
		
		if(!$company->loaded())
			throw new HTTP_Exception_404;
		
		$form = Bform::factory('Frontend_Catalog_Company_Reviews_Add');
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$review = new Model_Catalog_Company_Review();
			$review->add_review($company, $values);
			
			if($review->status == Model_Catalog_Company_Review::STATUS_ACTIVE)
			{
				FlashInfo::add(___('catalog.reviews.add.success'), 'success');
			}
			else
			{
				FlashInfo::add(___('catalog.reviews.add.success', 'moderate'), 'success');
			}
			
			$review->send_new_review();
			
			$this->redirect(catalog::url($company));
		}
		
		$breadcrumbs = $this->_breadcrumb($company);
		$breadcrumbs[$this->template->set_title(___('catalog.reviews.add.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('frontend/catalog/reviews/add')
			->set('form', $form);
	}
	
}
