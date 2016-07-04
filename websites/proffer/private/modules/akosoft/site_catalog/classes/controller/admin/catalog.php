<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Admin_Catalog extends Controller_Admin_Main {
	
	public function action_settings_payment()
	{
		$config = Kohana::$config->load('modules');
		
		$params = $config->as_array();
		
		$type = $this->request->query('type');
		
		if($type == 'company_promote')
		{
			$form = Bform::factory('Admin_Catalog_Payment_Promote', $params);
		} 
		elseif($type == 'company_add')
		{
			$form = Bform::factory('Admin_Catalog_Payment_Add', $params);
		}
		else
		{
			throw new HTTP_Exception_404;
		}
		
		if ($form->validate())
		{
			$values = $form->get_values();
			foreach ($values as $name => $value)
			{
				$config->set($name, $value);
			}
			FlashInfo::add(___('catalog.admin.payments.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'admin.settings.payment.title'	=> '/admin/settings/payment',
			$this->set_title(___('catalog.admin.payments.title'))	=> '/admin/catalog/settings_payment?type='.$type,
		));
		
		$this->template->content = View::factory('admin/catalog/settings_payment')
				->set('form', $form);
	}
	
	public function action_settings()
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory('Admin_Catalog_Settings', catalog::config());
		
		if ($form->validate())
		{
			$values = $form->get_values();
			$config->set('site_catalog', $values);
			
			FlashInfo::add(___('catalog.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			$this->set_title(___('catalog.admin.settings.title'))	=> '/admin/catalog/settings',
		));
		
		$this->template->content = View::factory('admin/catalog/settings')
				->set('form', $form);
	}
	
}
