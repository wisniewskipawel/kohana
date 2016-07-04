<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Kohana_Exception extends Kohana_Kohana_Exception {

	/**
	 * Creates a new translated exception.
	 *
	 *     throw new Kohana_Exception('Something went terrible wrong, :user',
	 *         array(':user' => $user));
	 *
	 * @param   string          $message    error message
	 * @param   array           $variables  translation variables
	 * @param   integer|string  $code       the exception code
	 * @param   Exception       $previous   Previous exception
	 * @return  void
	 */
	public function __construct($message = "", $variables = NULL, $code = 0, Exception $previous = NULL)
	{
		if(function_exists('__'))
		{
			// Set the message
			$message = __($message, $variables);
		}
		else
		{
			$message = strtr($message, (array)$variables);
		}
		
		// Pass the message and integer code to the parent
		Exception::__construct($message, (int) $code, $previous);

		// Save the unmodified code
		// @link http://bugs.php.net/39615
		$this->code = $code;
	}
	
	public static function response(Exception $e)
	{
		if(Kohana::$environment >= Kohana::DEVELOPMENT)
		{
			$response = parent::response($e);
		}
		else
		{
			try
			{
				$view = View::factory('frontend/errors/500')
					->set('http_exception', $e);
			
				$response = Response::factory();
				$response->status(500);
				$response->headers('Content-Type', 'text/plain');
				$response->body($view->render());
			} 
			catch(Exception $ex)
			{
				$response = Response::factory();
				$response->status(500);
				$response->headers('Content-Type', 'text/plain');
				$response->body(self::text($e));
			}
		}
		
		return $response;
	}
	
	public static function text(Exception $e, $default_msg = NULL)
	{
		return sprintf('%s [ %s ]: %s ~ %s [ %d ]',
			get_class($e), $e->getCode(), 
			strip_tags($e->getMessage() ? $e->getMessage() : $default_msg), 
			Debug::path($e->getFile()), 
			$e->getLine()
		);
	}
	
}