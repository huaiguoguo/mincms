<?php
namespace Widget;
class Controller_Url extends \Controller_Base_Public{
	/** 返回当前的url,真实的 module/controller/action
	echo Request::forge('widget/url/index')->execute();
	*/
	function action_index(){ 	 
		$controller = \Request::active()->controller; 
		$controller = str_replace('controller_','',strtolower($controller));
		$action = '\\'.strtolower(\Request::active()->action);
		$link = $controller.$action;
		$link = str_replace('\\','/',$link);   
		return $link;
	}
}