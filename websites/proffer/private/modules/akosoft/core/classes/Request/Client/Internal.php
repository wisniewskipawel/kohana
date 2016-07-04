<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

class Request_Client_Internal extends Kohana_Request_Client_Internal {

	/**
	 * Processes the request, executing the controller action that handles this
	 * request, determined by the [Route].
	 *
	 *     $request->execute();
	 *
	 * @param   Request $request
	 * @return  Response
	 * @throws  Kohana_Exception
	 * @uses    [Kohana::$profiling]
	 * @uses    [Profiler]
	 */
	public function execute_request(Request $request, Response $response)
	{
		//redirect to secure connection if needed
		if($request->route()->get_secure() === TRUE AND !$request->secure())
		{
			return $response->headers('Location', $request->url('https'));
		}

		$prefix = '';
		
		if($namespace = $request->route()->get_namespace())
		{
			$prefix = $namespace;

			// Directory
			$directory = $request->directory();

			if ($directory)
			{
				// Add the directory name to the class prefix
				$prefix .= ucfirst(str_replace('/', '\\', trim($directory, '/')).'\\');
			}

			// Controller
			$controller = ucfirst($request->controller()).'Controller';
		}
		else
		{
			// Create the class prefix
			$prefix = 'Controller_';

			// Directory
			$directory = $request->directory();

			// Controller
			$controller = $request->controller();

			if ($directory)
			{
				// Add the directory name to the class prefix
				$prefix .= str_replace(array('\\', '/'), '_', trim($directory, '/')).'_';
			}
		}
		
		if (Kohana::$profiling)
		{
			// Set the benchmark name
			$benchmark = '"'.$request->uri().'"';

			if ($request !== Request::$initial AND Request::$current)
			{
				// Add the parent request uri
				$benchmark .= ' « "'.Request::$current->uri().'"';
			}

			// Start benchmarking
			$benchmark = Profiler::start('Requests', $benchmark);
		}

		// Store the currently active request
		$previous = Request::$current;

		// Change the current request to this request
		Request::$current = $request;

		// Is this the initial request
		$initial_request = ($request === Request::$initial);

		try
		{
			if ( ! class_exists($prefix.$controller))
			{
				throw HTTP_Exception::factory(404,
					'The requested URL :uri was not found on this server.',
					array(':uri' => $request->uri())
				)->request($request);
			}

			// Load the controller using reflection
			$class = new ReflectionClass($prefix.$controller);

			if ($class->isAbstract())
			{
				throw new Kohana_Exception(
					'Cannot create instances of abstract :controller',
					array(':controller' => $prefix.$controller)
				);
			}

			// Create a new instance of the controller
			$controller = $class->newInstance($request, $response);

			// Run the controller's execute() method
			$response = $class->getMethod('execute')->invoke($controller);

			if ( ! $response instanceof Response)
			{
				// Controller failed to return a Response.
				throw new Kohana_Exception('Controller failed to return a Response');
			}
		}
		catch (HTTP_Exception $e)
		{
			// Store the request context in the Exception
			if ($e->request() === NULL)
			{
				$e->request($request);
			}

			// Get the response via the Exception
			$response = $e->get_response();
		}
		catch (Exception $e)
		{
			// Generate an appropriate Response object
			$response = Kohana_Exception::_handler($e);
		}

		// Restore the previous request
		Request::$current = $previous;

		if (isset($benchmark))
		{
			// Stop the benchmark
			Profiler::stop($benchmark);
		}

		// Return the response
		return $response;
	}
	
}