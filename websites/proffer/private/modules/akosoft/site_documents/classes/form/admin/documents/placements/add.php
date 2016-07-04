<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Documents_Placements_Add extends Bform_Form {

	public function create(array $params = array())
	{
		$place = $params['place'];

		$documents = Model_Document::factory()
			->order_by('document_title', 'ASC')
			->find_all();

		$select[NULL] = ___('select.choose');
		foreach ($documents as $d)
		{
			if($d->document_url)
			{
				$select[$d->document_id] = $d->document_title;
			}
		}

		$this->add_input_hidden('document_placement', $place);
		$this->add_select('document_id', $select, array('label' => 'documents.forms.placements.document_id'));
		
		$this->add_input_submit(___('form.save'));
	}

}
