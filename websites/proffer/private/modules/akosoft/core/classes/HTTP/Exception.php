<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class HTTP_Exception extends Kohana_HTTP_Exception {
	
	public function get_response()
    {
        if (Kohana::$environment >= Kohana::DEVELOPMENT AND !($this instanceof HTTP_Exception_503))
        {
            return parent::get_response();
        }
        else
        {
            try
			{
				if(Kohana::$log)
				{
					if(!($this instanceof HTTP_Exception_404) AND !($this instanceof HTTP_Exception_503))
					{
						Kohana_Exception::log($this);
					}
				}
				
				switch($this->getCode())
				{
					case 404:
						$view = View::factory('frontend/errors/404')
							->set('http_exception', $this);
						break;
					
					case 500:
						$view = View::factory('frontend/errors/500')
							->set('http_exception', $this);
						break;
					
					default:
						$view = View::factory('frontend/errors/default')
							->set('http_exception', $this);
						break;
				}
 
				$response = Response::factory()
					->status($this->getCode())
					->body($view->render());

				return $response;
			}
			catch (Exception $ex)
			{
				// Clean the output buffer if one exists
				ob_get_level() and ob_clean();

				// Display the exception text
				echo 'Error '.$this->getCode().': '.$this->getMessage();

				// Exit with an error status
				exit(1);
			}
        }
    }

}
