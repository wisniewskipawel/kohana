<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class View_Email extends View {
	
	public static function factory($file = NULL, array $data = NULL)
	{
		$file = 'emails/'.I18n::lang().'/'.$file;
		
		return new View_Email($file, $data);
	}
	
	public function subject($set_subject = NULL)
	{
		if($set_subject)
		{
			$this->_data['subject'] = $set_subject;
		}
		
		return Arr::get($this->_data, 'subject');
	}
	
	public function render($file = NULL)
	{
		$this->set('self', $this);
		
		return parent::render($file);
	}
	
}