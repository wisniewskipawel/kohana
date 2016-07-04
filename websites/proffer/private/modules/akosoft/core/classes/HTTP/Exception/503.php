<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class HTTP_Exception_503 extends Kohana_HTTP_Exception_503 {
	
	public function get_response()
    {
        if (Kohana::$environment >= Kohana::DEVELOPMENT)
        {
            return parent::get_response();
        }
        else
        {
            try
			{
				$view = View::factory('blank')
					->set('content', View::factory('frontend/errors/503'));
 
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
				echo Kohana_Exception::text($this);

				// Exit with an error status
				exit(1);
			}
        }
    }
	
}
