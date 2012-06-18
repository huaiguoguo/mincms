<?php

class plugin_ckeditor{
	function install(){
		return array( 
		 	 'discription'=>'文本编辑器CKeditor',
		 	 'auth'=>'sun kang',
		 	 'web'=>'http://mincms.com',
		 	 'code'=>'CKEDITOR.replace(#,{##});',
		 	 //'css'=>array('facybox/facybox.css'),
		 	 'js'=>array('ckeditor/ckeditor.js'),
		 );
		 
		 
		 
	}
	 
}
 