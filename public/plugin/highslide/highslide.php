<?php

class plugin_highslide{
	
	function install(){
		 return array( 
		 	 'discription'=>'highslide 图片弹出', 
		 	 'web'=>'http://highslide.com/',
		 	 'code'=>'$(#).facybox({##});',
		 	 'css'=>array('facybox/facybox.css'),
		 	 'js'=>array('facybox/facybox.js'),
		 );
		 
		 
	}
 
}
 
 