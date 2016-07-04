<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Documents_Placements extends Controller_Admin_Main {

	public function action_index()
	{
		$place = $this->request->param('id', 'footer');

		$links = ORM::factory('Document_Placement')
				->with('document')
				->where('document_placement', '=', $place)
				->order_by('document.document_title', 'ASC')
				->find_all();

		$form = Bform::factory('Admin_Documents_Placements_Add', array('place' => $place));

		if ($form->validate())
		{
			ORM::factory('Document_Placement')->add_link($form->get_values());
			FlashInfo::add(___('documents.placements.index.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'		=> '/',
			'documents.title'	=> '/admin/documents',
			$this->set_title(___('documents.placements.index.title'))    => '/admin/documents/placements/index'
		));

		$this->template->content = View::factory('admin/documents/placements/index')
				->set('links', $links)
				->set('form', $form);
	}

	public function action_delete()
	{
		$link = ORM::factory('Document_Placement', $this->request->param('id'));
		$link->delete();
		
		FlashInfo::add(___('documents.placements.delete.success'), 'success');
		$this->redirect_referrer();
	}

}
