<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Cron
 *
 * @author      Chris Bandy
 * @copyright   (c) 2010 Chris Bandy
 * @license     http://www.opensource.org/licenses/isc-license.txt
 */
class Kohana_Cron
{
	protected static $_jobs = array();
	protected static $_times = array();
	protected static $_current_group = 'default';
	protected static $_force = false;
	protected static $_current_lock;
	protected static $_log = false;
	protected static $_date_logged = false;
	protected $_callback;
	protected $_period;
	protected $_group = 'default';

	/**
	 * Constructor
	 */
	public function __construct($period, $callback, $group = null)
	{
		$this->_period = $period;
		$this->_callback = $callback;

		if ($group !== null)
			$this->_group = $group;
	}

	/**
	 * Registers a job to be run
	 * @param string      Unique name
	 * @param array|Cron  Job to run
	 */
	public static function set($name, $job, $group = null)
	{
		if (is_array($job))
			$job = new Cron(reset($job), next($job), $group);

		Cron::$_jobs[$name] = $job;
	}

	/**
	 * Set current cron group
	 * @param string Cron group
	 */
	public static function set_group($group)
	{
		if (!is_string($group) && $group !== false)
			return;

		Cron::$_current_group = $group;
	}

	/**
	 * Set force value
	 * @param boolean value
	 */
	public static function set_force($value = true)
	{
		self::$_force = !!$value;
	}

	/**
	 * Set log value
	 * @param boolean value
	 */
	public static function set_log($value = true)
	{
		self::$_log = !!$value;
	}

	/**
	 * Log function. Useful for debugging
	 * @param string Text to log
	 */
	public static function log($str)
	{
		if (!self::$_log)
			return;

		if (!Cron::$_date_logged)
		{
			Cron::$_date_logged = true;
			echo "\n" . date('Y-m-d') . "\n";
			return self::log($str);
		}

		echo date('H:i:s') . ' ' . $str . "\n";
		@flush();
		@ob_flush();
	}

	/**
	 * Get current lock file
	 * @return string
	 */
	protected static function _get_lock_file()
	{
		if (self::$_current_lock === null)
		{
			$config = Kohana::$config->load('cron');
			Cron::$_current_lock = $config->lock;

			if (Cron::$_current_group !== null)
			{
				$pathinfo = pathinfo(Cron::$_current_lock);
				$dirname = dirname(Cron::$_current_lock);
				Cron::$_current_lock = $dirname . DIRECTORY_SEPARATOR . $pathinfo['filename'] . '.' . Cron::$_current_group;
				
				if (!empty($pathinfo['extension']))
					Cron::$_current_lock .= '.' . $pathinfo['extension'];
			}
		}
		
		return Cron::$_current_lock;
	}

	/**
	 * Retrieve the timestamps of when jobs should run
	 */
	protected static function _load()
	{
		//Get cached data
		//9999 sec. of lifetime to return cache each time cause run.php is supposed to be
		//called each 60 sec. and so Cron::_save() runs every 60 sec which refreshes the cache file)
		Cron::$_times = Kohana::cache("Cron::run()", NULL, 9999); 
	}

	/**
	 * Acquire the Cron mutex
	 * @return boolean
	 */
	protected static function _lock()
	{
		$lock = Cron::_get_lock_file();
		$time = time();
		
		if (!file_exists($lock))
		{
			file_put_contents($lock, $time, LOCK_EX);
			return TRUE;
		}

		$fmtime = file_get_contents($lock);
		
		if(($time - Date::HOUR) > $fmtime)
		{
			Cron::log('# Skip lock (expired)');
			file_put_contents($lock, $time, LOCK_EX);
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Store the timestamps of when jobs should run next
	 */
	protected static function _save()
	{
		Kohana::cache("Cron::run()", Cron::$_times);
	}

	/**
	 * Release the Cron mutex
	 * @return boolean
	 */
	protected static function _unlock()
	{
		Cron::log('# Unlocked');
		return @unlink(Cron::_get_lock_file());
	}

	/**
	 * Tells whether the actual job group is the same as the current group or not
	 * @return boolean
	 */
	protected static function _is_actual(Cron $job)
	{
		if (Cron::$_current_group === false)
			return true;

		return $job->_group == Cron::$_current_group;
	}

	/**
	 * Let's make it happens
	 * @return boolean FALSE when another instance is running
	 */
	public static function run()
	{
		$config = Kohana::$config->load('cron');

		Cron::log('# Cron::run() started');
		Cron::log('# Lock file: '.Cron::_get_lock_file());
		Cron::log('# Window: '.$config->window);

		if (empty(Cron::$_jobs))
			return TRUE;

		if (!Cron::_lock())
		{
			Cron::log('# Locked');
			Cron::log('# Cron::run() halted');
			return FALSE;
		}

		try
		{
			Cron::_load();
			$now = time();
			$threshold = $now - Kohana::$config->load('cron')->window;

			foreach (Cron::$_jobs as $name => $job)
			{
				if (!Cron::_is_actual($job))
					continue;

				Cron::log('# Job: ' . $name);
				Cron::log('# Cron::$_times['.$name.'] is '. ((isset(Cron::$_times[$name])) ? date('Y-m-d H:i:s', Cron::$_times[$name]) : 'empty'));
				Cron::log('# $threshold is '.date('Y-m-d H:i:s', $threshold));
				Cron::log('# $job->next($threshold) is ' . date('Y-m-d H:i:s', $job->next($threshold)));

				if (Cron::$_force)
				{
					Cron::log('# Force start');
					$job->execute();
				}
				elseif (empty(Cron::$_times[$name]) OR Cron::$_times[$name] < $threshold)
				{
					Cron::log('# Expired');
					Cron::$_times[$name] = $job->next($now);
					Cron::log('# Cron::$_times['.$name.'] is '.date('Y-m-d H:i:s',Cron::$_times[$name]));

					if ($job->next($threshold) < $now)
					{
						Cron::log('# Started within the window');
						$job->execute();
					}
				}
				elseif (Cron::$_times[$name] < $now)
				{
					Cron::log('# Started within the window');
					Cron::$_times[$name] = $job->next($now);
					$job->execute();
				}
				else
				{
					Cron::log('# Skipped');
				}
			}
		}
		catch (Exception $e) {}

		Cron::_save();
		Cron::_unlock();

		if (isset($e))
			throw $e;

    Cron::log('# Cron::run() completed');
		return TRUE;
	}


	/**
	 * Execute this job
	 */
	public function execute()
	{
		//call_user_func($this->_callback);
		Request::factory('cron/execute')
			->query('cron', $this->_callback)->execute();
	}

	/**
	 * Calculates the next timestamp in this period
	 * @param   integer Timestamp from which to calculate
	 * @return  integer Next timestamp in this period
	 */
	public function next($from)
	{
		// PHP >= 5.3.0
		// if ($this->_period instanceof DatePeriod) { return; }
		// if (is_string($this->_period) AND preg_match('/^P[\dDHMSTWY]+$/', $period)) { $this->_period = new DateInterval($this->_period); }
		// if ($this->_period instanceof DateInterval) { return; }

		return $this->_next_crontab($from);
	}

	/**
	 * Calculates the next timestamp of this crontab period
	 * @param   integer Timestamp from which to calculate
	 * @return  integer Next timestamp in this period
	 */
	protected function _next_crontab($from)
	{
		if (is_string($this->_period))
		{
			// Convert string to lists of valid values

			if ($this->_period[0] === '@')
			{
				switch (substr($this->_period, 1))
				{
					case 'annually':
					case 'yearly':
						// '0 0 1 1 *'
						$this->_period = array('minutes' => array(0), 'hours' => array(0), 'monthdays' => array(1), 'months' => array(1), 'weekdays' => range(0,6));
					break;

					case 'daily':
					case 'midnight':
						// '0 0 * * *'
						$this->_period = array('minutes' => array(0), 'hours' => array(0), 'monthdays' => range(1,31), 'months' => range(1,12), 'weekdays' => range(0,6));
					break;

					case 'hourly':
						// '0 * * * *'
						$this->_period = array('minutes' => array(0), 'hours' => range(0,23), 'monthdays' => range(1,31), 'months' => range(1,12), 'weekdays' => range(0,6));
					break;

					case 'monthly':
						// '0 0 1 * *'
						$this->_period = array('minutes' => array(0), 'hours' => array(0), 'monthdays' => array(1), 'months' => range(1,12), 'weekdays' => range(0,6));
					break;

					case 'weekly':
						// '0 0 * * 0'
						$this->_period = array('minutes' => array(0), 'hours' => array(0), 'monthdays' => range(1,31), 'months' => range(1,12), 'weekdays' => array(0));
					break;
				}
			}
			else
			{
				list($minutes, $hours, $monthdays, $months, $weekdays) = explode(' ', $this->_period);

				$months = strtr(strtolower($months), array(
					'jan' => 1,
					'feb' => 2,
					'mar' => 3,
					'apr' => 4,
					'may' => 5,
					'jun' => 6,
					'jul' => 7,
					'aug' => 8,
					'sep' => 9,
					'oct' => 10,
					'nov' => 11,
					'dec' => 12,
				));

				$weekdays = strtr(strtolower($weekdays), array(
					'sun' => 0,
					'mon' => 1,
					'tue' => 2,
					'wed' => 3,
					'thu' => 4,
					'fri' => 5,
					'sat' => 6,
				));

				$this->_period = array(
					'minutes'   => $this->_parse_crontab_field($minutes, 0, 59),
					'hours'     => $this->_parse_crontab_field($hours, 0, 23),
					'monthdays' => $this->_parse_crontab_field($monthdays, 1, 31),
					'months'    => $this->_parse_crontab_field($months, 1, 12),
					'weekdays'  => $this->_parse_crontab_field($weekdays, 0, 7)
				);

				// Ensure Sunday is zero
				if (end($this->_period['weekdays']) === 7)
				{
					array_pop($this->_period['weekdays']);

					if (reset($this->_period['weekdays']) !== 0)
					{
						array_unshift($this->_period['weekdays'], 0);
					}
				}
			}
		}

		$from = getdate($from);

		if ( ! in_array($from['mon'], $this->_period['months']))
			return $this->_next_crontab_month($from);

		if (count($this->_period['weekdays']) === 7)
		{
			// Day of Week is unrestricted, defer to Day of Month
			if ( ! in_array($from['mday'], $this->_period['monthdays']))
				return $this->_next_crontab_monthday($from);
		}
		elseif (count($this->_period['monthdays']) === 31)
		{
			// Day of Month is unrestricted, use Day of Week
			if ( ! in_array($from['wday'], $this->_period['weekdays']))
				return $this->_next_crontab_weekday($from);
		}
		else
		{
			// Both Day of Week and Day of Month are restricted
			if ( ! in_array($from['mday'], $this->_period['monthdays']) AND ! in_array($from['wday'], $this->_period['weekdays']))
				return $this->_next_crontab_day($from);
		}

		if ( ! in_array($from['hours'], $this->_period['hours']))
			return $this->_next_crontab_hour($from);

		return $this->_next_crontab_minute($from);
	}

	/**
	 * Calculates the first timestamp in the next day of this period when both
	 * Day of Week and Day of Month are restricted
	 * @uses    _next_crontab_month()
	 * @param   array   Date array from getdate()
	 * @return  integer Timestamp of next restricted Day
	 */
	protected function _next_crontab_day(array $from)
	{
		// Calculate effective Day of Month for next Day of Week

		if ($from['wday'] >= end($this->_period['weekdays']))
		{
			$next = reset($this->_period['weekdays']) + 7;
		}
		else
		{
			foreach ($this->_period['weekdays'] as $next)
			{
				if ($from['wday'] < $next)
					break;
			}
		}

		$monthday = $from['mday'] + $next - $from['wday'];

		if ($monthday <= (int) date('t', mktime(0, 0, 0, $from['mon'], 1, $from['year'])))
		{
			// Next Day of Week is in this Month

			if ($from['mday'] >= end($this->_period['monthdays']))
			{
				// No next Day of Month, use next Day of Week
				$from['mday'] = $monthday;
			}
			else
			{
				// Calculate next Day of Month
				foreach ($this->_period['monthdays'] as $next)
				{
					if ($from['mday'] < $next)
						break;
				}

				// Use earliest day
				$from['mday'] = min($monthday, $next);
			}
		}
		else
		{
			if ($from['mday'] >= end($this->_period['monthdays']))
			{
				// No next Day of Month, use next Month
				return $this->_next_crontab_month($from);
			}

			// Calculate next Day of Month
			foreach ($this->_period['monthdays'] as $next)
			{
				if ($from['mday'] < $next)
					break;
			}

			// Use next Day of Month
			$from['mday'] = $next;
		}

		// Use first Hour and first Minute
		return mktime(reset($this->_period['hours']), reset($this->_period['minutes']), 0, $from['mon'], $from['mday'], $from['year']);
	}

	/**
	 * Calculates the first timestamp in the next hour of this period
	 * @uses    _next_crontab_day()
	 * @uses    _next_crontab_monthday()
	 * @uses    _next_crontab_weekday()
	 * @param   array   Date array from getdate()
	 * @return  integer Timestamp of next Hour
	 */
	protected function _next_crontab_hour(array $from)
	{
		if ($from['hours'] >= end($this->_period['hours']))
		{
			// No next Hour

			if (count($this->_period['weekdays']) === 7)
			{
				// Day of Week is unrestricted, defer to Day of Month
				return $this->_next_crontab_monthday($from);
			}

			if (count($this->_period['monthdays']) === 31)
			{
				// Day of Month is unrestricted, use Day of Week
				return $this->_next_crontab_weekday($from);
			}

			// Both Day of Week and Day of Month are restricted
			return $this->_next_crontab_day($from);
		}

		// Calculate next Hour
		foreach ($this->_period['hours'] as $next)
		{
			if ($from['hours'] < $next)
				break;
		}

		// Use next Hour and first Minute
		return mktime($next, reset($this->_period['minutes']), 0, $from['mon'], $from['mday'], $from['year']);
	}

	/**
	 * Calculates the timestamp of the next minute in this period
	 * @uses    _next_crontab_hour()
	 * @param   array   Date array from getdate()
	 * @return  integer Timestamp of next Minute
	 */
	protected function _next_crontab_minute(array $from)
	{
		if ($from['minutes'] >= end($this->_period['minutes']))
		{
			// No next Minute, use next Hour
			return $this->_next_crontab_hour($from);
		}

		// Calculate next Minute
		foreach ($this->_period['minutes'] as $next)
		{
			if ($from['minutes'] < $next)
				break;
		}

		// Use next Minute
		return mktime($from['hours'], $next, 0, $from['mon'], $from['mday'], $from['year']);
	}

	/**
	 * Calculates the first timestamp in the next month of this period
	 * @param   array   Date array from getdate()
	 * @return  integer Timestamp of next Month
	 */
	protected function _next_crontab_month(array $from)
	{
		if ($from['mon'] >= end($this->_period['months']))
		{
			// No next Month, increment Year and use first Month
			++$from['year'];
			$from['mon'] = reset($this->_period['months']);
		}
		else
		{
			// Calculate next Month
			foreach ($this->_period['months'] as $next)
			{
				if ($from['mon'] < $next)
					break;
			}

			// Use next Month
			$from['mon'] = $next;
		}

		if (count($this->_period['weekdays']) === 7)
		{
			// Day of Week is unrestricted, use first Day of Month
			$from['mday'] = reset($this->_period['monthdays']);
		}
		else
		{
			// Calculate Day of Month for the first Day of Week
			$indices = array_flip($this->_period['weekdays']);

			$monthday = 1;
			$weekday = (int) date('w', mktime(0, 0, 0, $from['mon'], 1, $from['year']));

			while ( ! isset($indices[$weekday % 7]) AND $monthday < 7)
			{
				++$monthday;
				++$weekday;
			}

			if (count($this->_period['monthdays']) === 31)
			{
				// Day of Month is unrestricted, use first Day of Week
				$from['mday'] = $monthday;
			}
			else
			{
				// Both Day of Month and Day of Week are restricted, use earliest one
				$from['mday'] = min($monthday, reset($this->_period['monthdays']));
			}
		}

		// Use first Hour and first Minute
		return mktime(reset($this->_period['hours']), reset($this->_period['minutes']), 0, $from['mon'], $from['mday'], $from['year']);
	}

	/**
	 * Calculates the first timestamp in the next day of this period when only
	 * Day of Month is restricted
	 * @uses    _next_crontab_month()
	 * @param   array   Date array from getdate()
	 * @return  integer Timestamp of next Day of Month
	 */
	protected function _next_crontab_monthday(array $from)
	{
		if ($from['mday'] >= end($this->_period['monthdays']))
		{
			// No next Day of Month, use next Month
			return $this->_next_crontab_month($from);
		}

		// Calculate next Day of Month
		foreach ($this->_period['monthdays'] as $next)
		{
			if ($from['mday'] < $next)
				break;
		}

		// Use next Day of Month, first Hour, and first Minute
		return mktime(reset($this->_period['hours']), reset($this->_period['minutes']), 0, $from['mon'], $next, $from['year']);
	}

	/**
	 * Calculates the first timestamp in the next day of this period when only
	 * Day of Week is restricted
	 * @uses    _next_crontab_month()
	 * @param   array   Date array from getdate()
	 * @return  integer Timestamp of next Day of Week
	 */
	protected function _next_crontab_weekday(array $from)
	{
		// Calculate effective Day of Month for next Day of Week

		if ($from['wday'] >= end($this->_period['weekdays']))
		{
			$next = reset($this->_period['weekdays']) + 7;
		}
		else
		{
			foreach ($this->_period['weekdays'] as $next)
			{
				if ($from['wday'] < $next)
					break;
			}
		}

		$monthday = $from['mday'] + $next - $from['wday'];

		if ($monthday > (int) date('t', mktime(0, 0, 0, $from['mon'], 1, $from['year'])))
		{
			// Next Day of Week is not in this Month, use next Month
			return $this->_next_crontab_month($from);
		}

		// Use next Day of Week, first Hour, and first Minute
		return mktime(reset($this->_period['hours']), reset($this->_period['minutes']), 0, $from['mon'], $monthday, $from['year']);
	}

	/**
	 * Returns a sorted array of all the values indicated in a Crontab field
	 * @link http://linux.die.net/man/5/crontab
	 * @param   string  Crontab field
	 * @param   integer Minimum value for this field
	 * @param   integer Maximum value for this field
	 * @return  array
	 */
	protected function _parse_crontab_field($value, $min, $max)
	{
		$result = array();

		foreach (explode(',', $value) as $value)
		{
			if ($slash = strrpos($value, '/'))
			{
				$step = (int) substr($value, $slash + 1);
				$value = substr($value, 0, $slash);
			}

			if ($value === '*')
			{
				$result = array_merge($result, range($min, $max, $slash ? $step : 1));
			}
			elseif ($dash = strpos($value, '-'))
			{
				$result = array_merge($result, range(max($min, (int) substr($value, 0, $dash)), min($max, (int) substr($value, $dash + 1)), $slash ? $step : 1));
			}
			else
			{
				$value = (int) $value;

				if ($min <= $value AND $value <= $max)
				{
					$result[] = $value;
				}
			}
		}

		sort($result);

		return array_unique($result);
	}

}