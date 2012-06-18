<?php
namespace Tools;
function database_install(){
	return array(
		'label'=>'database backup',	
		'url'=>'backup',
		'author'=>'sun kang',
		'im'=>'68103403@qq.com',
	); 
}
/**
* database backup and import
* need auth,just admin has access. so use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Database extends \Controller_Base_Auth{
	public $dir;
	public $bin;
	public $path;
	public $db_username;
	public $db_password;
	public $db_name; 
 
	
	function before(){
		parent::before();
		$this->menus = \Vendor\Tools::init(); 
		$this->menus['active_url'] = \Uri::create('admin/tools/index');
		$result = \DB::query("SHOW VARIABLES LIKE  '%basedir%'", \DB::SELECT)->execute()->as_array(); 
		$this->bin =  $result[0]['Value'].'/bin/';
		$this->path = APPPATH.'../data';
		$this->dir = scandir($this->path);
		
		//取得当前使用的数据库 信息
		$c = \Config::get('db');
		$db = $c[$c['active']];
		$dsn = $db['connection']['dsn'];
		$this->db_username = $db['connection']['username'];
		$this->db_password = $db['connection']['password'];
		$this->db_name = substr($dsn,strrpos($dsn,'=')+1); 
 	}
	//备份首页
	function action_backup(){ 
		// 取得备份目录下文件
		$data = array();
		foreach($this->dir as $vo){  
			if($vo != '.' && $vo != '..' && $vo != '.svn' && substr($vo,-4) == '.sql')
				$data[] = $vo;
		 } 
		//最近的放在最上面
		rsort($data); 
		$view = \View::forge('database/backup');
		$view->set('posts',$data); 
		$view->set('path',$this->path); 
		$this->template->content = $view;
	}
	//操作数据备份
	function action_backup_do(){ 
		$sql = $this->bin."mysqldump  --skip-comments  -u".$this->db_username."  -p".$this->db_password ."   ".$this->db_name." > ".$this->path.'/'.$this->db_name.'-'.date('Y-m-d-H-i-s',time()).'.sql';
 		exec($sql);  
		\Session::set_flash('success', __('comm.save success') );
		\Response::redirect(\Uri::create('tools/database/backup')); 
	}
	/**
	* 恢复数据库
	*/
	function action_import($db){ 
		$db = \Crypt::decode($db, 'Joa&lo9');
		$sql = $this->bin."mysql     -u".$this->db_username."  -p".$this->db_password ."   ".$this->db_name." < ".$this->path.'/'.$db; 
		exec($sql);  
		\Session::set_flash('success', __('comm.save success') );
		\Response::redirect(\Uri::create('tools/database/backup')); 
	}
	function action_remove($id){
		$f = \Crypt::decode($id, 'Joa&lo9');
		$file = $this->path.'/'.$f;  
		if(file_exists($file)){
			unlink($file);
			\Session::set_flash('success', __('comm.save success') );
			\Response::redirect(\Uri::create('tools/database/backup')); 
		}
		\Session::set_flash('error', __('comm.save error') );
		\Response::redirect(\Uri::create('tools/database/backup')); 
	}
}