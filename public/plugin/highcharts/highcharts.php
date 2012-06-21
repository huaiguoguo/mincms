<?php

class plugin_highcharts{
	
	function install(){
		 return array( 
		 	 'discription'=>'highcharts 图表', 
		 	 'web'=>'http://www.highcharts.com',
		 	 'code'=>'$("#").facybox({##});',
		 	 'css'=>array('facybox/facybox.css'),
		 	 'js'=>array('facybox/facybox.js'),
		 );
		 
		 
	}
 
}
 
 