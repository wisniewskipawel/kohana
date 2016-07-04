<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Payment extends Controller_Admin_Main {
	
	public function action_index()
	{
		$model = new Model_Payment;
		$model->filter_by_hidden(FALSE);
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'		=> $model->reset(FALSE)->count_all(),
			'view'			=> 'pagination/admin'
		));
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			$this->set_title(___('payments.admin.index.title'))	=> '/admin/payment',
		));

		$model->set_pagination($pager);
		
		$this->template->content = View::factory('admin/payment/index')
				->set('payments', $model->order_by('date_created', 'DESC')->find_all())
				->set('pager', $pager);
	}
	
	public function action_set_status()
	{
		$payment = new Model_Payment();
		$payment->find_by_pk($this->request->param('id'));
		
		if(!$payment->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$status = $this->request->query('status');
		
		if($status == Model_Payment::STATUS_SUCCESS)
		{
			$payment_module = payment::load_payment_module(NULL, $payment);
			$payment_module->success(TRUE);
		}
		else
		{
			$payment->set_status($status);
			FlashInfo::add(___('payments.admin.set_status.success'));
		}
		
		$this->redirect_referrer();
	}
	
	public function action_settings()
	{
		$config = Kohana::$config->load('global');
		
		$params = $config->as_array();
		
		$form = Bform::factory('Admin_Payment_Settings_Common', $params);
		
		if ($form->validate()) 
		{
			$values = $form->get_values();
			
			foreach ($values as $name => $value) 
			{
				$config->set($name, $value);
			}
			FlashInfo::add(___('payments.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'			 => '/admin',
			$this->set_title(___('payments.admin.settings.title'))	  => '/admin/payment/settings',
		));
		
		$this->template->content = View::factory('admin/payment/settings')
				->set('form', $form);
	}
	
	public function action_delete()
	{
		$payment = new Model_Payment();
		$payment->find_by_pk($this->request->param('id'));
		
		if(!$payment->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$payment->set_hidden(TRUE);
		FlashInfo::add(___('payments.admin.delete.success'));
		
		$this->redirect_referrer();
	}
	
}
