ember-js
========

A Javascript MVC framework for CodeIgniter and MooTools.

## Ember JS does three awesome things:
1. Automatically loads and instantiates Javascript controllers based upon which CI controller is active.
2. Allows you to easily pass information from PHP to your Javascript without printing data into the DOM.
3. Combines separate javascript files into a single document, making for cleaner head areas.

## Installation
1. Move the config file to application/config/ember_js.php
2. Move the Ember_js.php library file to application/libraries/Ember_js.php
3. Move the assets folder into your site root (the same folder as index.php, application, and system).

## Usage
#### In your document head:
```
<? echo $this->ember_js->get_domready(); ?>
```

Now, copy example-controller.js and make some controllers! For example, if you have a CI controller called "Home" create a Home.js in your controller directory. That file will be automatically loaded every time the Home controller is active in CI. 

If your Home controller has "news" method (Example, home/news), then add a news method to your Home.js, and it will be automatically executed.

#### Pass data from your PHP to your Javascript controllers:

In PHP you can use "set" method to pass data to your controllers.
```
<?
	// Single variable
	$this->ember_js->set('first_name', 'matt');
	// Multiple
	$this->ebmer_js->set(array('last_name' => 'McCloskey', 'age' => 31));
?>
```

Then you can access that data in your JS controller from the options object:
```
alert(this.options.first_name + ' '+ this.options.last_name +' is '+this.options.age);
```

3. Set site config data
Ember JS creates a global object in JS called "config". It gets automatically loaded with some things like "site_url". You can add values to this using the __config__ setting in config/ember_js.php, or by calling $this->ebmer_js->set_config(); from your CI controllers.

````
<?
	$this->ebmer_js->set_config(array('user_id') => 1));
?>
````

## Configuration

### config/ember_js.php
**controllers_directory** - The directory where you store your JS controllers. Defaults to 'assets/js/controllers/'
**scripts** - A list of scripts to always load (paths should be relative to **controllers_directory**)
**default_controller** - The default controller, and controller which all custom controllers should extend.
**config** - Data to be loaded into the config object. Variables like site_url are automatically set
**controller_instance_name** - The variable name that initialized controllers are given in JS. Defaults to window.controller