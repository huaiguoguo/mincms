<?php
namespace Vendor;
/**
* file
* @author: Suen 
* @email: 68103403@qq.com
*/
class File{

	static function size($filesize) {
	 if($filesize >= 1073741824) {
	  	$filesize = round($filesize / 1073741824 * 100) / 100 . ' gb';
	 } elseif($filesize >= 1048576) {
	  	$filesize = round($filesize / 1048576 * 100) / 100 . ' mb';
	 } elseif($filesize >= 1024) {
	 	 $filesize = round($filesize / 1024 * 100) / 100 . ' kb';
	 } else {
	 	 $filesize = $filesize . ' bytes';
	 }
	 return $filesize;
	}
}