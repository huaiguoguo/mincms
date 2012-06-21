<?php

class plugin_facybox{
	
	function install(){
		 return array( 
		 	 'discription'=>'facybox弹出层效果', 
		 	 'code'=>'$("#").facybox({##});',
		 	 'css'=>array('facybox/facybox.css'),
		 	 'js'=>array('facybox/facybox.js'),
		 );
		 
		 
	}
 
}
 
 