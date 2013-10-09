<?php


/*
|---------------------------------------------------------------
| EMBER.JS Config
|---------------------------------------------------------------
|
*/


/*
|---------------------------------------------------------------
| CONTROLLER DIRECTORY
|---------------------------------------------------------------
|
|	The directory the JS controllers are in
|
|	WITH TRAILING SLASH!
|
*/

$config['ember_js']['controllers_directory']	= 'assets/js/controllers/';


/*
|---------------------------------------------------------------
| DEFAULT SCRIPTS
|---------------------------------------------------------------
|
|	The default scripts which will be loaded on every page
|
*/
$config['ember_js']['scripts'] = array(
	'assets/js/libraries/mootools-core.js',
	'assets/js/libraries/mootools-more.js'
);


/*
|---------------------------------------------------------------
| PAGE CONTROLLER
|---------------------------------------------------------------
|
|	The default page controller class name. All other controllers
|	should extend this class
|
*/

$config['ember_js']['default_controller']	= 'Controller';


/*
|---------------------------------------------------------------
| JS CONFIG
|---------------------------------------------------------------
|
|	Values to be added to the JS config hash by default. Values 
|	like 'site_url' get added automatically
|
*/

$config['ember_js']['config'] = array(

);



/*
|---------------------------------------------------------------
| JS CONTROLLER
|---------------------------------------------------------------
|
|	The controller to generate the main JS file.
|	(Access this file by adding .js to the end)
|
|	NO SLASHES
|
*/

$config['ember_js']['controller'] = 'emberjs';


/*
|---------------------------------------------------------------
| CONTROLLER INSTANCE NAME
|---------------------------------------------------------------
|
|	When the controller is initialized, it will be assigned
|	to a variable with the name defined here
|
|
*/

$config['ember_js']['controller_instance_name'] = 'window.controller';




/*
|---------------------------------------------------------------
| END CONFIG
|---------------------------------------------------------------
*/





/* End of file */