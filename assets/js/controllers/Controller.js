/*
---
Ember Page Controller: The Ember default controller

copyrights:
  - [Kemso](http://kemso.com)

licenses:
  - [MIT License]
...
*/


var Controller = new Class({
	
	Implements: Options,
	
	options: {
	},
	
	/*
	*	Set options.Initialize the page.
	*/
	initialize: function(options)
	{

		/*
		*	Set the options
		*/
		this.setOptions(options);

	}
	
	
});


/*
*	Set up HTML5 Elements
*/
function doeach(arr, fn) {
    for (var i = 0, arr_length = arr.length; i < arr_length; i++) {
        fn.call(arr, arr[i], i);
    }
}
doeach("abbr|article|aside|audio|canvas|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video".split("|"), function(el) { document.createElement(el); });