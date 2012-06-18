<?php
return array(
	'_root_'  => 'home/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'u.com' => array('web/index'),
	'posts' =>'posts/index',
	'road' =>'home/road',
	'admins'=>'admin/home/index',
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
	//·ɵû
	'(:any)!'      => 'home/user/$1',
);