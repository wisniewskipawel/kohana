<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Email {
	
	protected static $_mailer = null;
	protected static $_is_inited = FALSE;
	protected static $_config = array();

	protected static function _init()
	{

		if (self::$_is_inited) {
				return;
		}

		require_once Kohana::find_file('vendor/swift', 'swift_required');

		self::$_config = $config = Kohana::$config->load('global.email');

		switch ($config['send_function'])
		{

			case 'smtp':

				$hostname = $config['smtp']['hostname'];
				$username = $config['smtp']['username'];
				$password = $config['smtp']['password'];
				$port = $config['smtp']['port'];
				$encryption = Arr::path($config, 'smtp.encryption');

				$transport = Swift_SmtpTransport::newInstance($hostname, $port, $encryption)
						->setUsername($username)
						->setPassword($password);

				break;

			default:
				$transport = Swift_MailTransport::newInstance();
				break;
		}

		self::$_mailer = new Swift_Mailer($transport);
		self::$_is_inited = TRUE;
	}
	
	public static function send($to, $subject, $body, $params = array()) 
	{
		self::_init();

		if (empty($params['from'])) 
		{
			$from = array(self::$_config['from'] => self::$_config['from_name']);
		}
		else
		{
			if (is_array($params['from']))
			{
				$from = $params['from'];
			}
			elseif (is_string($params['from']))
			{
				$from = array($params['from'] => $params['from']);
			}
		}

		$message = Swift_Message::newInstance($subject)
				->setFrom($from)
				->setTo(array($to))
				->setBody($body)
				->setContentType("text/html");
		
		if ( ! empty($params['attachments']))
		{
			foreach ($params['attachments'] as $a) 
			{
				$message->attach(new Swift_Attachment($a['data'], $a['filename']));
			}
		}
		
		if(!empty($params['reply_to']))
		{
			$message->setReplyTo($params['reply_to']);
		}

		$result = self::$_mailer->send($message);

		return $result;	
	}
	
	public static function send_master($email, $params = array())
	{
		self::_init();
		
		if(!self::$_config['to'])
		{
			throw new Kohana_Exception('Master e-mail address is not configured!');
		}
		
		if($email instanceof View_Email)
		{
			$content = $email->render();
			$subject = $email->subject();
		}
		elseif($email instanceof Model_Email)
		{
			$content = $email->email_content;
			$subject = $email->email_subject;
		}
		else
		{
			throw new InvalidArgumentException;
		}
		
		return self::send(self::$_config['to'], $subject, $content, $params);
	}

	public static function send_administrators($email, $params = array())
	{
		if($email instanceof View_Email)
		{
			$content = $email->render();
			$subject = $email->subject();
		}
		elseif($email instanceof Model_Email)
		{
			$content = $email->email_content;
			$subject = $email->email_subject;
		}
		else
		{
			throw new InvalidArgumentException;
		}
		
		$admins = Model_User::factory()
			->with_groups(array('Administrator'))
			->find_all();
		
		$counter = 0;
		
		foreach ($admins as $a)
		{
			if(self::send($a->user_email, $subject, $content, $params))
			{
				$counter++;
			}
		}
		
		return $counter;
	}
	
	public static function replacements($text, $replacements)
	{
		if($replacements)
		{
			$text = strtr($text, $replacements);
		}
		
		return $text;
	}
 	
	public static function get_encryptions()
	{
		$available = stream_get_transports();
		
		$encryptions = array();
		
		if(in_array('ssl', $available))
		{
			$encryptions['ssl'] = 'SSL';
		}
		
		if(in_array('ssl', $available))
		{
			$encryptions['ssl'] = 'SSL';
		}
		
		if(in_array('tls', $available))
		{
			$encryptions['tls'] = 'TLS';
		}
		
		return $encryptions;
	}
	
}
