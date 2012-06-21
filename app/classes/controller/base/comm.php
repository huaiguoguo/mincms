<?php

 
class Controller_Base_Comm extends \Controller
{
	/**
	* 面包削导航
	*/
	public $breadcrumb=array();
	//首页
	public $home_breadcrumb=array();
	//菜单
	public $menus = array();
	//template page title 
	public $page_title = null;
	public $page_out = array();

 	public function before() {
 		parent::before(); 
 		Config::set('language', 'zh');
 		Lang::load('comm', 'comm');
		date_default_timezone_set('Asia/Shanghai');  
		Autoloader::add_namespace('Vendor', APPPATH.'vendor/'); 
		$this->page_title = 'Application build on FuelPHP'.Fuel::VERSION; 

 	}
 
 	/**
 	* comm way for list pages
 	$url = \Uri::create('admin/language/index');
	$this->lists($url,'Model_Language','language/index',3,1);
	or safe can ignore
	$this->lists($url,'Model_Language',array('language/index',array('msg'=>$this->s),'safe'=>true),4);
	
 	*/ 	
 	public function lists($current_url,$model,$view,$uri_segment=3,$per_page=20){ 
 		
 		 return \Vendor\Db::lists($current_url,$model,$view,$uri_segment,$per_page);
 	}
 	/**
	* 取得数据库config信息
	*/
	protected function _config($name){ 
	 	return \Vendor\Db::_config($name);
	}
	/**
	* sort 
	*/
	function _sort($id,$s='up',$model){
		 return \Vendor\Db::_sort($id,$s,$model);
	}

  
  
  
}
