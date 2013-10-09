<?php

/*
|
|	Generates the Ember.js Main Script file
|
*/

class Emberjs extends CI_Controller {
	
	function build($controller = false, $method = false)
	{		
		$this->ember_js->output_js($controller, $method);
	}
}

/* End of file */
/* Location: ./system/application/controllers/ */