<?php 
namespace Admin;
class Controller_Logout extends \Controller_Base_Admin
{ 
	/**
	* @用户退出
	*/
	function action_index(){
		\Auth::instance()->logout();
		\Response::redirect(\Uri::create('home/index'));
	}
}