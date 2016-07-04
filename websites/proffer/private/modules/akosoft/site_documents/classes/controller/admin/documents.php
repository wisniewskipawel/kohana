<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Documents extends Controller_Admin_Main {

	public function action_index()
	{
		$pager = Pagination::factory(array(
			'items_per_page'        => 20,
			'view'                  => 'pagination/admin',
			'total_items'           => ORM::factory('Document')->count_all()
		));

		$documents = ORM::factory('Document')->get_all_admin($pager->offset, $pager->items_per_page);

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			$this->set_title(___('documents.title'))	=> '/admin/documents/index',
		));

		$this->template->content = View::factory('admin/documents/index')
				->set('documents', $documents)
				->set('pager', $pager);
	}

	public function action_add()
	{
		$form = Bform::factory('Admin_Documents_Add');

		if ($form->validate())
		{
			ORM::factory('Document')->add_document($form->get_values(), $form->get_files());
			
			FlashInfo::add(___('documents.add.success'), 'success');
			$this->redirect('/admin/documents/');
		}

		$content = View::factory('admin/documents/add_document')
			->set('form', $form);

		$this->template->content = $content;

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'documents.title'	=> '/admin/documents',
			$this->set_title(___('documents.add.title'))	=> '/admin/documents/add',
		));
	}

	public function action_edit()
	{
		$document = ORM::factory('Document', $this->request->param('id'));

		$form = Bform::factory('Admin_Documents_Edit', $document->as_array());

		if ($form->validate())
		{
			$document->values($form->get_values());
			$document->save();
			
			FlashInfo::add(___('documents.edit.success'), 'success');
			$this->redirect('/admin/documents');
		}

		$content = View::factory('admin/documents/edit_document')
			->set('form', $form)
			->set('document', $document);

		$this->template->content = $content;

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'documents.title'	=> '/admin/documents/index',
			$this->set_title(___('documents.edit.title'))	=> '/admin/documents/edit',
		));
	}


	public function action_delete()
	{
		$document = ORM::factory('Document')->where('document_id', '=', $this->request->param('id'))->find();
		$document->delete();
		
		FlashInfo::add(___('documents.delete.success', 'one'), 'success');
		$this->redirect('/admin/documents');
	}

	public function action_many()
	{
		$post = $this->request->post();
		
		if (isset($post['documents']) && isset($post['action']))
		{
			$documents = ORM::factory('Document')->where('document_id', 'IN', $post['documents'])->find_all();

			if ($post['action'] == 'delete' && $this->_auth->permissions('admin/documents/delete'))
			{
				foreach ($documents as $d)
				{
					$d->delete();
				}
				
				FlashInfo::add(___('documents.delete.success', 'many'), 'success');
			}
		}

		$this->redirect_referrer();
	}
}
