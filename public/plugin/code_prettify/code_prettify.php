<?php

class plugin_code_prettify{
	function install(){
		return array( 
		 	 'discription'=>'google-code-prettify', 
		 	 'web'=>'http://code.google.com/p/google-code-prettify/',
		 	 'code'=>'prettyPrint(); ',
		 	 'css'=>array('code-prettify/sons-of-obsidian.css'),
		 	 'js'=>array('code-prettify/prettify.js'),
		 );
		 
		 
		 
	}
	 
}
 