<?php
$address_arr = array();

if($address->province)
{
	$address_arr['province'] = '<span class="province">'.HTML::chars($address->province).'</span>';
}

if($address->city)
{
	$address_arr['city'] = '<span class="city">'.ucfirst(HTML::chars($address->city)).'</span>';
}

echo implode(', ', $address_arr);
