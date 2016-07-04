<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

class Controller_Profile_Settings extends Controller_Profile_Main {

	public function action_change() 
	{
		$view = View::factory('profile/profile/change_settings');
		
		$form = Bform::factory('Profile_ChangePassword');
		
		$user = $this->_current_user;

		if ($form->validate()) 
		{
			if(Kohana::$environment !== Kohana::DEMO)
			{
				$values = $form->get_values();

				$user->edit_user($values);

				FlashInfo::add(___('profile.change_password.success'), 'success');
			}
			else
			{
				FlashInfo::add(___('demo_mode_error'), 'error');
			}
			
			$this->redirect_referrer();
		}

		$form_user_data = BForm::factory('Profile_UserData', array('user' => $user));

		if ($form_user_data->validate()) 
		{
			$values = $form_user_data->get_values();
			$user->data->values($values)->save();
			
			FlashInfo::add(___('profile.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		if(Modules::enabled('site_dealers') AND Model_Dealer::is_dealer($this->_current_user))
		{
			$dealer = new Model_Dealer;
			$dealer->find_by_pk($this->_current_user->pk());

			$form_dealers = BForm::factory('Profile_Dealers_Settings', array('dealer' => $dealer));

			if($form_dealers->validate())
			{
				$values = $form_dealers->get_values();
				$dealer->edit_dealer($values, $form_dealers->get_files());

				FlashInfo::add(___('profile.settings.success'), 'success');
				$this->redirect_referrer();
			}
			
			$view->set('form_dealers', $form_dealers);
		}
		
		$form_avatar = NULL;

		if(Modules::enabled('site_forum') OR Modules::enabled('site_jobs'))
		{
			$form_avatar = BForm::factory('Profile_Avatar', array('user' => $user));

			if($form_avatar->validate()) 
			{
				$values = $form_avatar->get_files();
				$user->save_avatar($values);

				FlashInfo::add(___('profile.settings.success'), 'success');
				$this->redirect_referrer();
			}
		}
		
		breadcrumbs::add(array(
			___('homepage') => Route::url('index'),
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			'profile.settings'	=> ''
		));

		$this->template->content = $view
			->set('form_user_data', $form_user_data)
			->set('form', $form)
			->set('form_avatar', $form_avatar)
			->set('user', $user);
	}
	
}
