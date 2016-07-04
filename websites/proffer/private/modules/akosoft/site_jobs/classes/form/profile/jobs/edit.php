<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Profile_Jobs_Edit extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$current_user = BAuth::instance()->is_logged() ? BAuth::instance()->get_user() : FALSE;
		
		$this->param('i18n_namespace', 'jobs.form');
		
		$job = $params['job'];
		$this->form_data($job->as_array());

		$this->add_input_text('title')
			->add_validator('title', 'Bform_Validator_Length', array('min' => 5, 'max' => 75))
			->add_validator('title', 'Bform_Validator_Html');

		$this->add_editor('content', array('required' => FALSE, 'editor_type' => 'simple'))
			->add_filter('content', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.jobs')));

		$this->add_price('price', array('required' => FALSE));
		
		$this->add_datepicker('date_realization_limit', array(
			'required' => FALSE,
			'date_from' => date('Y-m-d'),
		));
		
		//contact data
		
		$this->add_fieldset('contact_data', '');
		
		if($job->has_company())
		{
			if (Modules::enabled('site_catalog') AND $current_user)
			{
				$companies_select = Model_Catalog_Company::factory()->get_for_select_from_user($current_user);

				if($companies_select)
				{
					$this->contact_data->add_select('company_id', Arr::unshift($companies_select, NULL, ___('select.choose')), array(
						'required' => $this->form_data('person_type') == 'company' AND !$this->form_data('person'),
					));
				}
			}
		}
		else
		{
			$this->contact_data->add_select('person_type', BAuth::person_types());
			
			$this->contact_data->add_input_text('person', array(
					'label' => ___('jobs.form.person.'.$this->form_data('person_type')),
					'required' => !$this->form_data('company_id'),
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

			$this->contact_data->address->add_map('map', array(
				'required' => FALSE,
				'field_lat' => 'map_lat', 
				'field_lng' => 'map_lng',
				'geocode' => TRUE,
				'row_class' => 'full',
			));
		}

		$this->add_input_submit(___('form.save'));

		$this->template('site');
	}
	
}
