<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	'groups' => array(
		'site_offers' => array(
			'label' => ___('offers.module'),
			'emails' => array(
				'offer_approve',
				'offer_approved',
				'coupon_send_confirmation',
				'coupon_send',
				'notifier_offers',
				'offers.contact',
				'offers_expiring_registered',
				'offers_expiring_not_registered',
				'offer_send_to_friend',
			),
		),
	),
);