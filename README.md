ember-js
========

A Javascript MVC framework for CodeIgniter and MooTools.

## Ember JS does three awesome things:
1. Automatically loads and instantiates Javascript controllers based upon which CI controller is active.
2. Allows you to easily pass information from PHP to your Javascript without printing data into the DOM.
3. Combines separate javascript files into a single document, making for cleaner head areas.

## Usage
Make sure to load the Ember_js library in your controller, or add it to the libraries array in autoload.php
```
$this->load->library('ember_js');
```

Print ember into your document head
```
<? $this->ember_js->print_head(); ?>
```

#### Create a javascript controller
Copy example-controller.js and make some controllers! For example, if you have a CI controller called "welcome.php" create assets/js/controllers/Welcome.js. That file will be automatically loaded and instantiated every time the Welcome controller is active in CI.

If your Welcome controller has "news" method (Example, welcome/news), then add a news method to your Welcome.js, and it will be automatically executed.

```
var Welcome = new Class({
	
	Extends: Controller,
	
	initialize: function()
	{
		this.parent.attempt(arguments, this);
		
		// Controller wide code goes here

	},
	
	/*
	*	Methods get called automatically corresponding to the active CI method
	*/
	index: function()
	{
		// This runs at welcome
	},
	
	news: function()
	{
		// This runs at welcome/news
	}
	
});
```

#### Passing data from your PHP to your Javascript controllers:

In PHP you can use ember_js->set() to pass data to your javascript controllers.
```
<?
	// Single variable
	$this->ember_js->set('first_name', 'matt');
	
	// Multiple
	$this->ebmer_js->set(array('last_name' => 'McCloskey', 'age' => 31));
?>
```

Then you can access that data in your javascript controller from the options object:
```
alert(this.options.first_name + ' '+ this.options.last_name +' is '+this.options.age);
```

## Function Reference
#### set()
Pass data from PHP to Javascript
```
$this->ebmer_js->set(array('last_name' => 'McCloskey', 'age' => 31));
```

#### set_controller()
If you want ember to run a different javascript controller than the one active in CI
```
$this->ember_js->set_controller('another_controller');
```

#### set_method()
If you want ember to run a different javascript method than the one active in CI
```
$this->ember_js->set_method('another_controller');
```


## Configuration

### config/ember_js.php
- **controllers_directory** - The directory where you store your JS controllers. Defaults to 'assets/js/controllers/'
- **scripts** - A list of scripts to always load (paths should be relative to **controllers_directory**)
- **default_controller** - The default controller, and controller which all custom controllers should extend.
- **config** - Data to be loaded into the config object. Variables like site_url are automatically set
- **controller_instance_name** - The variable name that initialized controllers are given in JS. Defaults to window.controller