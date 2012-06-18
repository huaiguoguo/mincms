<?php

 
class Controller_Base_Auth extends \Controller_Base_Admin
{
	public $auth_links;
 	public $uid = 0;
 	public $super_admin = array();
 	public function before() {
 		parent::before();  
 		if(!\Auth::check()){
		  \Response::redirect(Uri::create('admin/login/index'));
		} 	
		
		$this->auth_links = array(
			array('label'=>__('comm.user'),'url'=>\Uri::create('admin/user/index')),
			array('label'=>__('comm.user add'),'url'=>\Uri::create('admin/user/add')), 
			array('label'=>__('comm.user group'),'url'=>\Uri::create('admin/group/index')), 
			array('label'=>__('comm.user group add'),'url'=>\Uri::create('admin/group/add')),
		    array('label'=>__('comm.acl'),'url'=>\Uri::create('admin/acl/index')),
		
		);	  
		$super_auth = \Config::get('super_auth');
		if(!is_array($super_auth)){
			$super_auth = array(1);
		}else{
			$super_auth = array_merge($super_auth,array(1));
		} 
		$this->super_admin = $super_auth;
 	  	$user = \Auth::instance()->get_user_id();
 	 	$this->uid = $user[1];  
 	 	if(!in_array($this->uid,$super_auth)){
 	 		$controller = \Vendor\Str::replace($this->request->controller);  
			$access = \Auth::has_access(array(
	            $controller,
	            strtolower($this->request->action)
	        ));  
	        if(!$access){
	        	\Session::set_flash('error', 'access deny,you can not visite this page');
				\Response::redirect(\Uri::create('admin/login/index'));
	        }
 	 	}
 	 	
 	} 
 	//check cck is enable
	function cck_enable(){
		if($this->_config('admin_cck_enable'))
			return true;
		return false;
	}
 	/**
 	* setting paginate
 	*/
 	public function config_paginate($configs=array(),$class='digg_pagination'){ 
 		$config = array(
		    'pagination_url' => "#",
		    'total_items' =>0,
		    'per_page' => (int)$this->_config('admin_pagination')?:10,
		    'uri_segment' => 3,
		    'template' => array(
		    	'wrapper_start' => "<div class='$class'> ",
		        'wrapper_end' => ' </div>',
		        'page_start' => '  ',
		        'page_end' => '  ',
		        'previous_start' => ' ',
		        'previous_end' => '  ',
		        'previous_inactive_start' => '<span class="disabled"> ',
		        'previous_inactive_end' => '</span>  ',
		        'previous_mark' => '&laquo; ',
		        'next_start' => ' ',
		        'next_end' => '  ',
		        'next_inactive_start' => '<span class="disabled"> ',
		        'next_inactive_end' => '</span> ',
		        'next_mark' => ' &raquo;',
		        'active_start' => '<em class="current">',
		        'active_end' => '</em> ',
		        'regular_start' => '',
		        'regular_end' => '', 
		    ),
		); 
		if($configs){
 			$config = array_merge($config,$configs);
 		}
		Config::set('pagination', $config);
 	}
 	
 	protected function clear_all_cache(){
 		$posts = \Model_Cache::find('all'); 
		foreach($posts as $post){
	 		\Cache::delete($post->cache_id);
	 		$post->delete();
	 	}
 	}
}
