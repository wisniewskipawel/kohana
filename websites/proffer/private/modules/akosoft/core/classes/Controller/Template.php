<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Template extends Controller {

	/**
	 * @var  View  page template
	 */
	public $template = 'default';

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
		parent::before();

		if ($this->auto_render === TRUE)
		{
			if(!($this->template instanceof View_Template))
			{
				// Load the template
				$this->template = View_Template::factory($this->template);
			}
			
			$this->template->initialize();
		}
	}

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			$this->response->body($this->template->render());
		}

		parent::after();
	}

} // End Controller_Template
