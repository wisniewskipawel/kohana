<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Newsletter_Settings extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'newsletter.forms');
		
		$this->form_data($params);
		
		$this->add_collection('settings', array(
			'get_values_path' => 'site_newsletter.settings',
			'set_values_path' => 'site_newsletter.settings',
		));
		
		$this->settings->add_select('cron_freq', array(
			'@daily'		=> ___('newsletter.forms.cron_freq_values.daily'),
			'* */12 * * *'	=> ___('newsletter.forms.cron_freq_values.hours', 12, array(':nb' => 12)),
			'* */6 * * *'		=> ___('newsletter.forms.cron_freq_values.hours', 6, array(':nb' => 6)),
			'@hourly'		=> ___('newsletter.forms.cron_freq_values.hours', 1, array(':nb' => 1)),
			'*/30 * * * *'	=> ___('newsletter.forms.cron_freq_values.minutes', 30, array(':nb' => 30)),
			'*/10 * * * *'	=> ___('newsletter.forms.cron_freq_values.minutes', 10, array(':nb' => 10)),
		), array(
			'label' => 'newsletter.forms.cron_freq',
			'required' => FALSE,
		));
		
		$this->settings->add_textarea('submit_text', array(
			'label' => 'newsletter.forms.submit_text',
			'required' => FALSE,
		));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
