<?php

 
class Controller_Base_Public extends \Controller_Hybrid
{
	/**
	* 面包削导航
	*/
	public $breadcrumb=array();
	//首页
	public $home_breadcrumb=array();
	//菜单
	public $menus = array();
	//CCK 生成html plugin调用
	public $html;
	public $plugin;
	//template page title 
	public $page_title = null;
	public $page_out = array();

 	public function before() {
 		parent::before(); 

		/*$this->pagecache = new \Xvp\Pagecache();
		$this->pagecache->setResponse($this->response);
		$this->pagecache->setRequest($this->request);*/

 		Config::set('language', 'zh');
 		Lang::load('comm', 'comm');
		date_default_timezone_set('Asia/Shanghai');  
		Autoloader::add_namespace('Vendor', APPPATH.'vendor/'); 
		$this->page_title = 'Application build on FuelPHP'.Fuel::VERSION; 
		
		
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
 	/**
 	* comm way for list pages
 	$url = \Uri::create('admin/language/index');
	$this->lists($url,'Model_Language','language/index',3,1);
	or safe can ignore
	$this->lists($url,'Model_Language',array('language/index',array('msg'=>$this->s),'safe'=>true),4);
	
 	*/ 	
 	public function lists($current_url,$model,$view=null,$uri_segment=3,$per_page=20){
 		return \Vendor\Db::lists($current_url,$model,$view,$uri_segment,$per_page);
 	}

  
  
 	public function after($response)
    {
        parent::after($response);   

		/*if ($this->pagecache->isCacheable()) {
		   $this->pagecache->cache($_SERVER['REQUEST_URI']);
		}*/
        if (empty($response))
		{
			$response = $this->template;
		} 
		// If the response isn't a Response object, embed in the available one for BC
		// @deprecated  can be removed when $this->response is removed
		if ( ! $response instanceof Response)
		{
			$this->response->body = $response;
			$response = $this->response;
		}
        // do stuff
        if($this->breadcrumb){
	        $this->breadcrumb = array_merge($this->home_breadcrumb,$this->breadcrumb);
			$this->template->set('breadcrumb',$this->breadcrumb);
		}
		$this->template->set('menus',$this->menus);
		$this->template->set('page_title',$this->page_title);
		$this->template->set('page_out',$this->page_out,false); 
		$this->template->set('plugin',$this->plugin,false); 
		$this->template->set('html',$this->html,false); 
 		
        return $response; // make sure after() returns the response object
    }
    
	
}
