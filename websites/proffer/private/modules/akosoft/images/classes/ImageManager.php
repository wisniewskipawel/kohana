<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class ImageManager {

	/**
	 * @var string
	 */
	protected $place;

	/**
	 * @var string
	 */
	protected $directory;

	/**
	 * @var array
	 */
	protected $types;

	/**
	 * ImageManager constructor.
	 * @param string $place
	 * @param string|null $directory
	 * @param array|null $config_type_name
	 */
	public function __construct($place, $directory = NULL, $config_type_name = NULL)
	{
		$this->place = $place;
		$this->directory = $directory !== NULL ? $directory : $place;
		$this->types = img::types($config_type_name !== NULL ? $config_type_name : $place);

		if(!in_array('original', $this->types))
		{
			$this->types['original'] = img::type_config('original');
		}
	}

	/**
	 * @param $image_file_path
	 * @param $object_id
	 * @return bool
	 * @throws Exception
	 */
	public function save_image($image_file_path, $object_id)
	{
		$image = new Model_Image();
		$image->object_id = $object_id;
		$image->object_type = $this->place;
		$image->image = time();
		$image->save();

		return $this->process_image($image_file_path, $image);
	}

	/**
	 * @param $uploaded_file_path
	 * @param Model_Image $image
	 * @return bool
	 * @throws Exception
	 * @throws Kohana_Exception
	 */
	protected function process_image($uploaded_file_path, Model_Image $image)
	{
		$img_date = $image->image;
		$img_id = $image->pk();

		$dir = DOCROOT.Upload::$default_directory.'/'.$this->directory.'/'.date('Y/m/d/', $img_date);

		if(!is_dir($dir))
		{
			if(!mkdir($dir, 0777, true))
			{
				throw new Exception("Directory $dir cannot be created!");
			}
		}

		foreach($this->types as $type => $type_config)
		{
			if($image = img::process_image($uploaded_file_path, $type_config))
			{
				$file_name = $img_date.'_'.$img_id.'_'.$type_config['flag'].'.'.Arr::get($type_config, 'extension', img::$default_extension);
				$image->save($dir.$file_name, Arr::get($type_config, 'quality', 100));
			}
		}

		unlink($uploaded_file_path);

		return TRUE;
	}

	/**
	 * @param $object_id
	 * @return ImageCollection
	 */
	public function find_images_by_object_id($object_id)
	{
		$image = new Model_Image();

		$images = DB::select()
			->from($image->table_name())
			->where('object_id', '=', (int)$object_id)
			->where('object_type', '=', $this->place)
			->order_by('image_id', 'ASC')
			->execute()
			->as_array('image_id');

		return new ImageCollection($images, $this);
	}

	/**
	 * @param $image_id
	 * @param null $object_id
	 * @return bool
	 */
	public function delete($image_id, $object_id = NULL)
	{
		$image = new Model_Image();

		if($object_id)
		{
			$image = $image->find_object_image($object_id, $image_id);
		}
		else
		{
			$image = $image->find_by_pk($image_id);
		}

		if($image AND $image->loaded())
		{
			$image_data = $image->as_array();
			$image->delete();

			$this->delete_files($image_data);

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * @param $object_id
	 */
	public function delete_by_object($object_id)
	{
		$image = new Model_Image();

		$images = DB::select('image_id', 'image')
			->from($image->table_name())
			->where('object_type', '=', $this->place)
			->where('object_id', is_array($object_id) ? 'IN' : '=', $object_id)
			->execute()
			->as_array('image_id');
		
		if(!empty($images))
		{
			foreach($images as $image_id => $image_data)
			{
				$this->delete_files($image_data);
			}

			DB::delete($image->table_name())
				->where('image_id', 'IN', array_keys($images))
				->execute();
		}
	}

	/**
	 * @param $image_data
	 * @return bool
	 */
	public function delete_files($image_data)
	{
		foreach($this->types as $type => $config)
		{
			$path = $this->get_disk_path($type, $image_data);
			@unlink($path);
		}
		
		return TRUE;
	}

	/**
	 * @param $type
	 * @param $image_data
	 * @return bool
	 */
	public function exists($type, $image_data)
	{
		return file_exists($this->get_disk_path($type, $image_data));
	}

	/**
	 * @param $type
	 * @param $image_data
	 * @return string
	 */
	public function get_uri($type, $image_data)
	{
		return $this->_path($type, $image_data);
	}

	/**
	 * @param $type
	 * @param $image_data
	 * @param null $protocol
	 * @return string
	 */
	public function get_url($type, $image_data, $protocol = NULL)
	{
		return URL::site($this->get_uri($type, $image_data), $protocol);
	}

	/**
	 * @param $type
	 * @param $image_data
	 * @return string
	 */
	public function get_disk_path($type, $image_data)
	{
		return DOCROOT.$this->_path($type, $image_data);
	}

	/**
	 * @param $type
	 * @param $image_data
	 * @return string
	 */
	protected function _path($type, $image_data)
	{
		$image_id = Arr::get($image_data, 'image_id');
		$image_date = Arr::get($image_data, 'image', FALSE);
		$config_type = $this->types[$type];

		$path = Upload::$default_directory.'/'.$this->directory.'/';

		if($image_date === FALSE)
		{
			$path .= $image_id.'/'.$config_type['flag'];
		}
		else
		{
			$path .= date('Y/m/d', $image_date).'/'.$image_date.'_'.$image_id.'_'.$config_type['flag'];
		}

		if(!empty($config_type['extension']))
		{
			return $path.'.'.$config_type['extension'];
		}

		if(!empty($image_data['extension']))
		{
			return $path.'.'.$image_data['extension'];
		}

		if(img::$default_extension != 'png')
		{
			foreach(array(img::$default_extension, 'png') as $extension)
			{
				if(file_exists($path . '.' . $extension))
				{
					return $path . '.' . $extension;
				}
			}
		}

		return $path.'.'.img::$default_extension;
	}

}
