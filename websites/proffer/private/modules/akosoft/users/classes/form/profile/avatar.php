<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Profile_Avatar extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->param('i18n_namespace', 'users.forms.avatar');
		
		$user = $params['user'];
		
		if($avatar = $user->get_avatar())
		{
			$this->add_html(HTML::image($avatar, array('style' => 'width: 100px')), array(
				'no_decorate' => FALSE,
				'label' => ' ',
			));
		}
		
		$this->add_input_file('avatar', array('html_before' => ___('users.forms.avatar.avatar_info')))
			->add_validator('avatar', 'Bform_Validator_File_Image')
			->add_validator('avatar', 'Bform_Validator_File_Filesize');
		
		$this->add_input_submit(___('form.save'));
	}
}
