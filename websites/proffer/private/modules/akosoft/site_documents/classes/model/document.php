<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Document extends ORM {

	protected $_table_name = 'documents';
	protected $_primary_key = 'document_id';
	protected $_primary_val = 'document_title';

	public function get_all_admin($offset, $limit)
	{
		$result = $this->limit($limit)->offset($offset)->order_by('document_title', 'ASC')->find_all();
		return $result;
	}
	
	public function add_document($values, $files = array())
	{
		if (isset($values['url-type']) && $values['url-type'] == 'auto')
		{
			$values['document_url'] = URL::title($values['document_title']);
		}
		$values['document_is_deletable'] = 1;
		$this->values($values);
		$this->save();

		$last_insert_id = $this->document_id;
		
		$this->add_images($files);
	}

	public function add_images($files)
	{
		foreach ($files as $f)
		{
			$values['image'] = time();
			$values['object_id'] = $this->document_id;
			$values['object_type'] = 'document';

			$image = ORM::factory('Images')->values($values)->save();
			$last_insert_id = $image->image_id;

			$uploaded_file_path = upload::save($f, NULL, NULL);
			img::process('documents', array('admin_thumb'), $last_insert_id, $values['image'], $uploaded_file_path);
		}
	}
	
	public function check_url($url, $document_id = NULL)
	{
		if ($document_id != NULL)
		{
			$this->where('document_id', '<>', $document_id);
		}
		
		$this->where('document_url', '=', $url);

		return (bool) $this->count_all();
	}
	
	public function delete() 
	{
		if ($this->loaded())
		{
			DB::delete('document_placements')
					->where('document_id', '=', $this->document_id)
					->execute($this->_db);
		}
		return parent::delete();
	}
	
}
