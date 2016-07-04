<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Widget_Modules extends Widget_Box {
	
	public function render($view_file = NULL)
	{
		$modules = Events::fire('frontend/modules_box', NULL, TRUE);
		
		if($modules)
		{
			$current_module = Modules::instance()->current_module();
			
			if(count($modules) > 1 
				AND $current_module 
				AND isset($modules[0]['module']) 
				AND $modules[0]['module'] == $current_module->get_name())
			{
				$poped = array_pop($modules);
				array_unshift($modules, $poped);
			}
			
			$this->set('modules', $modules);
			
			return parent::render($view_file);
		}
	}
	
}
