<?php
namespace Content;
class Controller_Home extends \Controller_Base_Auth{
	function before(){
		parent::before();
		if(\Request::main() === \Request::active()){
			$this->menus = include __DIR__.'/../../menu.php';	  
			$this->menus['active_url'] = \Uri::create('content/home/index');
		}else{
			//$this->menus['active_url'] = \Uri::create('admin/home/index');
		}
	}
	function action_index(){
	   	$this->min = \Model_Content_Type::min('sort');
		$this->max = \Model_Content_Type::max('sort'); 
		$url = \Uri::create('content/type/index');
		$this->template->content = $this->lists($url,array('Model_Content_Type',array('order_by'=>array('sort'=>'asc',	'id'=>'asc'))),array('home/index',array('min'=>$this->min,'max'=>$this->max)),4);
	   
	}
}