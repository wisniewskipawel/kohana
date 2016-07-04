<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */
class Bform_Driver_Offers_Price extends Bform_Driver_Common {
	
	protected $_submitted_values = NULL;
	
	public function get_submitted($field)
	{
		$type = Arr::get($this->_submitted_values, 'type');
		
		if(!array_key_exists($type, $this->get_types()))
		{
			return NULL;
		}
		
		switch($field)
		{
			case 'value':
				$value = Arr::get($this->_submitted_values, 'value', $this->_get_data_option('value'));
				
				if(!$value)
				{
					return NULL;
				}
				
				switch($type)
				{
					case 'proc':
						return (int)$value;

					default:
						return Bform_Filter_Price::parse_price($value);
				}
			
			default:
				return $type;
		}
	}
	
	public function get_types()
	{
		return array(
			NULL => ___('offers.forms.offer_price', array(':currency' => payment::currency('short'))),
			'proc' => ___('offers.forms.offer_price_proc'),
			'disc' => ___('offers.forms.offer_price_disc', array(':currency' => payment::currency('short'))),
		);
	}
	
	public function set_value($value)
	{
		if(is_array($value) AND isset($value['type']) AND isset($value['value']))
		{
			$this->_submitted_values = $value;
			
			if($label = Arr::get($this->get_types(), $this->get_submitted('type')))
			{
				$this->_set_html_option('label', $label);
			}
		}
		else
		{
			parent::set_value($value);
		}
	}
	
	public function get_value()
	{
		if(isset($this->_submitted_values['value']))
		{
			$form = $this->form();
			$price_old = $form->offer_price_old->get_value();
			
			$type = $this->get_submitted('type');
			$value = $this->get_submitted('value');
			
			if(!$price_old)
			{
				return NULL;
			}
			
			switch($type)
			{
				case 'proc':
					return Bform_Filter_Price::parse_price($price_old - ($price_old * ($value / 100)));
				
				case 'disc':
					return Bform_Filter_Price::parse_price($price_old - $value);
					
				default:
					return $value;
			}
		}
		
		return NULL;
	}
	
	public function render($decorate = FALSE)
	{
		return View::factory('bform/driver/offers/price')
			->set('decorate', $decorate)
			->set('driver', $this)
			->render();
	}
}
