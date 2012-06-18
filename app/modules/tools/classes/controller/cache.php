<?php
namespace Tools;

function cache_install(){
	return array(
		'label'=>__('comm.clear cache'),	
		'url'=>'index',
		'author'=>'sun kang',
		'im'=>'68103403@qq.com',
	); 
}

/** 
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Cache extends \Controller_Base_Auth
{ 
	public $s;
	public $min;
	public $max;
	function before(){
		parent::before(); 
		$this->menus = \Vendor\Tools::init(); 
		$this->menus['active_url'] = \Uri::create('admin/tools/index');
		 
 	}
 	/**
 	* @缓存列表
 	*/
 	function action_index()
	{  
		  
		$posts = \Model_Cache::find('all');
		$view = \View::forge('cache/index');
		$view->set('posts',$posts); 
		$this->template->content = $view; 
	}

	/**
	* @删除指定缓存
	*/
	function action_del($id){ 
		$post = \Model_Cache::find($id); 
	 	\Cache::delete($post->cache_id);
	 	
		if($post->delete())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('tools/cache/index'));
		} 
	}
	
	/**
	* @清空所有缓存
	*/
	function action_clear(){ 
		$posts = \Model_Cache::find('all'); 
		foreach($posts as $post){
	 		\Cache::delete($post->cache_id);
	 		$post->delete();
	 	}
	 
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('tools/cache/index'));
	 
	}
	
 
	
 	
  
}
