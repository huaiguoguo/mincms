<?php
namespace Content;
class Controller_Form extends \Controller_Base_Auth{
	public $min;
	public $max;
	function before(){
		parent::before();
		$this->cck_access();  
		$this->admin_access();
		$this->menus = include __DIR__.'/../../menu.php';	  
		$this->menus['active_url'] = \Uri::create('content/home/index');
	}
	function action_index(){
	 	$this->min = \Model_Content_Form::min('sort');
		$this->max = \Model_Content_Form::max('sort'); 
		$url = \Uri::create('content/form/index');
		$this->template->content = $this->lists($url,array('Model_Content_Form',array('order_by'=>array('sort'=>'desc','id'=>'desc'))),array('form/index',array('min'=>$this->min,'max'=>$this->max)),4);
		
	}
	 
	function action_sort($id,$s='up'){
		$this->_sort($id,$s,'\Model_Content_Form');
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/form/index')); 
	}
}