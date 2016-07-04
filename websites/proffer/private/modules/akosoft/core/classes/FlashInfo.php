<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class FlashInfo {
	
	const SUCCESS	= 'success';
	const ERROR	= 'error';
	const INFO	= 'info';
	const WARNING	= 'warning';
	
	protected static function _session()
	{
		return Session::instance();
	}

	public static function add($msg, $class = self::SUCCESS, $force_change = FALSE) 
	{
		$info = array(
			'msg' => $msg,
			'class' => $class,
		);
		
		$session = self::_session();
		$messages = array();
		
		if ($force_change) 
		{
			$messages[] = $info;
			$session->set('flashinfo', $messages);
		}
		else 
		{
			$messages = (array)$session->get('flashinfo', array());
			$messages[] = $info;
		}
			
		$session->set('flashinfo', $messages);
	}
	
	public static function display($msg, $type = self::INFO)
	{
		return '<div class="flashinfo ' . $type . '">' . ___($msg) . '</div>';
	}

	public static function render()
	{
		$messages = self::_session()->get_once('flashinfo');
		
		if(!$messages)
			return NULL;
		
		$html = '';
		
		foreach($messages as $message)
		{
			if(isset($message['msg']) AND isset($message['class']))
			{
				$html .= self::display($message['msg'], $message['class']);
			}
		}
		
		return $html;
	}
}
