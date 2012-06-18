<?php namespace Vendor;
/**
* 视频转换
* @author: SUN 
* @email: 68103403@qq.com
*/
class Ffmpeg{
	public $bin = 'ffmpeg';
	
	function __construct($bin=null){ 
		$this->bin = $bin;
		return $this;
	}

	function image($in,$img,$width=400,$height=300,$time="00:00:08"){
		if(!file_exists($in)) return false;		
		$cmd = $this->bin." -i $in -ss ".$time."  -vframes 1 -r 1 -ac 1 -ab 2 -s ".$width."x".$height." -f image2 $img";
 		if(@exec($cmd))		 
			return true;
		return false;
	}
 	
	function video($in,$out){
		if(!file_exists($in)) return false; 
		$cmd = $this->bin." -i ".$in."   ".$out;
 		if(@exec($cmd))
			return true;
		return false;
	}
 
}