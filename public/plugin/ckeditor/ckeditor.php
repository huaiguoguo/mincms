<?php

class plugin_ckeditor{
	function install(){
		return array( 
		 	 'discription'=>'文本编辑器CKeditor',
		 	 'auth'=>'sun kang',
		 	 'web'=>'http://mincms.com', 
		 	 'code'=>"if($('input[name=#]').length > 0 || $('textarea[name=#]').length > 0){  CKEDITOR.replace('#',{##});}", 
		 	 'js'=>array('ckeditor/ckeditor.js'),
		 ); 
		 
	}
	
 
	 
}
 