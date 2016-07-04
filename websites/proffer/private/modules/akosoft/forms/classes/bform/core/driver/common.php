<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Bform_Core_Driver_Common {

	/**
	 * Data container, driver internal data
	 *
	 * @access public
	 * @var array
	 */
	public $_data = array(
		'form'			=> NULL,
		'value'			=> NULL,
		'name'			=> NULL,
		'required'			=> TRUE,
		'clear_value'		=> FALSE,
		'has_error'		=> FALSE,
		'validators'		=> array(),
		'filters'			=> array(),
		'driver_template'	=> NULL,
		'driver_layout'		=> NULL,
		'path'			=> NULL,
		'collection'		=> NULL,
	);

	/**
	 * Data container, html data
	 *
	 * @var array
	 * @access public
	 */
	public $_html = array(
		'name'			=> NULL,
		'label'			=> NULL,
		'id'				=> NULL,
		'html_before'		=> NULL,
		'html_after'		=> NULL,
		'row_id'			=> NULL,
		'row_class'		=> array(),
		'class'			=> array(),
		'read_only'		=> FALSE,
		'value'			=> NULL,
		'error_messages'	=> array(),
		'disabled'			=> NULL,
		'title'				=> NULL,
		'no_decorate'		=> FALSE,
	);

	/**
	 * Data container, custom data. This var should be extended.
	 * Structure:
	 * <code>
	 * public $_custom_data = array(
	 *	 _html => array(
	 *		 'additional_html_field' => NULL
	 *	 ),
	 *	 _data => array(
	 *		 'additional_data_field' => NULL
	 *	 )
	 * )
	 * </code>
	 *
	 * @var array
	 * @access public
	 */
	public $_custom_data = array();

	public function __construct(Bform_Core_Form $form, $name, array $options = array())
	{
		if (empty($name))
		{
			throw new Bform_Exception('Name of the driver cannot be empty!');
		}
		
		//extend options
		isset($this->_custom_data['_data']) AND $this->_extend_options($this->_custom_data['_data'], 'data', TRUE);
		isset($this->_custom_data['_html']) AND $this->_extend_options($this->_custom_data['_html'], 'html', TRUE);

		$this->data('form', $form); // set form
		$this->data('name', $name);
		
		if(!isset($options['path']))
		{
			$options['path'] = $name;
		}
		
		if(!empty($options['label']))
		{
			$options['label'] = ___($options['label']);
		}
		
		$this->_extend_options($options); // fill driver with variables passed in $info param

		if ($this->data('required') === TRUE) // if field is required, default is TRUE
		{
			$this->add_validator('Bform_Validator_Required');
			$this->html('class', Kohana::$config->load('bform.css.drivers.required_class'));
		}

		if ($this instanceof Bform_Driver_Input_Text OR $this instanceof Bform_Driver_Input_Password)
		{
			$this->add_filter('Bform_Filter_Trim');
		}
	}

	/**
	 * Setter and getter for $_data container
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return Bform_Driver_Common
	 * @return mixed
	 * @access public
	 */
	public function data($name = NULL, $value = NULL)
	{
		if($value === NULL)
		{
			return $this->_get_data_option($name);
		}
		else
		{
			return $this->_set_data_option($name ,$value);
		}
	}
	
	protected function _set_data_option($name, $value)
	{
		switch($name)
		{
			default: 
				$this->_data[$name] = $value;
				break;
		}
		
		return $this;
	}
	
	protected function _get_data_option($name, $default = NULL)
	{
		switch($name)
		{
			case 'driver_layout':
				if(empty($this->_data[$name]))
				{
					$class_name = strtolower(get_class($this));
					$template_name = $this->form()->template();

					//set driver layout
					$driver_layout = Kohana::$config->load('bform.drivers.'.$class_name.'.views.' . $template_name . '.layout');
					if ($driver_layout === NULL) 
					{
						$config_path = 'bform.views.defaults.drivers_layouts.' . $template_name;
						$driver_layout = Kohana::$config->load($config_path);
					}

					$this->_set_data_option('driver_layout', $driver_layout);
				}
				break;
				
			case 'driver_template':
				if(empty($this->_data[$name]))
				{
					$class_name = strtolower(get_class($this));
					$template_name = $this->form()->template();

					//set driver template
					$config_path = 'bform.drivers.'.$class_name.'.views.' . $template_name . '.driver';
					$this->_set_data_option('driver_template', Kohana::$config->load($config_path));
				}
				break;
		}
		
		return Arr::get($this->_data, $name, $default);
	}

	/**
	 * Setter and getter for $_html container
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return Bform_Driver_Common
	 * @return mixed
	 * @access public
	 */
	public function html($name = NULL, $value = NULL)
	{
		if($value === NULL)
		{
			return $this->_get_html_option($name);
		}
		else
		{
			return $this->_set_html_option($name ,$value);
		}
	}
	
	protected function _set_html_option($name, $value)
	{
		switch($name)
		{
			case 'row_class':
			case 'class':
				if(is_array($value))
				{
					$this->_html[$name] = array_merge($this->_html[$name], $value);
				}
				else
				{
					$this->_html[$name][] = $value;
				}
				break;
			
			default: 
				$this->_html[$name] = $value;
				break;
		}
		
		return $this;
	}
	
	protected function _get_html_option($name, $default = NULL)
	{
		switch($name)
		{
			case 'name':
				if(empty($this->_html[$name]))
				{
					$this->_set_html_option('name', Bform_Helper::name_from_path($this->_get_data_option('path')));
				}
				break;
				
			case 'label':
				if(empty($this->_html['label']))
				{
					$label = $this->_get_data_option('path');
					
					if($form = $this->form())
					{
						$label = $form->trans($label);
					}

					$this->_set_html_option('label', $label);
				}
				break;
			
			case 'id':
				if(empty($this->_html['id']))
				{
					$id = str_replace(array(']', '[', '_', '.'), '-', $this->_get_data_option('path'));
					$id = preg_replace('#\-{2,}#', '-', $id);
					$id = 'bform-' . $id;
					$this->_set_html_option('id', $id); // generate HTML id if user don't set
				}
				break;
				
			case 'row_id':
				if(empty($this->_html['row_id']))
				{
					$row_id = $this->_get_html_option('id');
					$row_id = $row_id . '-row';
					$this->_set_html_option('row_id', $row_id);
				}
				break;
				
			case 'row_class':
			case 'class':
				return implode(' ', Arr::get($this->_html, $name, $default));
		}
		
		return Arr::get($this->_html, $name, $default);
	}
	
	public function set_error($error_message)
	{
		$this->html('error_messages', $error_message);
		$this->html('class', Kohana::$config->load('bform.css.errors.driver_class'));
		$this->data('has_error', TRUE);
	}

	/**
	 * Get value from the driver
	 *
	 * @return string
	 * @access public
	 */
	public function get_value()
	{
		return $this->data('value');
	}
	
	public function on_get_values($values, $not_empty = FALSE)
	{
		$this->execute_filters();
		$value = $this->get_value();

		if(!Valid::not_empty($value) AND $not_empty === TRUE)
			return;

		$values[$this->data('name')] = $value;
		
		return $values;
	}

	/**
	 * Set value for driver
	 *
	 * @return string
	 * @access public
	 */
	public function set_value($value)
	{
		if(!$this->html('read_only'))
		{
			return $this->_set_data_option('value', $value);
		}
	}
	
	public function set_values($values)
	{
		$value = Arr::path($values, $this->data('path'));
		$this->set_value($value);
	}

	/**
	 * Add a filter to driver
	 *
	 * @param type $filter_class_str Filter class name
	 * @param type $options Params passed into Filter Class
	 * @return Bform_Form
	 */
	public function add_filter($filter_class_str, $options = array())
	{
		if ( ! class_exists($filter_class_str))
		{
			throw new Bform_Exception("Filter '$filter_class_str' do not exists!");
		}

		$this->_data['filters'][] = new $filter_class_str($this, $options);

		return $this;
	}

	/**
	 * Filter sended value to driver
	 *
	 * @return Bform_Driver_Common
	 * @access public
	 * @see Bform_Form::validate();
	 */
	public function execute_filters()
	{
		foreach ($this->data('filters') as $f)
		{
			$f->update();
			
			$this->set_value($f->filter());
		}
		return $this;
	}

	/**
	 * Add validator to the driver
	 *
	 * @param type $validator_class_str Validator class name
	 * @param array $options Params passed into Validator Class
	 * @return Bform_Form
	 */
	public function add_validator($validator_class_str, array $options = array())
	{
		if ( ! class_exists($validator_class_str))
		{
			throw new Bform_Exception('Validator ' . $validator_class_str . ' doesn\'t exist!');
		}

		$this->_data['validators'][] = new $validator_class_str($this, $options);

		return $this;
	}
	
	/**
	 * Execute validators.
	 * 
	 * @return array Errors array
	 */
	public function execute_validators()
	{
		$errors = array();

		$validators = $this->data('validators');
		
		foreach ($validators as $v)
		{
			$v->update();

			try
			{
				$v->validate();
			}
			catch (Bform_Validator_Exception $e)
			{
				$errors[] = $error = $e->error();
				
				$this->set_error(Arr::get($error, 'message'));

				if ($e->stop())
				{
					break;
				}
			}
		}

		return $errors;
	}
	
	/**
	 * Get current form.
	 * 
	 * @return Bfrom_Core_Form
	 */
	public function form()
	{
		return $this->data('form');
	}

	/**
	 * Renders a driver
	 *
	 * @return string
	 */
	public function render($decorate = FALSE)
	{
		if($decorate)
		{
			$layout = $this->data('driver_layout');
		
			if($layout instanceof View)
			{
				$view = $layout;
			}
			else
			{
				$view = View::factory($layout);
			}
			
			return $view->set('driver', $this)
				->render();
		}
		else
		{
			return $this->_render_driver();
		}
	}

	protected function _render_driver()
	{
		$template = $this->data('driver_template');
		
		if($template instanceof View)
		{
			$view = $template;
		}
		else
		{
			$view = View::factory($template);
		}
		
		return $view->set('driver', $this)
			->render();
	}

	public function __toString()
	{
		try
		{
			return (string)$this->render(TRUE);
		}
		catch(Exception $ex)
		{
			Kohana_Exception::log($ex, Log::ERROR);
			
			return Kohana_Exception::text($ex);
		}
	}

	/**
	 * Populate driver with data passed into $info var
	 *
	 * @param array $info
	 * @access protected
	 */
	protected function _extend_options(array $options, $options_set = NULL, $allow_append = TRUE)
	{
		foreach($options as $name => $value)
		{
			if($options_set == 'data' OR !$options_set)
			{
				if($allow_append OR array_key_exists($name, $this->_data))
				{
					$this->data($name, $value);
				}
			}
			
			if($options_set == 'html' OR !$options_set)
			{
				if($allow_append OR array_key_exists($name, $this->_html))
				{
					$this->html($name, $value);
				}
			}
		}
	}
	
}
