<?php

class plugin_facybox{
	
	function install(){
		 return array( 
		 	 'discription'=>'facybox弹出层效果',
		 	 'auth'=>'sun kang',
		 	 'web'=>'http://mincms.com',
		 	 'code'=>'$(#).facybox({##});',
		 	 'css'=>array('facybox/facybox.css'),
		 	 'js'=>array('facybox/facybox.js'),
		 );
		 
		 
	}
 
}
 
 