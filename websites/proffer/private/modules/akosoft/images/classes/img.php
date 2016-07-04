<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class img {

	public static $default_extension = 'jpg';
	
	public static function process_one($uploaded_file_path, $img_id, $place, $types = 'all')
	{
		$config = self::types();
		
		if (is_string($types))
		{
			if ($types == 'all')
			{
				$types = array_keys($config);
			}
			else
			{
				$types = array_keys(self::types($types));
			}
		}

		if ( ! in_array('original', $types))
		{
			$types[] = 'original';	
		}
		
		$output_directory = DOCROOT . Upload::$default_directory . DIRECTORY_SEPARATOR . $place . DIRECTORY_SEPARATOR . $img_id . DIRECTORY_SEPARATOR;
			
		if ( ! is_dir($output_directory))
		{
			if ( ! mkdir($output_directory, 0777, true))
			{
				throw new Kohana_Exception("Directory :path cannot be created!", array(
					':path' => Debug::path($output_directory),
				));
			}
		}

		foreach ($types as $type)
		{
			if ( ! isset($config[$type]))
				throw new Exception('[img::process] Check configuration!');

			if($image = self::process_image($uploaded_file_path, $config[$type]))
			{
				$file_name = $config[$type]['flag'] . '.' . Arr::get($config[$type], 'extension', img::$default_extension);
				$image->save($output_directory.$file_name, Arr::get($config[$type], 'quality', 100));	
			}
		}

		unlink($uploaded_file_path);

		return TRUE;
	}
	
	public static function process_place($place, $img_id, $img_date, $uploaded_file_path)
	{	
		$types = self::types($place);

		if(!in_array('original', $types))
		{
			$types['original'] = self::type_config('original');
		}

		$dir = DOCROOT.Upload::$default_directory.DIRECTORY_SEPARATOR.$place.date('/Y/m/d/', $img_date);

		if(!is_dir($dir))
		{
			if(!mkdir($dir, 0777, true))
			{
				throw new Exception("Directory $dir cannot be create!");
			}
		}

		foreach($types as $type => $type_config)
		{
			if($image = self::process_image($uploaded_file_path, $type_config))
			{
				$file_name = $img_date.'_'.$img_id.'_'.$type_config['flag'].'.'.Arr::get($type_config, 'extension', img::$default_extension);
				$image->save($dir.$file_name, Arr::get($type_config, 'quality', 100));
			}
		}

		unlink($uploaded_file_path);

		return TRUE;
	}
	
	/**
	 * @deprecated since version 1.7.2
	 * @param $place
	 * @param $types
	 * @param $img_id
	 * @param $img_date
	 * @param $uploaded_file_path
	 * @return boolean
	 * @throws Exception
	 */
	public static function process($place, $types, $img_id, $img_date, $uploaded_file_path)
	{	
		$config = self::types();
		
		if (is_string($types))
		{
			if ($types == 'all')
			{
				$types = array_keys($config);
			}
			else
			{
				$types = array_keys(self::types($types));
			}
		}

		if ( ! in_array('original', $types))
		{
			$types[] = 'original';	
		}

		$dir = DOCROOT . Upload::$default_directory . DIRECTORY_SEPARATOR . $place . date('/Y/m/d/', $img_date);

		if ( ! is_dir($dir))
		{
			if ( ! mkdir($dir, 0777, true))
			{
				throw new Exception("Directory $dir cannot be create!");
			}
		}

		foreach ($types as $type)
		{
			if ( ! isset($config[$type]))
				throw new Exception('[img::process] Check configuration!');
			
			if($image = self::process_image($uploaded_file_path, $config[$type]))
			{
				$file_name = $img_date.'_'.$img_id.'_'.$config[$type]['flag'] . '.' . Arr::get($config[$type], 'extension', img::$default_extension);
				$image->save($dir.$file_name, Arr::get($config[$type], 'quality', 100));	
			}
		}

		unlink($uploaded_file_path);

		return TRUE;
	}
	
	public static function process_image($image_path, $config_type)
	{	
		$processor = new ImageProcessor($image_path, $config_type);
		return $processor->execute();
	}

	public static function path_uri($place, $type, $img_id, $img_date = FALSE)
	{
		return self::_path($place, $type, $img_id, $img_date); 
	}
	
	public static function path($place, $type, $img_id, $img_date = FALSE)
	{
		return URL::site(self::path_uri($place, $type, $img_id, $img_date)); 
	}

	public static function image_exists($place, $type, $img_id, $img_date = FALSE)
	{
		return file_exists(DOCROOT . self::_path($place, $type, $img_id, $img_date));
	}
	
	protected static function _path($place, $type, $img_id, $img_date = FALSE)
	{
		$config = self::types();
		$path = Upload::$default_directory . '/' . $place . '/'; 
		
		if($img_date === FALSE)
		{
			$path .= $img_id . '/'.$config[$type]['flag'];
		}
		else
		{
			$path .= date('Y/m/d', $img_date) . '/' . $img_date . '_' . $img_id . '_' . $config[$type]['flag'];
		}

		if(!empty($config[$type]['extension']))
		{
			return $path.'.'.$config[$type]['extension'];
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

	public static function delete($place, $image_id, $image_date = FALSE)
	{
		$types = array_keys(self::types());

		if(!in_array('original', $types))
		{
			$types[] = 'original';
		}
		
		foreach ($types as $type)
		{
			$path = self::disk_path($place, $image_id, $image_date, $type);
			@unlink($path);
		}
	}

	public static function disk_path($place, $image_id, $image_date, $type)
	{
		$config = self::type_config($type);
		
		if (empty($config))
		{
			throw new Exception("Bad type $type!");
		}
		
		return DOCROOT . self::_path($place, $type, $image_id, $image_date);
	}
	
	public static function _get_default_driver()
	{
		try
		{
			if(Image_Imagick::check())
			{
				return 'Imagick';
			}
		}
		catch(Exception $ex)
		{
		}
		
		try
		{
			if(Image_GD::is_bundled())
			{
				return 'GD';
			}
		}
		catch(Exception $ex)
		{
		}
		
		return NULL;
	}
	
	public static function init()
	{
		$driver = Kohana::$config->load('site.image_driver');
		
		if(!$driver)
		{
			$driver = self::_get_default_driver();
		}
		
		if($driver)
		{
			Image::$default_driver = $driver;
		}
		else
		{
			throw new RuntimeException('No required default image driver!');
		}
	}
	
	public static function check_watermark()
	{
		try {
			return Image_GD::is_bundled() || Image_Imagick::check();
		}
		catch(Exception $ex)
		{
			Kohana::$log->add(Log::WARNING, 'Cannot use image watermark feature!')
				->add(Log::WARNING, $ex->getMessage())
				->write();
			
			return FALSE;
		}
	}
	
	public static function types($group = NULL)
	{
		$config = (array)Kohana::$config->load('img.types');
		
		if($group)
		{
			return Arr::get($config, $group);
		}
		
		$types = array();
		
		foreach($config as $type)
		{
			$types = array_merge($types, $type);
		}
		
		return $types;
	}
	
	public static function type_config($type)
	{
		return Arr::get(self::types(), $type);
	}
	
}
