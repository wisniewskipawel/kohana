<?php

/**
 * @package Cron
 *
 * @author      Chris Bandy
 * @copyright   (c) 2010 Chris Bandy
 * @license     http://www.opensource.org/licenses/isc-license.txt
 */

// Path to Kohana's index.php
$system = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'index.php';

if (file_exists($system))
{
	defined('SUPPRESS_REQUEST') or define('SUPPRESS_REQUEST', TRUE);

	include $system;

    $args = (array)$_SERVER['argv'];

    while($arg = array_shift($args)) {
        switch($arg) {
            case '--cron-group':
                if(!($group = array_shift($args)))
                    die("Group is undefined. Use `php -f path/to/file/run.php --cron-group group_name` syntax");
                Cron::set_group($group);
                break;

            case '--cron-force':
                Cron::set_force();
                break;
        }
    }

    Cron::run();
}
