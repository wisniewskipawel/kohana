<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Install extends Controller_Template {
	
	public $template = 'install/_template';
	
	public function before()
	{
		if($this->request->query('install_type') == 'akoad3')
		{
			$this->request->action('upgrade_akoad3');
		}
		
		parent::before();
	}
	
	public function action_index()
	{
		if(ORM::factory('user')->with_groups(array('SuperAdministrator'))->count_all() AND Kohana::$environment !== Kohana::DEVELOPMENT)
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Install_Account');
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$values['groups'] = array('SuperAdministrator', 'Adsystem', 'Administrator');
			$values['user_status'] = Model_User::STATUS_ACTIVE;
			$values['user_is_paid'] = TRUE;
			
			$user = new Model_User;
			$user->add_user($values);
			
			FlashInfo::add(___('install.account.success'));
			$this->redirect();
		}
		
		$this->template->content = View::factory('install/create_account')
				->set('form', $form);
	}
	
	public function action_upgrade_akoad3()
	{
		set_time_limit(0);
		
		$row_id = DB::select('config_id')
			->from('config')
			->where('config_group_name', '=', 'install')
			->where('config_key', '=', 'upgrade_akoad3')
			->as_object()
			->execute()
			->current();
		
		if(!$row_id AND Kohana::$environment !== Kohana::DEVELOPMENT)
		{
			throw new HTTP_Exception_404;
		}
		
		$this->_akoad3_images('catalog', array('catalog_company', 'catalog_company_logo'), 'catalog_companies');
		$this->_akoad3_images('announcements', array('announcement'), 'announcements');
		
		DB::delete('config')
			->where('config_id', '=', $row_id->config_id)
			->execute();
		
		$this->redirect();
	}
	
	private function _akoad3_images($place, $object_types, $img_types)
	{
		$images = DB::select('image_id', 'image', 'object_id')
			->from('images')
			->where('object_type', 'IN', $object_types)
			->as_object()
			->execute();
		
		foreach($images as $image)
		{
			$original_image = NULL;
			
			foreach (glob(
					DOCROOT.'_upload'.
					DIRECTORY_SEPARATOR.$place.
					DIRECTORY_SEPARATOR.'*'.
					DIRECTORY_SEPARATOR.'*'.
					DIRECTORY_SEPARATOR.'*'.
					DIRECTORY_SEPARATOR.$image->image.'_'.$image->image_id.'*.jpg'
				) as $file_path)
			{
				$filename = pathinfo($file_path, PATHINFO_FILENAME);
				$filename = explode('_', $filename);
				
				if($filename[2] != 'o')
				{
					unlink($file_path);
				}
				else
				{
					$original_image = $file_path;
				}
			}
			
			if($original_image)
			{
				img::process($place, $img_types, $image->image_id, $image->image, $original_image);
			}
		}
	}
	
}