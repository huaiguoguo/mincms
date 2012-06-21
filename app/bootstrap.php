<?php

// Load in the Autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';


Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
	'Lang' => APPPATH.'classes/lang.php', 
 
	 
		
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGE
 * Fuel::PRODUCTION
 */
Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);
//Fuel::$env = Fuel::PRODUCTION; 
// Initialize the framework with the config file.
Fuel::init('config.php');
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));  

//custom function
function url($url){
	return \Uri::create($url);
}
//load plugin
function plugin($type,$params=null){
	return \Vendor\Plugin::load($type,$params);
}
function node_one($table,$params=null,$cck=true){
	return \Vendor\Content::node_one($table,$params,$cck);
}
function node($table,$params=null,$cck=true){
	return \Vendor\Content::node($table,$params,$cck);
}
function node_page($table,$params,$current_url,$uri_segment=3,$per_page=10,$paginate_class='apple_pagination'){
	return \Vendor\Content::node_page($table,$params,$current_url,$uri_segment,$per_page,$paginate_class);
}
if(!function_exists('html_link')){
	function html_link($link,$label){
		return \Html::anchor($link,$label);
	}
}
if(!function_exists('decode')){
	function decode($arr){
		return \Vendor\Content::decode($arr);
	}
}