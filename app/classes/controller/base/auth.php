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
 	 	// set language by current login user
 	 	$user = \Model_Users::find($this->uid); 
    	$profile = \Format::forge($user->profile_fields, 'json')->to_array() ;
    	$language = 'zh';
    	if($profile['language']){
    		$lan = \Model_Language::find($profile['language']);
    		$language = $lan->code;
    	} 
 	 	Config::set('language', $language );
 	 	Lang::load('comm', 'comm');
 	 	
 	} 
 	public function lists($current_url,$model,$view=null,$uri_segment=3,$per_page=null){
 		return \Vendor\Db::lists($current_url,$model,$view,$uri_segment,$per_page);
 	}
 	
 	function cck_access(){
 		if($this->cck_enable()!=1){   
			\Session::set_flash('error', __('comm.access deny,cck is locked'));
			\Response::redirect(\Uri::create('admin/home/index')); 
		}
 	}
 	function admin_access(){
 		if(!in_array($this->uid,$this->super_admin)){ 
			\Session::set_flash('error', __('comm.access deny'));
			\Response::redirect(\Uri::create('admin/home/index')); 
		}
 	}
 	//check cck is enable
	function cck_enable(){
		if($this->_config('admin_cck_enable')==1)
			return true;
		return false;
	}
 	 
 	protected function clear_all_cache(){
 		$posts = \Model_Cache::find('all'); 
		foreach($posts as $post){
	 		\Cache::delete($post->cache_id);
	 		$post->delete();
	 	}
 	}
}
