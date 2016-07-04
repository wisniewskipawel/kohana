<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Date extends I18n_Date {
	
	public static function my($value, $type = NULL)
	{
		$format = NULL;
		
		if ($type !== NULL)
		{
			$format = Kohana::$config->load('date.' . $type);
		}
		
		if ($format === NULL)
		{
			$format  = 'Y-m-d H:i';
		}
		
		if (is_numeric($value))
		{
			$date = date($format, $value);
		}
		else
		{
			$date = strtotime($value);
			$date = date($format, $date);
		}
		return $date;
	}
	
	/**
	 * Returns time difference between two timestamps, in human readable format.
	 * If the second timestamp is not given, the current time will be used.
	 * Also consider using [Date::fuzzy_span] when displaying a span.
	 *
	 *     $span = Date::span(60, 182, 'minutes,seconds'); // array('minutes' => 2, 'seconds' => 2)
	 *     $span = Date::span(60, 182, 'minutes'); // 2
	 *
	 * @param   integer $remote timestamp to find the span of
	 * @param   integer $local  timestamp to use as the baseline
	 * @param   string  $output formatting string
	 * @return  string   when only a single output is requested
	 * @return  array    associative list of all outputs requested
	 */
	public static function span($remote, $local = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds')
	{
		// Normalize output
		$output = trim(strtolower( (string) $output));

		if ( ! $output)
		{
			// Invalid output
			return FALSE;
		}

		// Array with the output formats
		$output = preg_split('/[^a-z]+/', $output);

		// Convert the list of outputs to an associative array
		$output = array_combine($output, array_fill(0, count($output), 0));

		//Fix bug: Only variables should be passed by reference
		$fliped = array_flip($output);
        
		// Make the output values into keys
		extract($fliped, EXTR_SKIP);

		if ($local === NULL)
		{
			// Calculate the span from the current time
			$local = time();
		}

		// Calculate timespan (seconds)
		$timespan = abs($remote - $local);

		if (isset($output['years']))
		{
			$timespan -= Date::YEAR * ($output['years'] = (int) floor($timespan / Date::YEAR));
		}

		if (isset($output['months']))
		{
			$timespan -= Date::MONTH * ($output['months'] = (int) floor($timespan / Date::MONTH));
		}

		if (isset($output['weeks']))
		{
			$timespan -= Date::WEEK * ($output['weeks'] = (int) floor($timespan / Date::WEEK));
		}

		if (isset($output['days']))
		{
			$timespan -= Date::DAY * ($output['days'] = (int) floor($timespan / Date::DAY));
		}

		if (isset($output['hours']))
		{
			$timespan -= Date::HOUR * ($output['hours'] = (int) floor($timespan / Date::HOUR));
		}

		if (isset($output['minutes']))
		{
			$timespan -= Date::MINUTE * ($output['minutes'] = (int) floor($timespan / Date::MINUTE));
		}

		// Seconds ago, 1
		if (isset($output['seconds']))
		{
			$output['seconds'] = $timespan;
		}

		if (count($output) === 1)
		{
			// Only a single output was requested, return it
			return array_pop($output);
		}

		// Return array
		return $output;
	}
	
}
