<?php

class plugin_tags_input{
	function install(){
		return array( 
		 	 'discription'=>'jquery tag input效果', 
		 	 'web'=>'https://github.com/xoxco/jQuery-Tags-Input',
		 	 'code'=>'$(#).tagsInput({##});',
		 	 'css'=>array('tags_input/jquery.tagsinput.css'),
		 	 'js'=>array('tags_input/jquery.tagsinput.min.js'),
		 );
		 
		 
		 
	}
	 
}
 