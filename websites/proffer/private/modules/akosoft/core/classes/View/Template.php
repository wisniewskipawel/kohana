<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class View_Template extends View {
	
	protected $_template_type = NULL;
	
	protected static $_instances = array();

	public static function instance($type)
	{
		if(isset(self::$_instances[$type]))
		{
			return self::$_instances[$type];
		}
		
		return self::set_instance($type, self::factory($type));
	}
	
	public static function set_instance($type, View_Template $template_class)
	{
		$template_class->set_template_type($type);
		return self::$_instances[$type] = $template_class;
	}

	public static function factory($name = NULL, array $data = NULL)
	{
		// Set class name
		$templ_cls = 'Template_'.ucfirst(str_replace('/', '_', $name));
		
		if(class_exists($templ_cls))
		{
			return new $templ_cls('template/'.$name, $data);
		}
		else
		{
			return new self($name, $data);
		}
	}

	public function set_template_type($type)
	{
		$this->_template_type = $type;
		return $this;
	}

	public function initialize()
	{
		$this->set_global('template', $this);
		
		//initialize template variables
		$this->meta_title = '';
		$this->rss_links = array();
		$this->layout_data = array();
		$this->meta_tags = array();
		
		$this->meta_tags['description'] = array(
			'name' => 'description',
			'content' => Kohana::$config->load('global.site.meta.description'),
		);
		
		$this->meta_tags['keywords'] = array(
			'name' => 'keywords',
			'content' => Kohana::$config->load('global.site.meta.keywords'),
		);
		
		if(Kohana::$config->load('global.site.meta.robots'))
		{
			$this->meta_tags['robots'] = array(
				'name' => 'robots',
				'content' => Kohana::$config->load('global.site.meta.robots'),
			);
		}
		
		$this->meta_tags['og:site_name'] = array(
			'property' => 'og:site_name',
			'content' => Kohana::$config->load('global.site.meta.title'),
		);
		
		$this->meta_tags['og:type'] = array(
			'property' => 'og:type',
			'content' => 'website',
		);
	}
	
	public function set_title($title, $prepend = TRUE)
	{
		$_title = UTF8::trim($title);
		
		if(empty($_title))
			return NULL;
		
		if($prepend)
		{
			$_title .= ' - '.Arr::get($this->_data, 'meta_title');
		}
		
		$this->meta_title = trim($_title, ' - ');
		
		return $title;
	}
	
	public function set_meta_tags($meta_tags)
	{
		$this->meta_tags = array_merge((array)$this->meta_tags, (array)$meta_tags);
	}
	
	public function add_meta_name($name, $content)
	{
		if(!$content)
			return;
		
		$this->meta_tags[$name] = array(
			'name' => $name,
			'content' => $content,
		);
	}
	
	public function add_meta_property($property, $content)
	{
		if(!$content)
			return;
		
		$this->meta_tags[$property] = array(
			'property' => $property,
			'content' => $content,
		);
	}
	
	public function set_layout($view, $params = NULL)
	{
		if($view instanceof View)
		{
			$this->layout = $view;
		}
		elseif(is_string($view))
		{
			$this->layout = View::factory($view);
		}
		
		if($params)
		{
			$this->layout->set($params);
		}
		
		return $this;
	}
	
	public function set_default_layout($view)
	{
		$this->default_layout = $view;
		
		return $this;
	}
	
	public function render_layout()
	{
		if(isset($this->layout))
		{
			if(is_string($this->layout))
			{
				$this->set_layout($this->layout);
			}
		}
		else
		{
			if(isset($this->default_layout))
			{
				$this->set_layout($this->default_layout);
			}
		}
		
		if(isset($this->layout))
		{
			if($this->layout instanceof View AND isset($this->layout_data))
			{
				$this->layout->set($this->layout_data)
					->set('content', isset($this->content) ? (string)$this->content : NULL);
			}

			return (string)$this->layout;
		}
		
		return NULL;
	}
	
	public function render($file = NULL)
	{
		if(!isset($this->meta_tags['og:description']))
		{
			$this->meta_tags['og:description'] = array(
				'property' => 'og:description',
				'content' => Arr::path($this->meta_tags, 'description.content'),
			);
		}
		
		if(!isset($this->meta_tags['og:title']))
		{
			$this->meta_tags['og:title'] = array(
				'property' => 'og:title',
				'content' => $this->meta_title,
			);
		}
		
		if($site_title = Kohana::$config->load('global.site.meta.title'))
		{
			if($this->meta_title)
			{
				$this->meta_title .= ' - ';
			}

			$this->meta_title .= $site_title;
		}
		
		if(!isset($this->meta_tags['og:image']))
		{
			$this->meta_tags['og:image'] = array(
				'property' => 'og:image',
				'content' => URL::site('media/img/logo.png', 'http'),
			);
		}
		
		$this->content = isset($this->content) ? (string)$this->content : NULL;
		$this->layout = $this->render_layout();
		
		return parent::render($file);
	}
	
	protected function _get_config()
	{
		if(!$this->_template_type)
		{
			throw new Exception('No template type is set!');
		}
		
		return Kohana::$config->load('global.templates.'.$this->_template_type);
	}
	
	public function config($path = NULL, $default = NULL)
	{
		if($path)
		{
			return Arr::path($this->_get_config(), $path, $default);
		}
		
		return $this->_get_config();
	}
	
}