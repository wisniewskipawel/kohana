<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Job_Settings extends Controller_Admin_Main {

	public function action_index()
	{
		$config = Kohana::$config->load('modules');

		$form = Bform::factory('Admin_Jobs_Settings', Jobs::config());

		if($form->validate())
		{
			$values = $form->get_values();
			$config->set('site_jobs', $values);

			FlashInfo::add('jobs.admin.settings.success', 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.settings.title' => '/admin/job/settings'
		));

		$this->template->content = View::factory('jobs/admin/settings')
			->set('form', $form);
	}

	public function action_payments()
	{
		$config = Kohana::$config->load('modules');
		$params = $config->as_array();

		$form_type = $this->request->query('form');

		switch($form_type)
		{
			case 'job_add':
				$form = Bform::factory('Admin_Jobs_Payments_Add', $params);
				break;
			
			case 'job_promote_premium':
				$form = Bform::factory('Admin_Jobs_Payments_Promote', array(
					'types' => array(Model_Job::DISTINCTION_PREMIUM => ___('jobs.promotion.premium')),
					'values' => $params,
				));
				break;
			
			case 'job_promote_premium_plus':
				$form = Bform::factory('Admin_Jobs_Payments_Promote', array(
					'types' => array(Model_Job::DISTINCTION_PREMIUM_PLUS => ___('jobs.promotion.premium_plus')),
					'values' => $params,
				));
				break;

			default:
				throw new HTTP_Exception_404;
		}

		if($form->validate())
		{
			$values = $form->get_values();
			foreach($values as $name => $value)
			{
				$config->set($name, $value);
			}
			FlashInfo::add('jobs.admin.payments.success', 'success');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'admin.settings.payment.title' => '/admin/settings/payments',
			$this->template->set_title(___('jobs.admin.payments.title')) => '/admin/job/settings/payments?form=' . $form_type,
		));

		$this->template->content = View::factory('jobs/admin/settings_payment')
			->set('form', $form);
	}

}
