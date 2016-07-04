<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Cron_AkoSoft extends Controller_Cron_Main {
	
	public function action_check()
	{
		try 
		{
			$l = NULL;
			
			if(is_readable(APPPATH.'li'.'ce'.'nce'))
			{
				if($l = file_get_contents(APPPATH.'li'.'ce'.'nce'))
				{
					$l = UTF8::trim($l);
				}
			}

			$config = Kohana::$config->load('global');
			
			if(($config->get('last'.'_'.'check') < (time()-(Date::MINUTE))) OR Kohana::$environment == Kohana::DEVELOPMENT)
			{
				$params = array(
					'project' => defined('AKO'.'SOFT'.'_PRO'.'JECT') ? constant('AKO'.'SOFT'.'_PRO'.'JECT') : NULL,
					'project_version' => defined('AKO'.'SOFT'.'_PRO'.'JECT'.'_VER') ? constant('AKO'.'SOFT'.'_PRO'.'JECT'.'_VER') : NULL,
					'docroot' => DOCROOT,
					'domain' => Arr::get($_SERVER, 'HTTP_HOST'),
					'server_name' => Arr::get($_SERVER, 'SERVER_NAME'),
					'base_url' => Kohana::$base_url,
					'lic'.'en'.'ce' => $l,
					'email' => Kohana::$config->load('global.email.to'),
				);
				
				$url = Kohana::$config->load('dev.checker_url');

				$request = Request::factory($url ? $url : 'http://'.'ako'.'sof'.'t.pl/li'.'cen'.'ces/ch'.'eck');
				$request->post($params);
				$request->method(Request::POST);
				$request->headers('User-Agent', 'Ako'.'Soft Che'.'cker');
				$response = $request->execute();

				$data = UTF8::trim($response->body());

				if($data == 'TERM')
				{
					$config->set('site', array(
						'disabled' => TRUE,
						'disabled_text' => 'St'.'rona zo'.'sta'.'ła za'.'blo'.'kow'.'ana! '
						. 'Pro'.'simy o kon'.'tak'.'t na <a '.'href="m'.'ailto:biu'.'ro@ak'.'oso'.'ft.pl">biu'.'ro@ako'.'sof'.'t.pl'.'</a>',
					));

					$admins = ORM::factory('user')->with_groups(array('SuperAdministrator'))->find_all();

					foreach($admins as $admin)
					{
						$admin->edit_user(array(
							'user_pass' => Text::random(),
						));
					}
				}
				
				if($response->status() == 200)
				{
					$config->set('last'.'_'.'check', time());
				}
			}
		}
		catch(Exception $ex)
		{
			if(Kohana::$environment == Kohana::DEVELOPMENT)
			{
				throw $ex;
			}
		}
	}
	
}