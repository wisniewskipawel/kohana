<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Tools {
    
	public static function link($link)
	{
		$link = Security::xss_clean($link);

		if (strpos($link, 'http://') !== FALSE OR strpos($link, 'https://') !== FALSE)
		{
			return $link;
		}
		else
		{
			$link = 'http://' . $link;
		}

		return $link;
	}

	public static function server_name($url)
	{
		$url = str_replace('http://', '', $url);
		$url = str_replace('https://', '', $url);
		$url = trim($url, '/');
		$url = preg_replace('#\/.*#', '', $url);
		return $url;
	}

	public static function youtube_video_id($ytURL)
	{
		$ytvIDlen = 11; // This is the length of YouTube's video IDs
		// The ID string starts after "v=", which is usually right after
		// "youtube.com/watch?" in the URL
		$idStarts = strpos($ytURL, "?v=");
		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
		// bases covered), it will be after an "&":
		if($idStarts === FALSE)
			$idStarts = strpos($ytURL, "&v=");
		// If still FALSE, URL doesn't have a vid ID
			//if($idStarts === FALSE)
				//die("YouTube video ID not found. Please double-check your URL.");
		// Offset the start location to match the beginning of the ID string
		$idStarts +=3;
		// Get the ID string and return it
		$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
		return $ytvID;
	}

	public static function max_upload_filesize() 
	{
		$filesize[] = ini_get('upload_max_filesize');
		$filesize[] = ini_get('post_max_size');

		sort($filesize);
		return $filesize[0];
	}
}
