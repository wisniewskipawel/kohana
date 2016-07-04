<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

class Form_Admin_Settings_Site extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'settings.forms.site');
		
		$this->form_data($params);
		
		//Tab Email
		
		$this->add_tab('email', ___('settings.forms.site.email_tab'), array(
			'get_values_path' => 'email',
			'set_values_path' => 'email',
		));
		
		$this->email->add_input_email('from');
		
		$this->email->add_input_text('from_name');
		
		$this->email->add_input_email('to');
		
		$email_functions = array(
			'mail'	  => 'funkcja mail()',
			'smtp'	  => 'SMTP',
		);
		
		$this->email->add_select('send_function', $email_functions);
		
		$this->email->add_html(
			HTML::anchor('/admin/settings/test_email', ___('settings.test_email.btn'))
			.' '.___('settings.test_email.btn_after')
		);
		
		$this->email->add_fieldset('smtp_settings', ___('settings.forms.site.smtp_tab'), array(
			'get_values_path' => 'smtp',
			'set_values_path' => 'smtp',
		));
		
		if(Kohana::$environment !== Kohana::DEMO)
		{
			$this->email->smtp_settings->add_input_text('hostname', array('required' => FALSE));
			
			$this->email->smtp_settings->add_input_text('username', array('required' => FALSE));
			
			$this->email->smtp_settings->add_input_text('password', array( 'required' => FALSE));
			
			$this->email->smtp_settings->add_input_text('port', array('required' => FALSE));
		
			if($encryprions = Email::get_encryptions())
			{
				$this->email->smtp_settings->add_select(
					'encryption', 
					Arr::unshift($encryprions, NULL, ___('settings.forms.site.email.smtp.encryption_none')), 
					array(
						'required' => FALSE,
					)
				);
			}
		}
		else
		{
			$this->email->smtp_settings->add_html(___('demo_mode_error'));
		}
		
		//Tab META
		
		$this->add_tab('meta', ___('settings.forms.site.meta_tab'), array(
			'get_values_path' => 'site.meta',
			'set_values_path' => 'site.meta',
		));
		
		$this->meta->add_input_text('title');
		
		$this->meta->add_textarea('keywords');
		
		$this->meta->add_textarea('description');
		
		$this->meta->add_input_text('robots');
		
		//Tab Index
				
		$this->add_tab('index', ___('settings.forms.site.modules_tab'), array(
			'get_values_path' => 'site',
			'set_values_path' => 'site',
		));
		
		$this->index->add_select('home_module', Site::home_modules());
		
		$subdomain_modules = Site::subdomain_modules();
		
		if($subdomain_modules OR Site::current_subdomain_module())
		{
			$this->index->add_select('subdomain_module', Arr::unshift($subdomain_modules, NULL, ''), array(
				'required' => FALSE,
				'html_before' => ___('settings.forms.site.site.subdomain_module_info'),
			));
		}
		
		//Tab Other
		
		$this->add_tab('other', ___('settings.forms.site.other_tab'), array(
			'get_values_path' => 'site',
			'set_values_path' => 'site',
		));

		$this->other->add_bool('enable_https', array(
			'html_after' => $this->trans('site.enable_https_info'),
		));
		
		$this->other->add_bool('disabled');
		
		$this->other->add_editor('disabled_text', array(
			'required' => FALSE,
			'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_FULL,
		));
		
		$this->other->add_input_text('url')
			->add_filter('url', 'Bform_Filter_IDNA')
			->add_validator('url', 'Bform_Validator_Url');
		
		$this->other->add_html(HTML::image('/media/img/logo.png'), array('label' => 'settings.forms.site.current_logo'));
		
		$this->other->add_input_file('logo', array('required' => FALSE))
			->add_validator('logo', 'Bform_Validator_File_Image');
		
		if(Modules::enabled('akosoft_sitemap'))
		{
			$this->add_tab('sitemap', 'Sitemap', array(
				'get_values_path' => 'sitemap',
				'set_values_path' => 'sitemap',
			));
			
			$this->sitemap->add_input_text('cache_lifetime', array(
				'required' => FALSE,
			))
				->add_validator('cache_lifetime', 'BForm_Validator_Numeric');
		}
		
		//Tab watermark
		
		$this->add_tab('watermark', ___('settings.forms.site.watermark_tab'), array(
			'get_values_path' => 'site.watermark',
			'set_values_path' => 'site.watermark',
		));
		
		if(img::check_watermark())
		{
			$this->watermark->add_bool('enabled', array('required' => FALSE));

			if($this->form_data('site.watermark.enabled'))
			{
				if($watermark_exists = file_exists(DOCROOT . '_upload' . DIRECTORY_SEPARATOR . 'watermark.png'))
				{
					$this->watermark->add_html(
						HTML::image('_upload' . DIRECTORY_SEPARATOR . 'watermark.png'), 
						array('label' => 'settings.forms.site.current_watermark')
					);
				}

				$this->watermark->add_input_file('watermark_image', array('required' => !$watermark_exists))
					->add_validator('watermark_image', 'Bform_Validator_File_Image');

				$this->watermark->add_input_text('opacity')
					->add_validator('opacity', 'Bform_Validator_Range', array('min' => 1, 'max' => 100));

				$this->watermark->add_select(
					'placement', 
					array(
						NULL => ___('select.choose'),
						'top_left' => ___('settings.forms.site.watermark_placements.top_left'),
						'top_right' => ___('settings.forms.site.watermark_placements.top_right'),
						'bottom_left' => ___('settings.forms.site.watermark_placements.bottom_left'),
						'bottom_right' => ___('settings.forms.site.watermark_placements.bottom_right'),
						'top_center' => ___('settings.forms.site.watermark_placements.top_center'),
						'bottom_center' => ___('settings.forms.site.watermark_placements.bottom_center'),
					)
				);
			}
		}
		else
		{
			$this->watermark->add_html(___('settings.forms.site.watermark_requirements_error.content'), array(
				'label' => 'settings.forms.site.watermark_requirements_error.label',
			));
		}
		
		//Tab CRON
		
		$this->add_tab('cron', ___('settings.forms.site.cron_tab'));
		
		$cron_token = Kohana::$config->load('global.cron.token');
		
		if(!$cron_token)
		{
			$cron_token = strtolower(Text::random('alnum', 16));
			Kohana::$config->load('global')->set('cron.token', $cron_token);
		}
		
		$this->cron->add_html(___('settings.forms.site.cron_link', array(
			':url' => Kohana::$environment == Kohana::DEMO ? 
				___('demo_mode_error') : Route::url('cron/run', array('token' => $cron_token), 'http')
		)));
		
		
		$this->add_input_submit(___('form.save'));
	}
	
}
