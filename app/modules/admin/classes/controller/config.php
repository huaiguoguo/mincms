<?php
namespace Admin;
/**
* config system
* need auth,just admin has access. so use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Config extends \Controller_Base_Auth
{ 
	public $s;
	function before(){
		parent::before();
		$this->breadcrumb = array(
			array('label'=>__('comm.config'),'url'=>\Uri::create('admin/config/index'),'active'=>true),
 		 
		); 
		$this->menus['active_url'] = \Uri::create('admin/config/index');
 	}
 	/**
 	* @系统配置
 	*/
 	function action_index()
	{ 
		 $models = \Model_Config::find('all');
		 foreach($models as $model){
			$data[$model->name] = $model->val; 
		 }
		 $view = \View::forge('config/index');
		 $view->set('post',$data,false);
		 if($_POST){
			$config = $_POST['config'];
			foreach($config as $k=>$v){
				$k = trim($k);
				$v = trim($v);
				if(!$v) continue;
				$post = \Model_Config::find('first',array(
						'where'=>array('name'=>$k)	
						));
				if(!$post)
					$post = new \Model_Config;
				if(false!==strpos($k,'password') && $v){ 
					 $v = \Crypt::encode($v, 'jE@I');
				}
				$post->name = $k;
				$cck = \Model_Config::find('first',array(
						'where'=>array('name'=>'admin_cck_enable')	
						)); 
				
				if($k=='admin_cck_enable' && $v==1 && $cck->val!=1) { 
					
					//send mail to admin, that can active cck
					$mail = new \Vendor\Email;
					$u = \Model_Users::find(1);
					$v = \Str::random('alpha', 5);
					$e = \Crypt::encode($v); 
					$mail_title = '系统通知,启用内容管理工具';
					$mail_content = "<a href='".\Uri::create('admin/config/active/'.$e)."'>请点击这里启用内容自定义工具</a><br>或直接访问<br>".\Uri::create('admin/config/active/'.$e);
					$mail->send(array($u->email),$mail_title,$mail_content); 
				} 
				
				$post->val = $v;
				$post->save(); 
			}
			\Cache::delete('admin_config');
			\Session::set_flash('success', __('comm.save success') ); 
			\Response::redirect(\Uri::create('admin/config/index'));
		 }
		 $this->template->content = $view;
	}

	function action_active($str){
		$e = \Crypt::decode($str); 
		$post = \Model_Config::find('first',array(
						'where'=>array('name'=>'admin_cck_enable','val'=>$e)	
						));
		if(!$post){
			\Session::set_flash('error', __('comm.token error') ); 
			\Response::redirect(\Uri::create('admin/config/index'));
		}
		$post->val = 1;
		$post->save();
		\Session::set_flash('success', __('comm.save success') ); 
		\Response::redirect(\Uri::create('admin/config/index'));
	}
	
 	 
	
	
 	
  
}
