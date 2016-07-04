<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Form  extends Bform_Core_Driver_Collection {

	/**
	 * @var array Data container
	 * @access protected
	 */
	protected $_data = array(
		'class'			 => 'bform',		 // html class
		'name'			  => 'bform',		 // html name
		'id'				=> '',			  // html id
		'action'			=> '',			  // html action
		'layout'			=> '',			  //
		'layout_data' => array(),
		'template'		  => 'main',		  // template of the form
		'method'			=> 'post',		  // method of sending form
		'errors'			=> array(),		 // validation errors
		'block_manager'	 => NULL,			// html block manager - fieldsets and jQuery UI tabs
		'group_manager'	 => NULL,			// drivers groups manager
		'buttons_manager'   => NULL,			// buttons manager
		'submit_value'	  => NULL,			// value of the input[type='submit']
		'data'			  => array(),		 // loaded data from $_POST or $_GET
		'form_id'		   => '',			  // ID (class name) of the form
		'save_get_values'   => TRUE,			// if $_GET values on the page of form should be saved
		'i18n_namespace'	=> NULL,
	);

	protected $_method = 'post';

	/**
	 * @access public
	 * @var array Driver Container
	 */
	public $drivers = NULL;

	/**
	 * @var Request Current request.
	 */
	public $request = NULL;
	
	public $tabs = array();
	
	protected $_submitted_data = array();

	public function __construct(array $options = array())
	{
		parent::__construct($this, NULL, $options);

		$this->request = Request::current();
		
		$this->param('buttons_manager', new Bform_Manager_Buttons($this));

		$class_name = get_class($this);
		
		if ($pos = strrpos($class_name, '\\')) 
		{
			$class_name = substr($class_name, $pos + 1);
		}
		
		$this->param('form_id', $class_name);

		$this->method($this->_method);
		$this->action(FALSE);
	}

	/**
	 * Check if form is sent
	 *
	 * @return bool
	 * @access public
	 */
	public function is_sent()
	{
		$form_id = $this->param('form_id');

		if ( ! empty($form_id))
		{
			if ($this->submitted_data('form_id') == $form_id)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Setter and getter for the form params.
	 *
	 * @param string $name Name of the param.
	 * @param string $value If passed method is setter, if not - method is getter
	 * @return Bform_Form
	 * @return mixed
	 * @access public
	 */
	public function param($name, $value = NULL)
	{
		if ( ! array_key_exists($name, $this->_data))
		{
			throw new Bform_Exception("Param '$name' doesnt exists!");
		}
		if ($value === NULL)
		{
			return $this->_data[$name];
		}
		$this->_data[$name] = $value;
		return $this;
	}

	/**
	 * Template setter or getter
	 *
	 * @param string $value Template name
	 * @return string
	 * @return Bform_Form
	 * @access public
	 */
	public function template($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->param('template');
		}
		return $this->param('template', $value);
	}

	/**
	 * Method setter and getter
	 *
	 * @param string $method 'get' or 'post'
	 * @return string
	 * @return Bform_Form
	 * @access public
	 */
	public function method($method = NULL)
	{
		if ($method === NULL)
		{
			return $this->param('method');
		}
		
		$method = strtolower($method);
		
		$this->param('method', $method);
		
		switch ($method)
		{
			case 'post':
				$this->_submitted_data = $this->request->post();
				break;

			case 'get':
				$this->_submitted_data = $this->request->query();
				break;
		}
	}

	/**
	 *
	 * @param string $value Action URI or URL. If empty string the action value will be current URL
	 * @return string
	 * @return Bform_Form
	 * @access public
	 */
	public function action($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->param('action');
		}
		if (empty($value))
		{
			$value = "";
		}
		else
		{
			$value = URL::site($value);
		}
		return $this->param('action', $value);
	}

	/**
	 * This method has to be extended by your class of form
	 *
	 * @param array $params Params to bind
	 * @see Bform::factory()
	 */
	public function create(array $params = array())
	{
		throw new Bform_Exception('Check API.');
	}

	/**
	 * This method is used in Bform::factory() method. It creates a Form ID element, saves a existing $_GET params and check if URL is not too long.
	 *
	 * @access public
	 */
	public function after()
	{
		$form_id = $this->param('form_id');

		if ( ! empty($form_id))
		{
			$this->add_input_hidden('form_id', $this->param('form_id'), array(
				'read_only' => TRUE,
			));
		} 
		else
		{
			throw new Bform_Exception("Element named 'form_id' already exists, change name of your driver if you want to create this form!");
		}

		$this->_after_saved_values();

		$current_url = Request::$current->url('https');
		if (isset($_SERVER['QUERY_STRING']) AND (bool) strlen($_SERVER['QUERY_STRING']) === TRUE)
		{
			$current_url .= '?' . $_SERVER['QUERY_STRING'];
		}
		if (strlen($current_url) >= 2000)
		{
			throw new Bform_Exception('Length of the current URL is limited to 2000 chars!');
		}
	}

	/**
	 * Saves existing $_GET values
	 *
	 * @access protected
	 */
	protected function _after_saved_values()
	{
		if ($this->method() != 'get' OR $this->param('save_get_values') !== TRUE)
		{
			return;
		}

		foreach ($this->request->query() as $name => $value)
		{
			if (!$this->has($name) AND ! array_key_exists($name, $this->param('buttons_manager')->buttons()))
			{
				if (is_array($value))
				{
					foreach ($value as $array_value)
					{
						if (is_array($array_value))
						{
							throw new Bform_Exception('Multidimentional GET arrays are not supported!');
						}
						$rand = Text::random('alnum', 4);
						$this->add_input_hidden($name . $rand, $array_value, array('_html:name' => $name . '[]'));
					}
				} 
				else
				{
					$this->add_input_hidden($name, $value);
				}
			} 
			else
			{
				if ( ! $this->is_sent())
				{
					throw new Bform_Exception("GET value named '$name' is the same as driver created in this form! Change GET value or driver name or turn off saving GET variables.");
				}
			}
		}
	}

	/**
	 * Setter or getter form sended values.
	 *
	 * @param array $data Array with sended form values
	 * @return Bform_Form
	 * @return string
	 */
	public function form_data($data = NULL)
	{
		if($data === NULL)
		{
			$data = $this->param('data');
			
			//submitted data only
			if($this->is_sent())
			{
				$data = Arr::merge($data, $this->_submitted_data);
			}
			
			return $data;
		}
		
		//get  form original data
		if (is_string($data))
		{
			return Arr::path($this->form_data(), $data);
		}
		
		//set form data
		$data = Arr::merge($this->form_data(), $data);
		
		return $this->param('data', $data);
	}

	/**
	 * @param string|array $name
	 * @param mixed $default
	 * @return array|mixed
	 */
	public function submitted_data($name = NULL, $default = NULL)
	{
		return $name ? Arr::path($this->_submitted_data, $name, $default) : $this->_submitted_data;
	}

	/**
	 * @param string|array $path
	 * @return array|mixed
	 */
	public function get_form_value($path)
	{
		if($this->is_sent())
		{
			return $this->submitted_data($path);
		}

		return $this->form_data($path);
	}

	/**
	 * Checks if $var_name exists in sended data.
	 *
	 * @param type $var_name Name of the value to check
	 * @param type $path Path to search in array, used for namespaced drivers
	 * @return bool
	 */
	public function data_var_exists($var_name, $path = NULL)
	{
		if ($path === NULL)
		{
			return array_key_exists($var_name, $this->form_data());
		} else // fix for namespaced drivers
		{
			return (Arr::path($this->form_data(), $path, NULL, '.') !== NULL);
		}

	}

	/**
	 * Renders a form.
	 *
	 * @return string
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch(Exception $ex)
		{
			Kohana_Exception::log($ex, Log::ERROR);
			
			return $ex->getMessage();
		}
	}

	/**
	 * Renders a form.
	 *
	 * @return string
	 */
	public function render($layout = NULL)
	{
		try
		{
			$this->_apply_template();
			
			if(!$layout)
			{
				$layout = $this->param('layout');
			}
			
			if($layout instanceof View)
			{
				$view = $layout;
			}
			else
			{
				$view = View::factory($layout);
			}

			return $view->set($this->_data['layout_data'])
				->set('form', $this)
				->render();

		}
		catch (Exception $e)
		{
			Kohana_Exception::handler($e);
		}
	}

	public function render_partial($driver = NULL, $view = NULL)
	{
		if($driver)
		{
			return (string)$this->get($driver)->render(TRUE);
		}
		
		if(!$view instanceof View)
		{
			$view = View::factory($view);
		}

		return $view->set('form', $this)
			->render();
	}

	/**
	 * Alias / Helper to creating a Input Submit.
	 *
	 * @param type $value Html Input value
	 * @param array $info Params
	 * @return Bform_Form
	 */
	public function add_input_submit($value, array $info = array()) 
	{
		$values[0] = Bform::BUTTON_TYPE_SUBMIT;
		$values[1] = $value;
		$values[2] = $info;

		$this->param('buttons_manager')->add_button($values);

		return $this;
	}

	/**
	 * Starts the buttons.
	 *
	 * @return Bform_Form
	 */
	public function buttons_start()
	{
		$this->param('buttons_manager')->started(TRUE);
		return $this;
	}

	/**
	 * Ends the buttons.
	 *
	 * @return Bform_Form
	 */
	public function buttons_end()
	{
		$this->param('buttons_manager')->started(FALSE);
		return $this;
	}

	/**
	 * Returns Input Submit value
	 *
	 * @return string
	 */
	public function get_submit_value()
	{
		return $this->submit_value;
	}

	/**
	 * Validate a form
	 *
	 * @return bool
	 */
	public function validate()
	{
		$this->_populate_form();

		if ( ! $this->is_sent())
		{
			return FALSE;
		}

		$this->execute_filters();

		$errors = $this->execute_validators();
		
		$this->param('errors', $errors);

		if (!empty($errors))
		{
			FlashInfo::add(___('bform.validator.error'), 'error');
			return FALSE;
		}

		return TRUE;
	}
	
	public function trans($string, $context = 0, $values = NULL)
	{
		if($ns = $this->param('i18n_namespace'))
		{
			$string = $ns.'.'.$string;
		}
		
		return ___($string, $context, $values);
	}

	/**
	 * Fill form with sended data.
	 */
	protected function _populate_form() 
	{
		if ($this->method() == 'get' AND (bool) count($this->get_files(FALSE)) === TRUE)
		{
			throw new Bform_Exception('You cannot send files in GET method!');
		}

		$data = Arr::merge($this->submitted_data(), $_FILES);
		
		$this->set_values($data, $this);
	}

	/**
	 * Generate namespaced drivers names with paths used in Arr::path()
	 *
	 * @param array $array
	 * @param string $current_path
	 * @param array $result
	 * @return array
	 */
	public function _get_data_paths(array $array, $current_path, array & $result = array())
	{
		foreach ($array as $key => $value)
		{
			if (is_array($value))
			{
				$this->_get_data_paths($value, $current_path . '.' . $key, $result);

			} else
			{
				if (is_numeric($key)) // propably a namespaced group
				{
					$result[] = array('path' => $current_path, 'name' => Bform_Helper::name_from_path($current_path));
				}
				$path = $current_path . '.' . $key;
				$result[] = array('path' => $path, 'name' => Bform_Helper::name_from_path($path));
			}
		}

		return $result;
	}

	/**
	 * Apply a template to form
	 */
	protected function _apply_template()
	{
		if(!$this->param('id'))
		{
			$this->param('id', $this->param('form_id'));
		}

		$layout = $this->param('layout');

		if (empty($layout))
		{
			$this->param('layout', Kohana::$config->load('bform.views.defaults.form_layouts.' . $this->param('template')));
		}
		$this->param('buttons_manager')->layout(Kohana::$config->load('bform.drivers.bform_driver_button.views.'.$this->param('template').'.layout'));
	}

	public function add_tab($name, $label, $options = array())
	{
		$options['label'] = $label;
		$tab_driver = new Bform_Driver_Tab($this, $name, $options);
		
		$this->tabs[] = $tab_driver;
		
		return $this->add_driver($name, $tab_driver);
	}
	
	public function render_form_open()
	{
		$this->_apply_template();
		
		return '<form'.HTML::attributes(array(
			'action' => $this->action(),
			'method' => $this->method(),
			'id' => $this->param('id'), 
			'class' => $this->param('class'),
			'name' => $this->param('name'),
			'enctype' => 'multipart/form-data',
		)).'>';
	}
	
	public function render_form_close()
	{
		return '</form>';
	}
	
}
