ember-js
========

A Javascript MVC framework for CodeIgniter and MooTools.

Ember JS does three awesome things:
- Combines separate javascript files into a single document, making for cleaner head areas.
- Automatically loads and instantiates controllers based upon which CI controller is active
- Allows you to easily pass information from PHP to your Javascript without printing data into the DOM.

Installation
- Move the config file to application/config/ember_js.php
- Move the Ember_js.php library file to application/libraries/Ember_js.php
- In your document head echo $this->ember_js->get_domready();