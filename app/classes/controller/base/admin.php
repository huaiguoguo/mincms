<?php

 
class Controller_Base_Admin extends \Controller_Base_Public
{
  	public $template = 'admin';
 	public function before() {
 		parent::before(); 
 		Config::set('language', 'zh');
 		Lang::load('comm', 'comm');
 		//后台面包削 首页设置
 	 	$this->home_breadcrumb = array(
 	 		array('label'=>__('comm.home'),'url'=>\Uri::create('admin/home/index'))
 	 	);	
 	 	
 	 	$this->page_title = __('comm.application admin');
    	$this->page_out = array( 
			'admin_title'=>$this->_config('admin_title'), 
			'seo_author'=>$this->_config('seo_author'),
			'seo_copyright'=>$this->_config('seo_copyright'),
		);
		if($this->_config('admin_url_suffix')){
			Config::set('url_suffix',$this->_config('admin_url_suffix'));
		}
		if($this->_config('admin_profiling')==1){ 
			Config::set('profiling',true);
		}
 	}
 	
  
}
