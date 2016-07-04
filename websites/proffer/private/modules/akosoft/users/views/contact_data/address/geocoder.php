<?php
$address_arr = array();

if($address->province)
{
	$address_arr['province'] = HTML::chars($address->province);
}

if($address->postal_code)
{
	//$address_arr['postal_code'] = HTML::chars($address->postal_code);
}

if($address->city)
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

if($address->street)
{
	$address_arr['street'] = HTML::chars($address->street);
}

echo implode(', ', $address_arr);
