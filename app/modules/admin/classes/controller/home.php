<?php

namespace Admin;

class Controller_Home extends \Controller_Base_Auth
{
	  
	function action_index(){ 
		 $view = \View::forge('home/index');
		 $this->template->content = $view;
	}
     
}