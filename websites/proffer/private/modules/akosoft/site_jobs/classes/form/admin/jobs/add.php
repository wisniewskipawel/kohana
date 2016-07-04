<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Add extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'jobs.form');
		
		$categories = Model_Job_Category::factory()->get_select(TRUE);
		$this->add_select('category_id', $categories);

		$this->add_input_text('title')
			->add_validator('title', 'Bform_Validator_Length', array('min' => 5, 'max' => 75))
			->add_validator('title', 'Bform_Validator_Html');

		$this->add_editor('content', array('required' => FALSE, 'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_SIMPLE));

		$this->add_price('price', array('required' => FALSE));
		
		$this->add_datepicker('date_realization_limit', array(
			'required' => FALSE,
			'date_from' => date('Y-m-d'),
		));
		
		//contact data
		
		$this->add_fieldset('contact_data', '');
		
		$this->contact_data->add_select('person_type', BAuth::person_types());
		
		$this->contact_data->add_input_text('person', array(
				'label' => ___('jobs.form.person'),
				'required' => TRUE,
			))
			->add_validator('person', 'Bform_Validator_Html');

		$this->contact_data->add_input_text('telephone', array('required' => FALSE))
			->add_validator('telephone', 'Bform_Validator_Html');
		
		$this->contact_data->add_input_email('email', array('required' => TRUE));
		
		$this->contact_data->add_input_text('www', array('required' => FALSE))
			->add_filter('www', 'Bform_Filter_IDNA')
			->add_validator('www', 'Bform_Validator_Url');
		
		//localization
		
		$this->contact_data->add_fieldset('address', '');
		
		if(Jobs::config('provinces_enabled'))
		{
			$provinces = Regions::provinces();
			$this->contact_data->address->add_select('province', Arr::unshift($provinces, NULL, ___('select.choose')), array('class' => 'provinces geocode-province'));

			$couties = array(NULL => ___('select.choose_province'));
			if($this->form_data('province'))
			{
				$couties = Regions::counties($this->form_data('province'));
			}
			
			$this->contact_data->address->add_select('county', $couties, array('class' => 'counties geocode-county'));
		}
		
		$this->contact_data->address->add_input_text('city', array('required' => FALSE, 'class' => 'geocode-city'))
			->add_validator('city', 'Bform_Validator_Html');
		
		$this->contact_data->address->add_input_text('postal_code', array('required' => FALSE, 'class' => 'geocode-postalcode'))
			->add_validator('postal_code', 'Bform_Validator_Html');
		
		$this->contact_data->address->add_input_text('street', array('required' => FALSE, 'class' => 'geocode-street'))
			->add_validator('street', 'Bform_Validator_Html');
		
		$this->add_datetime('date_availability');
		
		$distinctions = Jobs::distinctions(FALSE);
		$this->add_select('distinction', Arr::unshift($distinctions, NULL, ___('select.choose')), array(
			'required' => FALSE,
		));
		
		$this->add_datetime('date_promotion_availability', array('required' => FALSE));
		
		$this->add_input_text('user_id', array(
			'label' => ___('user_id'),
			'required' => FALSE,
			'value' => BAuth::instance()->get_user()->pk(),
		))
			->add_validator('user_id', 'Bform_Validator_Integer');
		
		$this->add_input_submit(___('form.save'));
	}

}
