<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Model_Image extends ORM {
	
	protected $_belongs_to = array(
		'announcement' => array('model' => 'Announcement', 'foreign_key' => 'object_id')
	);
	
	protected $_table_name = 'images';
	protected $_primary_key = 'image_id';
	protected $_primary_val = 'image';

	/**
	 * @param $object_id
	 * @param $image_id
	 * @return Model_Image|null
	 * @throws Kohana_Exception
	 */
	public function find_object_image($object_id, $image_id)
	{
		$this->where('object_id', '=', $object_id);
		$this->where('image_id', '=', $image_id);
		return $this->find()->loaded() ? $this : NULL;
	}

	public function delete_files($place) 
	{
		img::delete($place, $this->image_id, $this->image);
		return $this;
	}
	
	public function add_image(array $values)
	{
		$this->values($values)->save();
		return $this;
	}
	
	public function delete_by_object($object_type, $object_id, $place)
	{
		$images = DB::select('image_id', 'image')
			->from($this->table_name())
			->where('object_type', '=', $object_type)
			->where('object_id', is_array($object_id) ? 'IN' : '=', $object_id)
			->execute($this->_db)
			->as_array('image_id', 'image');
		
		if(!empty($images))
		{
			foreach($images as $image_id => $image)
			{
				img::delete($place, $image_id, $image);
			}

			DB::delete($this->table_name())
				->where('image_id', 'IN', array_keys($images))
				->execute($this->_db);
		}
	}

	/**
	 * @param Validation|NULL $validation
	 * @return ORM
	 * @throws Kohana_Exception
	 */
	public function create(Validation $validation = NULL)
	{
		$this->extension = img::$default_extension;

		return parent::create($validation);
	}

}
