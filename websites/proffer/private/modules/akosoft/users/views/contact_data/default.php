<?php
$html = '';
		
if($name = $contact->display_name())
{
	$html .= '<div class="name">'.HTML::chars($name).'</div>';
}

if($contact->address)
{
	$html .= $contact->address->render();
}

echo $html ? '<div class="contact_data">'.$html.'</div>' : NULL;
