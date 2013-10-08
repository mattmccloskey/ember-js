<?php

/*
|
|	Ember JS class. 
|	Creates a unified js file with config data and autoloads the controller class
|
|	# Paste the following line in your .htaccess file
|	RewriteRule ^emberjs/build/(.+)?\.js$ index.php/emberjs/build/$1 [L]
|
*/

class Ember_js {

	var $config			= array();
	var $lang			= array();
	var $data			= array();
	var $controller 	= false;
	var $method			= false;
	var $scripts		= array();
	var $controller_instance_name = 'window.controller';
	
	// Replace constant BASEPATH from Ember
	var $basepath		= './';
	
	var $active			= true;
	
	var $uniqkey		= '';
	
	function Ember_js($config = array())
	{
		// Generate the unique key for saving info
		//$this->uniqkey = uniqid();
		
		// Create the file cache
		
		// CI config structure is different than EMBER
		// For CI we store config in it's own array inside
		// the global config file to avoid overlap
		$config = $config['ember_js'];
		
		// Constructor
		$this->config = $config;
		$this->controller_instance_name = $config['controller_instance_name'];
		
		global $RTR;
		$this->directory = $RTR->fetch_directory();
		$this->controller = $RTR->fetch_class();
		$this->method = $RTR->fetch_method();
		
		// Scripts
		foreach($config['scripts'] as $src) $this->add_script($src);
	}
	
	function set($data, $value = false)
	{
		if(is_array($data))
		{
			foreach($data as $key => $value) $this->data[$key] = $value;
		}
		else
		{
			$this->data[$data] = $value;
		}
	}
	
	function clear_data()
	{
		$this->data = array();
	}
	
	function set_controller($name)
	{
		$this->controller = $name;
	}
	
	function set_method($method)
	{
		$this->method = $method;
	}
	
	function set_config($item, $value)
	{
		$this->config['config'][$item] = $value;
	}
	
	function set_lang($item, $value)
	{
		$this->lang[$item] = $value;
	}
	
	function add_script($src)
	{
		// Check to see if file exists
		if( ! file_exists($src))
		{
			// Check the assets js directory
			$EMBER =& get_instance();
			if(file_exists($EMBER->assets->js_directory.$src))
			{
				$src = $EMBER->assets->js_directory.$src;
			} 
		}
		
		$this->scripts[] = $src;
	}
	
	function get_scripts()
	{
		if($path = $this->get_base_controller_path())
		{
			$this->scripts[] = $path;
		}

		if($path = $this->get_controller_path())
		{
			$this->scripts[] = $path;
		}		

		return $this->scripts;
	}
		
	function get_controller_path()
	{
		$controller = ucwords($this->controller);
		return file_exists($this->basepath.$this->config['controllers_directory'].$controller.'.js') ? $this->config['controllers_directory'].$controller.'.js' : false;
	}
	
	function get_controller_url()
	{
		$controller = ucwords($this->controller);
		$path = $this->get_controller_path();
		if($path) return site_url($path);
		else return false;
	}
	
	function get_base_controller_path()
	{
		return file_exists($this->basepath.$this->config['controllers_directory'].$this->config['default_controller'].'.js') ? $this->config['controllers_directory'].$this->config['default_controller'].'.js' : false;
	}
	
	function get_base_controller_url()
	{
		$path = $this->get_base_controller_path();
		if($path) return site_url($path);
		else return false;
	}
	
	
	
	
	
	/* Return the URL for the Ember.js Base */
	function get_ember_js_url()
	{
		return site_url($this->config['controller'].'/build/'.$this->controller.'/'.$this->method.'.js');
	}
	
	/* Get the config data for the Controller */
	function get_config()
	{
		$this->data['controller'] = $this->controller;
		$this->data['method'] = $this->method;
		return json_encode($this->data);
	}
	
	/* Get the dom ready script */
	function get_domready()
	{		
		if($path = $this->get_controller_path())
		{
			$contents = file_get_contents($this->basepath.$path);
			$controller = ucwords($this->controller);
		}
		else if($path = $this->get_base_controller_path())
		{
			$contents = file_get_contents($this->basepath.$path);
			$controller = ucwords($this->config['default_controller']);
		}
		
		$config = $this->get_config();
		$initialize = "window.ember_domready = function(){ {$this->controller_instance_name} = new {$controller}({$config});";
		if($this->method && strpos($contents, $this->method.':')) $initialize .= " if(typeOf({$this->controller_instance_name}.{$this->method}) == 'function') {$this->controller_instance_name}.{$this->method}();";
		$initialize .= " };";
		return $initialize;
	}
	
	
	
	
	// --------------------------------------------------------------------
		
	/**
	 * Output final ember.js
	 * 
	 */
	function output_js($controller = false, $method = false)
	{
		// Add the controller & method
		if($controller) $this->set_controller($controller);
		if($method) $this->set_method($method);
		
		$scripts = $this->get_scripts();
		
		// CACHING -----------------------------------------------------------------
		// Calculate last modification date
		$last_modified = false;
		foreach($scripts as $src)
		{
			if(file_exists($this->basepath.$src))
			{
				$date = filemtime($this->basepath.$src);
				$last_modified = $last_modified ? max($last_modified, $date) : $date;
			}
		}
		
		$etag = $eTag = "ci-".dechex(crc32($this->get_ember_js_url().$last_modified));
		
		
		
		$if_modified_since = false;
		$if_none_match = false;
		if(function_exists('apache_request_headers'))
		{
			$headers = apache_request_headers();
			$if_modified_since = isset($headers['If-Modified-Since']) ? $headers['If-Modified-Since'] : false;
			$if_none_match = isset($headers['If-None-Match']) ? $headers['If-None-Match'] : false;
		}
		else
		{
			$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false;
			$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : false;
		}
		
		if (
			($if_none_match && strpos($if_none_match, "$eTag")) 
			&& ($if_modified_since && gmstrftime("%a, %d %b %Y %T %Z", $last_modified) == $if_modified_since)
		) 
		{
			// They already have an up to date copy so tell them
			header('HTTP/1.1 304 Not Modified');
			header('ETag: "'.$eTag.'"');			
			exit;
		
		} else {
			// We have to send them the whole page
			header('Content-type: text/javascript');
			header('Last-Modified: '.gmstrftime("%a, %d %b %Y %T %Z",$last_modified));
			header('ETag: "'.$eTag.'"');
		}
		
		// END CACHING -------------------------------------------------------------
		
		
		// Add to the config object
		$config = $this->config['config'];
		$config['site_url'] = site_url();
		$config_json = json_encode($config);
		
		// Add the lang object
		$lang_json = json_encode($this->lang);
				
		// ---------------------------------------------------
		
		ob_start();
		
		echo "// Ember.js \n\n";
		
		echo "var config = ".$config_json.";\n\n";
		echo "var lang = ".$lang_json.";\n\n";
		
		echo "/* Javascripts\n----------------------------------------------------------------------------------------------------- */\n\n";
		
		foreach($scripts as $src)
		{
			echo "\n\n/* ".substr($src, strrpos($src, '/') + 1)."\n----------------------------------------------------------------------------------------------------- */\n\n";
			include $this->basepath.$src;
		}
		
		echo "\n\n/* Domready\n----------------------------------------------------------------------------------------------------- */\n\n";
		
		echo "window.addEvent('domready', function(){ config = new Hash(config); if(typeOf(ember_domready) == 'function') ember_domready(); });";
		
		ob_end_flush();
	}
	
}