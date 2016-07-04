<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class ImageProcessor {

	/**
	 * @var string
	 */
	protected $image_path;

	/**
	 * @var Image
	 */
	protected $image;

	/**
	 * @var array
	 */
	protected $config_type;

	/**
	 * ImageProcessor constructor.
	 * @param string $image_path
	 * @param array $config_type
	 */
	public function __construct($image_path, $config_type)
	{
		$this->image_path = $image_path;
		$this->config_type = $config_type;

		$this->image = Image::factory($this->image_path);
	}

	/**
	 * @return Image
	 */
	public function execute()
	{
		$config_type = $this->config_type;

		$orig_width = $this->image->width;
		$orig_height = $this->image->height;

		// wymiary
		$width = $config_type['width'];
		$height = $config_type['height'];

		if ( ! empty($config_type['watermark']))
		{
			$this->do_watermark();
		}

		if ($config_type['resize'] && !isset($config_type['resize_mode'])
		    && ($orig_width > $width || $orig_height > $height)
		)
		{
			// jesli ma byc obciety zmniejsz wg krotszego boku
			if ($config_type['crop'])
			{
				$this->image->resize($width, $height, ($orig_width > $orig_height ? Image::HEIGHT : Image::WIDTH));
			}
			// zmniejsz po dluzszym boku tylko te zdjecia ktore maja wiekszy wymiar
			elseif ($width == $height)
			{
				// dluzsza szerokosc
				if ($orig_width > $orig_height)
				{
					if ($orig_width > $width)
					{
						$this->image->resize($width, $height, Image::WIDTH);
					}
				}
				// dluzsza wysokosc
				elseif ($orig_width < $orig_height)
				{
					if ($orig_height > $height)
					{
						$this->image->resize($width, $height, Image::HEIGHT);
					}
				}
				// rowne dlugosci bokow
				else
				{
					$this->image->resize($width, $height, Image::AUTO);
				}
			}
			// ustaw wg rozmiaru z konfiguracji
			else
			{
				$resize_mode = Arr::get($config_type, 'resize_mode', Image::AUTO);
				$this->image->resize($width, $height, $resize_mode);
			}
		}

		// przytnij
		if ($config_type['crop'])
		{
			$this->image->crop($width, $height);
		}

		if(!Arr::get($config_type, 'allow_transparent', FALSE))
		{
			//set bg color for transparent images
			$this->image->background('#fff');
		}

		return $this->image;
	}

	/**
	 * @throws Kohana_Exception
	 */
	protected function do_watermark()
	{
		if (!Kohana::$config->load('global.site.watermark.enabled')
		    || ! file_exists(DOCROOT.'_upload/watermark.png')
		)
		{
			return;
		}

		$opacity = Kohana::$config->load('global.site.watermark.opacity');
		$placement = Kohana::$config->load('global.site.watermark.placement');

		$watermark = Image::factory(DOCROOT.'_upload/watermark.png');
		$watermark->resize($this->image->width/4, $this->image->height/4);

		if ($placement == 'top_left')
		{
			$this->image->watermark($watermark, FALSE, FALSE, $opacity);
		}
		elseif ($placement == 'top_right')
		{
			$this->image->watermark($watermark, $this->image->width - $watermark->width - 5, FALSE, $opacity);
		}
		elseif ($placement == 'bottom_left')
		{
			$this->image->watermark($watermark, FALSE, TRUE, $opacity);
		}
		elseif ($placement == 'bottom_right')
		{
			$this->image->watermark($watermark, $this->image->width - $watermark->width - 5, TRUE, $opacity);
		}
		elseif ($placement == 'top_center')
		{
			$this->image->watermark($watermark, floor( ( $this->image->width - $watermark->width ) / 2 ), FALSE, $opacity);
		}
		elseif ($placement == 'bottom_center')
		{
			$this->image->watermark($watermark, floor( ( $this->image->width - $watermark->width ) / 2 ), TRUE, $opacity);
		}
	}

}