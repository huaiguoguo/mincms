<?php

class Controller_Home extends \Controller_Base_Home
{ 
	
	public function action_index()
	{ 
		//$this->_pagecache->enableCache();
	 
		$this->template->set('content', View::forge('home/index',$data), false);  
	}
	
	function action_road(){
		$this->template->set('content', View::forge('home/road'), false);  
	}
	
	/**
	* еû·ɵ
	'(:any)!'      => 'home/user/$1',
	*/
	public function action_user($u)
	{
	 	print_r($u);exit;
		$data = array();
		if(Auth::check()) $data['name'] = Auth::instance()->get_screen_name();
		
		$this->template->set('content', View::forge('welcome/index',$data), false); 
 
	}
 
}
