<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

payment::register_module('job_add');
payment::register_module('job_promote');

$module = Modules::instance()->register('site_jobs');

require_once 'routes.php';

Cron::set('jobs_expired', array('@hourly', 'cron/jobs/expired'));
