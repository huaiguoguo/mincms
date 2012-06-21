<?php
class hook_auto_video{
	
	/*function before_save($obj){
		 
	}*/
	
	/**
	* 取视频中的一张图片
	*/
	function after_save($obj){
		$in = DOCROOT.'/'.$obj->path;
		$img = DOCROOT.'/'.$obj->path.'.jpg';
		if(!file_exists($in)) return true;
		$find = strrpos($in,'.');
   		$ext = substr($in,$find);
		$ext = str_replace('.','',$ext);
		
		$o = new \Vendor\Ffmpeg;
		/*if($ext=='flv'){
			$mp4 = substr($in,0,$find).'-'.date('Y-m-d-His').'.mp4';
			$o->video($in,$mp4); 
			echo $mp4;exit;
		}*/
		//1.flv
		if(!file_exists($img)){  
			$o->image($in,$img,$width=260,$height=200,$time="00:00:02"); 
	 	}
	}
	
}