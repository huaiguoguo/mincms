<?php
namespace Content;
class Controller_Upload extends \Controller{
	
 	/**
 	* @for plugin uploadify to upload files
 	*/ 
	function action_swfupload(){ 
		session_start();
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		}
		$input = $_POST['input'].'[]';
   		if (isset($_FILES["Filedata"])) {
   			$name = $_FILES["Filedata"]["name"];
   			$find = strrpos($name,'.');
   			$ext = substr($name,$find);
   		 
   			$name = \Str::random('alnum', 16).$ext; 
   			$dir = 'upload/files/'.date('Y');
   		 
   			if(!is_dir(DOCROOT.$dir)) self::mkdir(DOCROOT.$dir);
   		 
   			$name = $dir.'/'.date('md').'_'.$name;
   		 	
		 	move_uploaded_file ($_FILES["Filedata"]["tmp_name"],DOCROOT.$name);
		 
		 	$model_file = new \Model_File;    
			$model_file->name  = $name;
			$model_file->type  = $ext;
			$model_file->ext  = str_replace('.','',$ext);
			$model_file->path  = $name;
			$model_file->create_at  = time();
			
			$model_file->uid  =  $_POST['uid'];
			$model_file->size  = ceil(filesize(DOCROOT.$name)/1000);         ;
			$model_file->save();
		 
		 
		 	if(in_array($ext,array('.jpg','.jpeg','.png','.gif')))
				$s ="<a href='".\Uri::base(false).$name."'><img src='".\Uri::base(false).$name."' width=200 height=180 style='margin-right:5px;' rel='facybox'/></a>"; 
			else{
				$s = $name.'<b>';
			}
		 	$s .= "<input type='hidden' value=".$model_file->id." name=".$input.">";
		 	echo $s;
			exit(0);
		}
 		exit;
	}
	
	function mkdir($dir, $mode = 0755)
	{
		if (is_dir($dir) || @mkdir($dir,$mode)) return true;
		if (!self::mkdir(dirname($dir),$mode)) return false;
		return @mkdir($dir,$mode);
	}
	 
	  
}