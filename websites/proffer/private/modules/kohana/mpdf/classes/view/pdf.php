<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class View_PDF extends Kohana_View {
	
	protected $_images = array();
	
	protected $_watermark = NULL;
	
	public static function factory($file = NULL, array $data = NULL)
	{
		return new View_PDF($file, $data);
	}
	
	public function set_watermark($watermark)
	{
		$this->_watermark = $watermark;
		
		return $this;
	}
	
	public function add_image($name, $path)
	{
		$this->_images[$name] = $path;
		
		return $this;
	}
	
	private function _init()
	{
		if(!class_exists('mPDF'))
		{
			define('_MPDF_TEMP_PATH', Kohana::$config->load('mpdf')->get('temp_path'));

			$directory = _MPDF_TEMP_PATH;

			if ( ! is_dir($directory))
			{
				if(!mkdir($directory, 0777, TRUE))
				{
					throw new Kohana_Exception('Cannot create directory :dir', array(':dir' => Debug::path($directory)));
				}
			}

			require Kohana::find_file('vendor', 'mpdf/mpdf');
		}
	}

	protected function _render($file = NULL)
	{
		$this->_init();
		
		$html = parent::render($file);
		
		$mpdf = new mPDF('UTF-8', 'A4');
		
		if(!empty($this->_images))
		{
			foreach($this->_images as $var_name => $path)
			{
				$mpdf->{'image_'.$var_name} = file_get_contents($path);
			}
		}
		
		if($this->_watermark)
		{
			$mpdf->SetWatermarkText($this->_watermark);
			$mpdf->showWatermarkText = true;
		}
		
		$mpdf->WriteHTML($html);
		
		return $mpdf;
	}
	
	public function render($file = NULL)
	{
		$mpdf = $this->_render($file);
		
		return $mpdf->Output('', 'S');
	}
	
	public function render_to_file($path)
	{
		$mpdf = $this->_render();
		
		return $mpdf->Output($path, 'F');
	}
	
}