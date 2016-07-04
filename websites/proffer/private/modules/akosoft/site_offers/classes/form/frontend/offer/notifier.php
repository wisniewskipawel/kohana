<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Offer_Notifier extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'notifiers.forms');
		
		$this->add_input_email('email');

		if(Kohana::$config->load('modules.site_offers.settings.provinces_enabled'))
		{
			$provinces = Regions::provinces();
			Arr::unshift($provinces, 'all', ___('notifiers.forms.province.all'));

			$this->add_select('province', $provinces);
		}

		$categories = ORM::factory('Offer_Category')->get_main_list();
		$this->add_offers_categories('categories', $categories);

		$this->add_bool('notify', array('required' => TRUE));

		$this->add_input_submit(___('form.save'));
	}

}
