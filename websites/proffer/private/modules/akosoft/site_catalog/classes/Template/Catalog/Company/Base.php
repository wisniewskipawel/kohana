<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

/**
 * @property Model_Catalog_Company $current_company
 */
class Template_Catalog_Company_Base extends View_Template {

	public function initialize()
	{
		parent::initialize();

		if(!isset($this->current_user))
		{
			$this->set_global('current_user', NULL);
		}
	}

	public function get_current_tab()
	{
		return isset($this->action_tab) ? $this->action_tab : NULL;
	}

	public function get_pages()
	{
		return Events::fire('catalog/show_company/pages', array(
			'company' => $this->current_company,
		), TRUE);
	}

}