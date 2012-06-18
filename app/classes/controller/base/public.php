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
		try
		{
			$data = Cache::get('admin_config');
		}
		catch (\CacheNotFoundException $e)
		{ 
			$models = \Model_Config::find('all');
			foreach($models as $model){ 
				if(false!==strpos($model->name,'password')){ 
					 $model->val = \Crypt::decode($model->val, 'jE@I');
				}
				$data[$model->name] = $model->val; 
			} 
			Cache::set('admin_config', $data);
		} 
		 
		
		return $data[$name];
	}
	/**
	* sort 
	*/
	function _sort($id,$s='up',$model){
		if($s=='up'){
			$j = '>';
			$sort = 'asc';
		}
		else if($s=='down'){
			$j = '<';
			$sort = 'desc';
		}
		$post = $model::find($id);
		$a = $post->sort;
		$p = $model::find('first',array(
			'where'=>array(array('sort',$j,$a)),
			'order_by'=>array('sort'=>$sort)
		));
		$fid = $p->id;
		$b =  $p->sort;
		$post->sort = $b;
		$post->save();
		$p->sort = $a;
		$p->save(); 
	}
 	/**
 	* comm way for list pages
 	$url = \Uri::create('admin/language/index');
	$this->lists($url,'Model_Language','language/index',3,1);
	or safe can ignore
	$this->lists($url,'Model_Language',array('language/index',array('msg'=>$this->s),'safe'=>true),4);
	
 	*/ 	
 	public function lists($current_url,$model,$view,$uri_segment=3,$per_page=null){
 		if(!$per_page) $per_page = (int)$this->_config('admin_pagination')?:10;
 		if(is_array($view)){
 			$data = $view[1];
 			$safe = $view['safe'];
 			$view = $view[0]; 
 		}
 		if(is_array($model)){
 			$params_model = $model[1]; 
 			$model = $model[0]; 
 		}
		$config = array(
		    'pagination_url' => $current_url,
		    'total_items' => $model::count(), 
		    'uri_segment' => $uri_segment,
		    'per_page'=>$per_page
		); 		
		$this->config_paginate($config,'apple_pagination'); 	 
		$params = array(
			'limit'=>\Pagination::$per_page,
			'offset'=>\Pagination::$offset
		);
		if($params_model)
			$params = array_merge($params_model,$params);
		$posts = $model::find('all',$params); 
		$pagination = \Pagination::create_links(); 
		if($safe!==true && $data){
 			$view  = \View::forge($view); 
 			foreach($data as $k=>$v){
 				$view->set($k,$v,false);
 			}
 		}
		else
			$view  = \View::forge($view,$data); 
		$view->set('posts', $posts, false);
		$view->set('pagination', $pagination, false);
		$this->template->content = $view;   
 	}

  
 	/**
 	* setting paginate
 	*/
 	public function config_paginate($configs=array(),$class='digg_pagination'){ 
 		$config = array(
		    'pagination_url' => "#",
		    'total_items' =>0,
		    'per_page' => 1,
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
