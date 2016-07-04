<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Documents_Frontend extends Events {
	
	public function on_before()
	{
		$template = $this->param('template');
		
		$model = new Model_Document_Placement;
		
		$template->links_footer = $model->get_links_from_place('footer');
	}
	
	public function on_documents_footer()
	{
		$documents = ORM::factory('Document_Placement')
				->with('document')
				->find_all();

		return View::factory('component/documents/frontend_footer')
				->set('documents', $documents);
	}
}
