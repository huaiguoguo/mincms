<?php

class plugin_chosen{
	function install(){
		return array( 
		 	 'discription'=>'select选择框效果', 
		 	 'web'=>'https://github.com/harvesthq/chosen',
		 	 'code'=>'$("#").chosen({##});',
		 	 'css'=>array('chosen/chosen.css'),
		 	 'js'=>array('chosen/chosen.jquery.min.js'),
		 );
		 
		 
		 
	}
	 
}
 