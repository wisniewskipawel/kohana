<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Frontend_Jobs_Notifier extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'notifiers.forms');
		
		$this->add_input_email('email');
		
		if(Jobs::config('provinces_enabled'))
		{
			$provinces = Regions::provinces();
			Arr::unshift($provinces, 'all', ___('notifiers.forms.province.all'));

			$this->add_select('province', $provinces);
		}
		
		$categories = Model_Job_Category::factory()->get_notifier_list();
		$this->add_jobs_notifier_categories('categories', $categories);
		
		$this->add_bool('notify', array('required' => TRUE));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
