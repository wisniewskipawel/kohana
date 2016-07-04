<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Document_Placement extends ORM {

	protected $_table_name = 'document_placements';
	protected $_primary_key = 'document_placement_id';
	protected $_primary_val = 'document_placement';

	protected $_belongs_to = array(
		'document' => array('model' => 'Document', 'foreign_key' => 'document_id')
	);

	public function get_links_from_place($place)
	{
		return $this->where('document_placement', '=', $place)
			->with('document')
			->find_all();
	}

	public function add_link(array $values)
	{
		$this->values($values)->save();
	}
	
}
