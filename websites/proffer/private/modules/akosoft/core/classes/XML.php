<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class XML {

	protected static $_reserved_keys = array(
		'node_name', 'attributes', 'children', 'text'
	);

	public static function as_array($obj, & $array = NULL)
	{
		if ($array === NULL)
		{
			$array = array();
		}

		$children = $obj->children();

		foreach ($children as $node_name => $node)
		{
			$next_index = count($array);

			$array[$next_index] = array();
			$array[$next_index]['node_name'] = strtolower( (string) $node_name);
			$array[$next_index]['attributes'] = array();

			$attributes = $node->attributes();
			foreach ($attributes as $attr_name => $attr_value)
			{
				$attr_name = strtolower(trim( (string) $attr_name));
				$attr_value = trim( (string) $attr_value);
				$array[$next_index]['attributes'][$attr_name] = $attr_value;
			}

			$text = (string) $node;
			$text = trim($text);
			if (strlen($text) > 0)
			{
				$array[$next_index]['text'] = $text;
			}
			$array[$next_index]['children'] = array();
			self::as_array($node, $array[$next_index]['children']);
		}
		return $array;
	}

	public static function path($array, $path, $default = NULL, $delimiter = NULL)
	{
		if ( ! Arr::is_array($array))
		{
			return $default;
		}
		if ($delimiter === NULL)
		{
			$delimiter = Arr::$delimiter;
		}
		if ( ! Arr::is_array($path))
		{
			$path = explode($delimiter, $path);
		}

		$first = array_shift($path);

		foreach ($array as $key => $value)
		{
			if ($value['node_name'] == $first)
			{
				if (count($path))
				{
					$second = array_shift($path);
					if (in_array($second, self::$_reserved_keys))
					{
						return $value[$second];
					}
					else
					{
						array_unshift($path, $second);
						return self::path($value['children'], $path, $default, $delimiter);
					}
				}
				else
				{
					return $value;
				}
			}
		}

		return NULL;
	}
}
