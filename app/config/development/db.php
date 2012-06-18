<?php
/**
 * The production database settings.
 */

return array(
	'default' => array(
		'connection'  => array( 
	        'dsn'            => 'mysql:host=localhost;dbname=mincms',
	        'username'       => 'test',
	        'password'       => 'test',
	        'persistent'     => false, 
		),
	),
);
