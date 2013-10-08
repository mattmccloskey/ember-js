/*
---
Ember Controller: Example Home controller

copyrights:
  - [Kemso](http://kemso.com)

licenses:
  - [MIT License]
...
*/

/*
*	Example Controller
*	Name this file after the CI controller you want to use it with.
*	Note: Filename, and class name should both be lower case, except for the first letter which is uppercase!
*/

var Examplecontroller = new Class({
	
	Extends: Controller,
	
	initialize: function()
	{
		this.parent.attempt(arguments, this);
		
		/* Controller wide code goes here */

	},
	
	/*
	*	Methods get called automatically corresponding to the active CI method
	*/
	index: function()
	{
		
	}
	
	
});