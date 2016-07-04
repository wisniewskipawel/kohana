<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Events_Template_Default_Settings extends Event {
	
	public function on_form_appearance_create()
	{
		$form = $this->param('form');
		
		$form->general->add_select('template_style', array(
			NULL	=> ___('templates.default'),
			'yellow' => ___('templates.yellow'),
			'brown'	=> ___('templates.brown'),
			'green'	=> ___('templates.green'),
			'turquoise'=> ___('templates.turquoise'),
			'violet'	=> ___('templates.violet'),
			'custom'	=> ___('templates.custom'),
		), array(
			'required' => FALSE,
		));
		
		//Tab homepage modules
		
		$homepage_boxes_tab = $form->add_tab('homepage_boxes', ___('frontend.settings.home_boxes_tab'), array(
			'get_values_path' => 'templates.frontend',
			'set_values_path' => 'templates.frontend',
		));
		
		$on_off_select = array(
			FALSE => ___('frontend.settings.off'),
			TRUE => ___('frontend.settings.on'),
		);
		
		if(Modules::enabled('site_ads'))
		{
			$homepage_boxes_tab->add_collection('site_ads')
				->add_select('index_box_enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_ads.index_box_enabled'),
					'required' => FALSE,
				));
		}
		
		if(Modules::enabled('site_announcements'))
		{
			$homepage_boxes_tab->add_collection('site_announcements')
				->add_select('index_recommended_box_enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_announcements.index_recommended_box_enabled'),
					'required' => FALSE,
				));
		}
		
		if(Modules::enabled('site_newsletter'))
		{
			$homepage_boxes_tab->add_collection('site_newsletter')
				->add_select('index_box_enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_newsletter.index_box_enabled'),
					'required' => FALSE,
				));
		}
		
		if(Modules::enabled('site_catalog'))
		{
			$homepage_boxes_tab->add_collection('site_catalog', array(
				'get_values_path' => 'site_catalog.widgets.recommended',
				'set_values_path' => 'site_catalog.widgets.recommended',
			))
				->add_select('enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_catalog.widgets.recommended.enabled'),
					'required' => FALSE,
				));
		}
		
		$homepage_boxes_tab->add_select('modules_box_enabled', $on_off_select, array(
				'label' => ___('frontend.settings.modules_box_enabled'),
				'required' => FALSE,
			));
		
		$tab = $form->add_tab('templates_default', ___('frontend.settings.template'), array(
			'get_values_path' => 'templates.frontend',
			'set_values_path' => 'templates.frontend',
		));
		
		$tab->add_bool('map_enabled', array(
			'label' => ___('frontend.settings.map_enabled'),
		));

		if(Modules::enabled('site_announcements'))
		{
			$module_collection = $tab->add_fieldset('site_announcements', ___('frontend.settings.site_announcements'), array(
				'get_values_path' => 'site_announcements',
				'set_values_path' => 'site_announcements',
			));
			
			$module_collection->add_input_file('announcements_no_map', array(
				'label' => ___('frontend.settings.info_box_no_map'),
				'required' => FALSE,
			))
				->add_validator('announcements_no_map', 'Bform_Validator_File_Image');
			
			$module_collection->add_input_file('announcements_home_top', array(
				'label' => ___('frontend.settings.site_announcements.home_top'),
				'required' => FALSE,
			))
				->add_validator('announcements_home_top', 'Bform_Validator_File_Image');
		}

		if(Modules::enabled('site_catalog'))
		{
			$module_collection = $tab->add_fieldset('site_catalog', ___('frontend.settings.site_catalog'), array(
				'get_values_path' => 'site_catalog',
				'set_values_path' => 'site_catalog',
			));
			
			$module_collection->add_input_file('catalog_no_map', array(
				'label' => ___('frontend.settings.info_box_no_map'),
				'required' => FALSE,
			))
				->add_validator('catalog_no_map', 'Bform_Validator_File_Image');
			
			$module_collection->add_input_file('catalog_home_top', array(
				'label' => ___('frontend.settings.site_catalog.home_top'),
				'required' => FALSE,
			))
				->add_validator('catalog_home_top', 'Bform_Validator_File_Image');
		}

		if(Modules::enabled('site_offers'))
		{
			$module_collection = $tab->add_fieldset('site_offers', ___('frontend.settings.site_offers'), array(
				'get_values_path' => 'site_offers',
				'set_values_path' => 'site_offers',
			));
			
			$module_collection->add_input_file('offers_no_map', array(
				'label' => ___('frontend.settings.info_box_no_map'),
				'required' => FALSE,
			))
				->add_validator('offers_no_map', 'Bform_Validator_File_Image');
			
			$module_collection->add_input_file('offers_home_top', array(
				'label' => ___('frontend.settings.site_offers.home_top'),
				'required' => FALSE,
			))
				->add_validator('offers_home_top', 'Bform_Validator_File_Image');
		}
		
		if(Modules::enabled('site_jobs'))
		{
			$module_collection = $tab->add_fieldset('site_jobs', ___('frontend.settings.site_jobs'), array(
				'get_values_path' => 'site_jobs',
				'set_values_path' => 'site_jobs',
			));
			
			$module_collection->add_input_file('jobs_home_top', array(
				'label' => ___('frontend.settings.site_jobs.home_top'),
				'required' => FALSE,
			))
				->add_validator('jobs_home_top', 'Bform_Validator_File_Image');
		}
	}
	
	public function on_form_appearance_save()
	{
		$form = $this->param('form');
		$files = $form->get_files();
		
		$this->_save_image($files, 'announcements_no_map', 'media/announcements/img/no_map.png');
		$this->_save_image($files, 'announcements_home_top', 'media/announcements/img/info_box.png');
		
		$this->_save_image($files, 'catalog_no_map', 'media/catalog/img/no_map.png');
		$this->_save_image($files, 'catalog_home_top', 'media/catalog/img/info_box.png');
		
		$this->_save_image($files, 'offers_no_map', 'media/offers/img/no_map.png');
		$this->_save_image($files, 'offers_home_top', 'media/offers/img/info_box.png');
		
		$this->_save_image($files, 'jobs_home_top', 'media/jobs/img/info_box.png');
	}
	
	protected function _save_image($files, $file_key, $save_path)
	{
		if (isset($files[$file_key]) AND Upload::valid($files[$file_key]) 
			AND Upload::not_empty($files[$file_key])
		)
		{
			if(Kohana::$environment != Kohana::DEMO)
			{
				$dirname = DOCROOT.ltrim(dirname($save_path), DIRECTORY_SEPARATOR);
				$basename = basename($save_path);
				
				if(!is_dir($dirname))
					mkdir($dirname, 0777, TRUE);

				Upload::save($files[$file_key], $basename, $dirname);
			}
			else
			{
				FlashInfo::add(___('demo_mode_error'), 'error');
			}
		}
	}
	
}

