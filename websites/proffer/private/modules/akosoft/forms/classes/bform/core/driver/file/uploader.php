<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Bform_Core_Driver_File_Uploader extends Bform_Driver_Common {

	const TYPE_IMAGES = 'images';

	public $_custom_data = array(
		'_data'     => array(
			'required' => FALSE,
			'amount' => 1,
			'type' => self::TYPE_IMAGES,
			'errors' => array(),
			'driver_template' => 'bform/shared/drivers/file/uploader',
		),
	);

	/**
	 * @var Bform_File_Base[]
	 */
	protected $_valid_files = NULL;

	/**
	 * @var null|array
	 */
	protected $_tmp_files = NULL;

	/**
	 * @var Bform_File_Detached[]|Bform_File_Uploaded[]
	 */
	protected $_uploaded_files = NULL;

	/**
	 * @var string
	 */
	private $_tmp_path = NULL;

	/**
	 * @var bool
	 */
	private $is_files_proccessed = FALSE;

	/**
	 * Bform_Core_Driver_File_Uploader constructor.
	 * @param Bform_Core_Form $form
	 * @param $name
	 * @param array $info
	 */
	public function __construct(Bform_Core_Form $form, $name, array $info = array())
	{
		parent::__construct($form, $name, $info);

		$this->_tmp_path = Upload::$default_directory.'/tmp/uploader/';
		$base_tmp_path = DOCROOT.$this->_tmp_path;

		if(!is_dir($base_tmp_path))
		{
			if(!mkdir($base_tmp_path, 0777, TRUE))
			{
				throw new RuntimeException(sprintf(
					'File uploader temporary path: "%s" cannot be created!',
					Debug::path($base_tmp_path)
				));
			}
		}

		if(!empty($info['files']))
		{
			$this->_valid_files = $info['files'];
		}
	}

	/**
	 * @return Bform_File_Base[]
	 */
	public function get_files()
	{
		return $this->_valid_files;
	}

	/**
	 * @return array
	 */
	public function get_value()
	{
		$paths = array();

		if($this->_valid_files)
		{
			foreach($this->_valid_files as $file)
			{
				if($file instanceof Bform_File_Detached)
				{
					$paths[] = $file->getFullPath();
				}
				elseif($file instanceof Bform_File_Uploaded)
				{
					$paths[] = $file->getFullPath();
				}
			}
		}

		return $paths;
	}

	/**
	 * @param $values
	 */
	public function set_values($values)
	{
		if(!$this->is_files_proccessed)
		{
			$this->_valid_files = array();
			$this->_get_tmp_files($values);
			$this->_get_uploaded_files($_FILES);

			$this->is_files_proccessed = TRUE;
		}
	}

	/**
	 * @param $values
	 * @return array|null
	 */
	public function _get_tmp_files($values)
	{
		$files = Arr::get($values, '_uploaded_files');

		if(!count($files))
		{
			return array();
		}

		$limit = $this->get_amount_left();
		$i = 0;

		foreach($files as $fileInfo)
		{
			if($i > $limit)
				break;

			$fileInfo = $this->file_info_decode($fileInfo);

			if($fileInfo['type'] == 'detached')
			{
				if(!empty($fileInfo['file_name']))
				{
					//prevent directory traversal attacks - we need only file name
					$fileInfo['file_name'] = basename($fileInfo['file_name']);
				}

				//build full path to file
				$fileInfo['path'] = $this->_tmp_path.basename($fileInfo['path']);

				if(!file_exists($fileInfo['path']))
					continue;

				//check for directory traversal attacks
				if(!$this->_validate_tmp_path($fileInfo['path']))
				{
					throw new UnexpectedValueException(sprintf(
						'Uploaded file path is not correct! Path "%s" is out of base directory: "%s".',
						Debug::path($fileInfo['path']),
						Debug::path(DOCROOT.$this->_tmp_path)
					));
				}
			}

			$file = Bform_File_Base::createFromFileInfoArray($fileInfo);
			$this->_valid_files[] = $this->_tmp_files[] = $file;
			$i++;
		}

		return $this->_tmp_files;
	}

	/**
	 * @param $values
	 * @return array|Bform_File_Detached[]|Bform_File_Uploaded[]
	 */
	protected function _get_uploaded_files($values)
	{
		if($this->_uploaded_files !== NULL)
		{
			return $this->_uploaded_files;
		}

		$uploaded_files = array();
		$files = Bform_File_Uploaded::parseUploadedFiles($values);
		$name = (string)$this->data('name');

		if(!empty($files[$name]))
		{
			$limit = $this->get_amount_left();
			$i = 0;

			foreach($files[$name] as $uploadedFile)
			{
				/** @var Bform_File_Uploaded $uploadedFile */

				if($i > $limit)
					break;

				$error = $this->_validate($uploadedFile);

				if($error === FALSE)
				{
					$detachedFile = $uploadedFile->moveTo(DOCROOT.$this->_tmp_path.uniqid().'_'.$uploadedFile->getSafeFilename());
					$detachedFile->setDownloadUrl($this->get_web_path($detachedFile));

					$this->_valid_files[] = $uploaded_files[] = $detachedFile;
					$i++;
				}
				else
				{
					$uploadedFile->setError($error);
					$uploaded_files[] = $uploadedFile;

					$this->set_error($error);
				}
			}
		}

		return $this->_uploaded_files = $uploaded_files;
	}

	/**
	 * @return integer
	 */
	public function get_amount_left()
	{
		return $this->data('amount') - count($this->_valid_files);
	}

	/**
	 * @param Bform_File_Uploaded $file
	 * @return bool|string
	 * @throws Kohana_Exception
	 */
	protected function _validate(Bform_File_Uploaded $file)
	{
		if(!$file->isValid())
		{
			return ___('Upload is invalid!');
		}

		//size check
		$max_upload_size = Kohana::$config->load('img.max_upload_size');

		if(!$this->_validate_size($file, $max_upload_size))
		{
			return ___('bform.validator.file_filesize', array(':filesize' => $max_upload_size));
		}

		//type check
		switch($this->data('type'))
		{
			case self::TYPE_IMAGES:
				if(!self::validate_image($file))
				{
					return ___('bform.validator.file_image');
				}
				break;

			default:
				throw new UnexpectedValueException(sprintf('Not supported type: %s', $this->data('type')));
		}

		return FALSE;
	}

	/**
	 * @param Bform_File_Uploaded $file
	 * @return bool
	 */
	public static function validate_image(Bform_File_Uploaded $file)
	{
		if(!in_array($file->getExtension(), array('png', 'gif', 'jpg', 'jpeg')))
		{
			return FALSE;
		}

		try
		{
			list($width, $height) = getimagesize($file->getFullPath());
		}
		catch (ErrorException $e)
		{
		}

		if (empty($width) OR empty($height))
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * @param Bform_File_Detached $file
	 * @param $size
	 * @return bool
	 * @throws Kohana_Exception
	 */
	protected function _validate_size(Bform_File_Detached $file, $size)
	{
		// Convert the provided size to bytes for comparison
		$size = Num::bytes($size);

		// Test that the file is under or equal to the max size
		return ($file->getSize() <= $size);
	}

	/**
	 * @param $tmp_path
	 * @return bool
	 */
	protected function _validate_tmp_path($tmp_path)
	{
		$tmp_path = realpath($tmp_path);
		return strpos($tmp_path, realpath(DOCROOT.$this->_tmp_path)) === 0;
	}

	/**
	 * @param Bform_File_Detached $file
	 * @return null|string
	 */
	public function get_web_path(Bform_File_Detached $file)
	{
		if($this->data('type') == self::TYPE_IMAGES)
		{
			return URL::site($file->getSafePath(), 'http');
		}

		return NULL;
	}

	/**
	 * @param array $file_info
	 * @return string
	 */
	public function file_info_encode(array $file_info)
	{
		$file_info = json_encode($file_info);
		$file_info = base64_encode($file_info);
		return (string)$file_info;
	}

	/**
	 * @param string $string
	 * @return mixed
	 */
	public function file_info_decode($string)
	{
		$string = base64_decode($string);
		$array = json_decode($string, TRUE);
		return $array;
	}


}