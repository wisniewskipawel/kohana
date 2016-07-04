<?php
$address_arr = array();

if((!isset($show) OR $show['street']) AND $address->street)
{
	$address_arr['street'] = ___('street_short', array(
		':street' => ucfirst(HTML::chars($address->street)),
	));
}

if((!isset($show) OR $show['postal_code']) AND $address->postal_code)
{
	$address_arr['postal_code'] = HTML::chars($address->postal_code);
}

if((!isset($show) OR $show['city']) AND $address->city)
{
	$city = ucfirst(HTML::chars($address->city));
	
	if(isset($address_arr['postal_code']))
	{
		$address_arr['postal_code'] .= ' '.$city;
	}
	else
	{
		$address_arr['city'] = $city;
	}
}

if((!isset($show) OR $show['province']) AND $address->province)
{
	if($address->province_id == Regions::ALL_PROVINCES)
	{
		$address_arr['province'] = HTML::chars($address->province);
	}
	else
	{
		$address_arr['province'] = ___('province_short', array(
			':province' => HTML::chars($address->province),
		));
	}
}

echo implode(', ', $address_arr);
