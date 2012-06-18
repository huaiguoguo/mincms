<?php
namespace Admin;
/**
* tools 
* need auth,just admin has access. so use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Tools extends \Controller_Base_Auth
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
 	* @工具列表
 	*/
 	function action_index()
	{  
		  $path = APPPATH.'/modules/tools/classes/controller';
		  $file = \Vendor\Dir::listFile($path); 
		  $files = $file['file'];
		  $i = 0;  
		  
		  foreach($files as $f){
			  $f = str_replace('.php','',$f); 
			  $dir = APPPATH.'modules/tools/classes/controller/'.$f.'.php';
			  include_once $dir;
			  $install = '\\Tools\\'.$f.'_install';
			  $vo = $install();  
			  $url = 'tools/'.$f.'/'.$vo['url'];
			  $post = \Model_Tool::find('first',array('where'=>array('url'=>$url)));
			  if($post){
				  if($vo['label'] != $post->label || $vo['author'] != $post->author || $vo['im'] != $post->im ||$url != $post->url){
					$post->label = $vo['label'];
					$post->author = $vo['author'];
					$post->im = $vo['im'];
					$post->url = $url;
					$post->save();
				  } 
			  }
			  else{
				    $post = new \Model_Tool;
					$post->label = $vo['label'];
					$post->author = $vo['author'];
					$post->im = $vo['im'];
					$post->url = $url;
					$post->save();
					$post->sort = $post->id;
					$post->save();
			  }
			  $urls[] =  $url;
			  $i++;
		  }
		  // for sort
		  $this->min = \Model_Tool::min('sort');
		  $this->max = \Model_Tool::max('sort');
		  
		  /**
		  *
		  * clear not exists link
		  */
		  $models = \Model_Tool::find('all');
		  foreach($models as $m){
			if(!in_array($m->url,$urls)){  
				$m->delete(); 
			}
		  }

		  $posts = \Model_Tool::find('all',array('order_by'=>array('sort'=>'desc','id'=>'desc')));
		  $view = \View::forge('tools/index');
		  $view->set('posts',$posts);
		  $view->set('min',$this->min);
		  $view->set('max',$this->max);
		  $this->template->content = $view; 
	}

	/**
	* @启用或禁用工具
	*/
	function action_active($id){ 
		$post = \Model_Tool::find($id); 
		if($post->active==1)
			$post->active = 0;
		else
			$post->active = 1;
		if($post->save())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/tools/index'));
		} 
	}
	
	/**
	*
	* @工具排序
	*/
	function action_sort($id,$s='up'){
		$this->_sort($id,$s,'\Model_Tool');
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('admin/tools/index')); 
	}
 	 
 
	
 	
  
}
