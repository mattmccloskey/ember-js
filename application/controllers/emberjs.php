<?php

/*
|
|	Generates the Ember.js Main Script file
|
*/

class Emberjs extends MY_Controller {

	function Emberjs()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$this->build();
	}
	
	function build($controller = false, $method = false)
	{
		foreach($this->lang->language as $key => $val) $this->ember_js->set_lang($key, $val);
		
		$this->ember_js->output_js($controller, $method);
	}
}

/* End of file */
/* Location: ./system/application/controllers/ */