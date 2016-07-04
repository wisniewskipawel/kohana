<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Text extends Kohana_Text {
	
	public static function linkify($text)
	{
		$text = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2", $text);
		$text = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\" rel=\"nofollow\">$1</A>", $text);
		$text = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<a href=\"mailto:$1\" rel=\"nofollow\">$1</a>", $text);
		$text = Security::xss_clean($text);
		return $text;
	}
	
}
