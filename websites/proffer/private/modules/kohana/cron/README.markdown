# Kohana-Cron

This module provides a way to schedule tasks (jobs) within your Kohana application.


## Installation

Step 1: Download the module into your modules subdirectory.

Step 2: Enable the module in your bootstrap file:

	/**
	 * Enable modules. Modules are referenced by a relative or absolute path.
	 */
	Kohana::modules(array(
		'cron'       => MODPATH.'cron',
		// 'auth'       => MODPATH.'auth',       // Basic authentication
		// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
		// 'database'   => MODPATH.'database',   // Database access
		// 'image'      => MODPATH.'image',      // Image manipulation
		// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
		// 'pagination' => MODPATH.'pagination', // Paging of results
		// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));


Step 3: Make sure the settings in `config/cron.php` are correct for your environment.
If not, copy the file to `application/config/cron.php` and change the values accordingly.


## Usage

In its simplest form, a task is a [PHP callback][1] and times at which it should run.
To configure a task call `Cron::set($name, array($frequency, $callback))` where
`$frequency` is a string of date and time fields identical to those found in [crontab][2].
For example,

	Cron::set('reindex_catalog', array('@daily', 'Catalog::regenerate_index'));
	Cron::set('calendar_notifications', array('*/5 * * * *', 'Calendar::send_emails'));

Always remember that if you change a frequency value, remove the entry into the cache file
for that method. If you don't do this, the next call to the method will be with the last cached frequence.

Configured tasks are run with their appropriate frequency by calling `Cron::run()`. Call
this method in your bootstrap file, and you're done!


## Advanced Usage

A task can also be an instance of `Cron` that extends `next()` and/or `execute()` as
needed. Such a task is configured by calling `Cron::set($name, $instance)`.

If you have access to the system crontab, you can run Cron less (or more) than once
every request. You will need to modify the lines where the request is handled in your
bootstrap file to prevent extraneous output. The default is:

	/**
	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	echo Request::instance()
		->execute()
		->send_headers()
		->response;

Change it to:

	if ( ! defined('SUPPRESS_REQUEST'))
	{
		/**
		 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
		 * If no source is specified, the URI will be automatically detected.
		 */
		echo Request::instance()
			->execute()
			->send_headers()
			->response;
	}

Then set up a system cron job to run your application's Cron once a minute:

	* * * * * /usr/bin/php -f /path/to/kohana/modules/cron/run.php

The included `run.php` should work for most cases, but you are free to call `Cron::run()`
in any way you see fit.

## Enabling logs

In order to use the logs within the module, you'll have to put $_log var to true
	
	protected static $_log = true

And give an output to your cron job. It should look like this:

	* * * * * /usr/bin/php -f /path/to/kohana/modules/cron/run.php >> log.txt #


## Multi-streaming and using groups

Some jobs takes a lot of time, for example, and some jobs you need to be done quick and with a high frequency.

	Cron::set('reindex_catalog', array('@hourly', 'Catalog::regenerate_index')); // takes ~2 hours
	Cron::set('update_catalog_prices', array('@hourly', 'Catalog::update_prices')); // takes ~2 hours

	Cron::set('generate_simple_html', array('* * * * *', 'Site::regenerate_simple_page')); // takes few seconds

In common case you'll get some simple html page (from `Site::regenerate_simple_page()` method) only after previous tasks
would be complited, it's about ~4 hours. Every next `Cron::run()` execution will be halted while lock-file exists.

1) We can add group identifier for every job:

    Cron::set('reindex_catalog', array('@hourly', 'Catalog::regenerate_index'), 'catalog_tasks');
    Cron::set('update_catalog_prices', array('@hourly', 'Catalog::update_prices'), 'catalog_tasks');

    Cron::set('generate_simple_html', array('* * * * *', 'Site::regenerate_simple_page'), 'quick_tasks');

2) And put 2 rules to crontab for every new stream

    * * * * * /usr/bin/php -f /path/to/kohana/modules/cron/run.php catalog_tasks
    * * * * * /usr/bin/php -f /path/to/kohana/modules/cron/run.php quick_tasks

    * * * * * /usr/bin/php -f /path/to/kohana/modules/cron/run.php # will handle default jobs, without group identifier

First cron process will start `Cron::run()` method for _catalog_tasks_ group and it will take about 4 hours before it start
next `Cron::run()` method for _quick_tasks_ group

But second cron process (at next minute) will skip _catalog_task_ (because lock-file for that group exists) and execute
_quick_tasks_ jobs


## Session fix for cron

If your callbacks uses sessions (via Session class), you will always get this exception:

    Error reading session data.

This is expected behavior. But its a problem for cron callbakcs execution. Solution is to overload Session::read() method
in your application/classes folder:

    abstract class Session extends Kohana_Session
    {
        public function read($id = NULL)
        {
            try {
                parent::read($id);
            } catch (Session_Exception $e) {
                // ignore
            }
        }
    }

  [1]: http://php.net/manual/language.pseudo-types.php#language.types.callback
  [2]: http://linux.die.net/man/5/crontab
