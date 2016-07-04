<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Settings extends Controller_Admin_Main {

	public function action_site() 
	{	
		$config = Kohana::$config->load('global');
		$config_modules = Kohana::$config->load('modules');

		$form = Bform::factory('Admin_Settings_Site', Arr::merge($config->as_array(), $config_modules->as_array()));

		if ($form->validate()) 
		{
			$values = $form->get_values(FALSE, FALSE);
			
			if(Kohana::$environment == Kohana::DEMO)
			{
				unset($values['site']['disabled']);
				unset($values['layout']['google_analytics_account']);
			}
			
			foreach ($values as $name => $v) 
			{
				if ($name == 'recaptcha' OR $name == 'site_catalog' OR $name == 'site_ads' OR $name == 'site_announcements' OR $name == 'site_newsletter')
				{
					$config_modules->set($name, $v);
				}
				else
				{
					$config->set($name, $v);
				}
			}
			
			$files = $form->get_files();
			
			if (isset($files['logo']) AND Upload::not_empty($files['logo']))
			{
				if(Kohana::$environment != Kohana::DEMO)
				{
					if(!is_dir(DOCROOT . 'media/img/'))
						mkdir(DOCROOT . 'media/img/', 0777, TRUE);
					
					Upload::save($files['logo'], 'logo.png', DOCROOT . 'media/img/');
				}
				else
				{
					FlashInfo::add(___('demo_mode_error'), 'error');
				}
			}
			
			if (isset($files['watermark_image']) AND Upload::not_empty($files['watermark_image']))
			{
				if(Kohana::$environment != Kohana::DEMO)
				{
					$path = Upload::save($files['watermark_image'], 'watermark.png', DOCROOT . '_upload');

					$image = Image::factory($path);

					if($image->height > 250 || $image->width > 250)
					{
						$image->resize(250, 250)
							->save();
					}
				}
				else
				{
					FlashInfo::add(___('demo_mode_error'), 'error');
				}
			}
			
			Media::clear_compiled();
			Cache::instance()->delete_all();
			
			FlashInfo::add(___('settings.site.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			$this->set_title(___('settings.site.title')) => '/admin/settings/site',
		));

		$this->template->content = View::factory('admin/settings/site')
				->set('form', $form);
	}

	public function action_security() 
	{
		if(!$this->_auth->permissions('admin/settings/site'))
			throw new HTTP_Exception_403;
		
		$config = Kohana::$config->load('global');

		$form = Bform::factory('Admin_Settings_Security', $config->as_array());

		if ($form->validate()) 
		{
			$values = $form->get_values(FALSE, FALSE);
			foreach ($values as $name => $v) 
			{
				$config->set($name, $v);
			}
			
			FlashInfo::add(___('settings.security.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			$this->set_title(___('settings.security.title'))	=> '/admin/settings/security',
		));

		$this->template->content = View::factory('admin/settings/security')
				->set('form', $form);
	}

	public function action_change_password() 
	{
		$user = $this->_auth->get_user();

		$form = Bform::factory('Admin_Settings_ChangePassword', $user->as_array());

		if ($form->validate()) 
		{
			if(Kohana::$environment !== Kohana::DEMO)
			{
				$new_password = $form->user_pass->get_value();
				if ( ! empty($new_password))
				{
					$user_values['user_pass'] = $new_password;
				}
				$user_values['user_email'] = $form->email->get_value();
				$user->edit_user($user_values);

				FlashInfo::add(___('settings.change_password.success'), 'success');
			}
			else
			{
				FlashInfo::add(___('demo_mode_error'), 'error');
			}
			
			$this->redirect_referrer();
		}

		$this->template->content = View::factory('admin/settings/change_password')
				->set('form', $form);

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			$this->set_title(___('settings.change_password.title'))   => '/admin/settings/change_password'
		));

	}

	public function action_test_email() 
	{
		$form = Bform::factory('Admin_Settings_TestEmail');

		if ($form->validate()) 
		{
			
			$subject = "Test wysyłki email ze strony " . URL::site('/', 'http');
			$message = View::factory('admin/settings/email_test_email')->render();
			$attachments = array(array('data' => 'OK', 'filename' => 'test.txt'));

			$error = '';
			
			try 
			{
				$result = Email::send($form->email->get_value(), $subject, $message, array('attachments' => $attachments));
			} 
			catch (Exception $e) 
			{
				$error = $e->getMessage();
			}
			
			if (isset($result) && $result) 
			{
				FlashInfo::add(___('settings.test_email.success'), 'success');
			}
			else 
			{
				FlashInfo::add(___('settings.test_email.error', array(
					':error' => $error
				)), 'error');
			}
			
			$this->redirect('/admin/settings/site');
		}

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			'settings.site.title' => '/admin/settings/site',
			$this->set_title(___('settings.test_email.title'))		  => ''
		));

		$this->template->content = View::factory('admin/settings/test_email')
				->set('form', $form);
	}
	
	public function action_modules()
	{
		$config_modules = Kohana::$config->load('modules');

		$form = Bform::factory('Admin_Settings_Site', $config_modules->as_array());

		if ($form->validate()) 
		{
			$values = $form->get_values(FALSE, FALSE);
			foreach ($values as $name => $v) 
			{
				
				$config_modules->set($name, $v);
				
			}

			FlashInfo::add(___('settings.modules.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			$this->set_title(___('settings.modules.title')) => '/admin/settings/site'
		));

		$this->template->content = View::factory('admin/settings/modules')
				->set('form', $form);
	}
	
	public function action_agreements() 
	{	
		$form = Bform::factory('Admin_Settings_Agreements', Site::config());

		if ($form->validate()) 
		{
			$values = $form->get_values(FALSE, FALSE);
			
			$config = Kohana::$config->load('global');
			$config->set('site', $values);
			
			FlashInfo::add(___('settings.agreements.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			$this->set_title(___('settings.agreements.title')) => '/admin/settings/agreements',
		));

		$this->template->content = View::factory('admin/settings/agreements')
				->set('form', $form);
	}
	
	public function action_appearance() 
	{	
		$config = Kohana::$config->load('global');
		
		$config_array = $config->as_array();
		$config_array['templates']['frontend'] = View_Template::instance('frontend')->config();
		
		$form = Bform::factory('Admin_Settings_Appearance', $config_array);

		if ($form->validate()) 
		{
			$values = $form->get_values(FALSE, FALSE);
			
			foreach ($values as $name => $v) 
			{
				$config->set($name, $v);
			}
		
			Events::fire('settings/form_appearance_save', array(
				'form' => $form,
			));
			
			Media::clear_compiled();
			Cache::instance()->delete_all();
			
			FlashInfo::add(___('settings.appearance.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings.title'	=> '/admin/settings',
			$this->set_title(___('settings.appearance.title')) => '/admin/settings/appearance',
		));

		$this->template->content = View::factory('admin/settings/appearance')
			->set('form', $form);
	}
	
	public function permissions()
	{
		if($this->request->action() == 'change_password')
		{
			return TRUE;
		}
		
		return parent::permissions();
	}

}

