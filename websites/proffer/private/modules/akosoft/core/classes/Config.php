<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2012, AkoSoft
*/
class Config extends Kohana_Config {
	
	public function delete_group($group_name)
	{
		foreach($this->_sources as $source)
		{
			if ( ! ($source instanceof Kohana_Config_Writer) OR ! method_exists($source, 'delete_group'))
			{
				continue;
			}

			$source->delete_group($group_name);
		}

		return $this;
	}
	
}
