<?php
$html = '';
		
if($this->province)
{
	$html .= '<div class="province">'.HTML::chars($this->province).'</div>';
}

if($this->county)
{
	$html .= '<div class="county">'.HTML::chars($this->county).'</div>';
}

if($this->postal_code)
{
	$html .= '<div class="postal_code">'.HTML::chars($this->postal_code).'</div>';
}

if($this->city)
{
	$html .= '<div class="city">'.HTML::chars($this->city).'</div>';
}

if($this->street)
{
	$html .= '<div class="street">'.HTML::chars($this->street).'</div>';
}

echo $html ? '<div class="address">'.$html.'</div>' : NULL;
