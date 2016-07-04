<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class ImageManagerSimple {

	protected $path;

	/**
	 * ImageManagerSimple constructor.
	 * @param $path
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}

	/**
	 * @param $image
	 * @return bool
	 * @throws Exception
	 * @throws Kohana_Exception
	 */
	public function save_image($image, $id)
	{
		if(Upload::valid($image) AND Upload::not_empty($image))
		{
			$dir = DOCROOT.$this->path;

			if(!is_dir($dir))
			{
				if(!mkdir($dir, 0777, true))
				{
					throw new Exception("Directory $dir cannot be created!");
				}
			}

			$file = Upload::save($image);

			return Image::factory($file)
				->save($dir.$id.'.png');
		}

		return FALSE;
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function delete($id)
	{
		if($this->exists($id))
		{
			return unlink($this->get_disk_path($id));
		}

		return FALSE;
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function exists($id)
	{
		return file_exists($this->get_disk_path($id));
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function get_uri($id)
	{
		return $this->exists($id) ? $this->_path($id) : NULL;
	}

	/**
	 * @param $id
	 * @param null $protocol
	 * @return mixed|string
	 */
	public function get_url($id, $protocol = NULL)
	{
		return URL::site($this->get_uri($id), $protocol);
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function get_disk_path($id)
	{
		return DOCROOT.$this->_path($id);
	}

	/**
	 * @param $id
	 * @return string
	 */
	protected function _path($id)
	{
		return $this->path.$id.'.png';;
	}

}