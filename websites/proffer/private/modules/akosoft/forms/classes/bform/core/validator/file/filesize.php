<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_File_Filesize extends Bform_Validator_Base {
		
	protected $_filesize = '1M';

	public function __construct(Bform_Driver_Common $driver, array $options = array())
	{
		$this->_filesize = Arr::get($options, 'filesize', $this->_filesize);

		parent::__construct($driver, $options);
	}

	public function validate()
	{
		if (empty($this->_value['name']))
		{
			return TRUE;
		}
		
		if ( ! upload::size($this->_value, $this->_filesize))
		{
			$this->_error = ___('bform.validator.file_filesize', array(':filesize' => $this->_filesize));
			$this->exception();
		}
	}
}
