<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Bform_Driver_Payments extends Bform_Driver_Collection_Flat {
	
	/**
	 * @var Payment_Module 
	 */
	protected $_payment_module;
	
	public function __construct(Bform_Core_Form $form = NULL, $name, Payment_Module $payment_module, $options = array())
	{
		parent::__construct($form, $name, $options);
		
		$this->_payment_module = $payment_module;
	}
	
	public function on_add_driver()
	{
		if($this->_payment_module->is_enabled($this->option('payment_type')))
		{
			$providers = $this->_payment_module->get_providers($this->option('payment_type'));

			if($providers)
			{
				$this->add_group_radio('payment_method', NULL, array(
					'label' => 'payments.forms.payment_method.label', 
					'class' => 'payment-method',
					'row_class' => 'payment_method_group full',
				));
				
				foreach($providers as $provider)
				{
					$this->_payment_module->provider($provider);

					$this->payment_method->add_option($provider->get_name(), $provider->get_label(), array(
						'class' => $this->_payment_module->is_discount_allowed($this->option('payment_type')) ? 'discount_allowed' : '',
					));
				}
				
				if($discount = $this->option('discount'))
				{
					$this->add_bool('with_discount', array(
						'label' => ___('payments.forms.payment_method.with_discount', array(':discount' => $discount)),
						'required' => FALSE,
						'row_class' => 'full',
					));
					
					$this->add_input_hidden('discount', $discount, array(
						'read_only' => TRUE,
					));
				}

				$this->add_html('<div id="payment-info"></div>', array(
					'label' => 'payments.forms.payment_info', 
					'row_id' => 'payment-info-row',
					'row_class' => 'full',
					'no_decorate' => FALSE,
				));
			}
		}
	}
	
	public function render($decorate = NULL)
	{
		if($decorate !== NULL)
		{
			$this->set_option('decorate', $decorate);
		}
		
		return View::factory('bform/drivers/payments')
			->set('payment_module', $this->_payment_module)
			->set('collection', $this)
			->set('form', $this->form())
			->set('options', $this->options());
	}
	
}