<?php
/**
*
 
*/
class plugin_swfupload{
	static $val='swf';
	static $limit = 1;
	static $size = 200;//m
	static $type = '*.*';
	function install(){
		 return array( 
		 	 'type'=>'content',
		 	 'discription'=>'swfupload上传文件', 
		 	 'web'=>'http://code.google.com/p/swfupload/',  
		 );  
	}
	
	
	function js(){
		return array(
			'plugin/swfupload/swfupload/swfupload.js',
			'plugin/swfupload/swfupload/swfupload.queue.js',
			'plugin/swfupload/swfupload/fileprogress.js',
			'plugin/swfupload/swfupload/handlers.js',
		);
	}
	
	function run($option=null){  
		$up = 'swfupload_'.self::$val; 
		 
	 	$s = 'uploadSuccess_'.self::$val;
		return "<script>$(function(){ var ".$up."	= new SWFUpload({".$option."}) ;});
		function ".$s."(file, serverData) {
 			$('.swf_show_".self::$val."').append(serverData);
 			$('#swf_".self::$val."').html(null);
		}
		</script>";
	}
	function default_option(){
		session_start();
		$user = \Auth::instance()->get_user_id(); 
   	 
 		return '
				// Backend Settings
				upload_url: "/content/upload/swfupload",
				post_params: {"PHPSESSID" : "'.session_id().'","input":"'.self::$val.'","uid":"'.$user[1].'"},
				// File Upload Settings
				file_size_limit : "'.self::$size.'",	// 100MB
				file_types : "'.self::$type.'",
				file_types_description : "All Files",
				file_upload_limit : "'.self::$limit.'",
				file_queue_limit : "0",
				// Event Handler Settings (all my handlers are in the Handler.js file)
				file_dialog_start_handler : fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess_'.self::$val.',
				upload_complete_handler : uploadComplete,
				// Button Settings
				button_image_url : "/plugin/swfupload/swfupload/XPButtonUploadText_61x22.png",
				button_placeholder_id : "swf'.self::$val.'",
				button_width: 61,
				button_height: 22,		
				button_window_mode:"Opaque",		
				// Flash Settings
				flash_url : "/plugin/swfupload/swfupload/swfupload.swf",
				custom_settings : {
					progressTarget : "swf_'.self::$val.'",
					cancelButtonId : "swf_btn_'.self::$val.'"
				},				
				// Debug Settings
				debug: false
			' ;
		
	}
	function view($params){
		self::$val = $params['field'];
		self::$limit = $params['limit']?:1;
		if(self::$limit=='unlimted')
			self::$limit = 0;
		self::$size = $params['size']*1024?:10*1024;
		self::$type = $params['type']?:'*.*';
		$up = 'swfupload_'.self::$val;
		return ' 
		<div style="padding-left: 5px;float:left;">
			<span id="swf'.self::$val.'"></span>
			<input id="swf_btn_'.self::$val.'" type="button" value="'.__('comm.cancel uploads').'" onclick="cancelQueue('.$up.');" disabled="disabled"
			 style="margin-left: 2px; height: 22px; font-size: 8pt;margin-top: -7px;line-height: 15px;" />
			<br />
		</div>
		<div class="fieldset flash" id="swf_'.self::$val.'" style="float:left;">
		 
		</div>
		<div class="swf_show_'.self::$val.'" style="clear:both;"></div>
		';
	}
 	
}
 
 