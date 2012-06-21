<?php
/**
*
 
*/
class module_swfupload{
	static $val='swf';
	function install(){
		 return array( 
		 	 'discription'=>'swfupload上传文件', 
		 	 'web'=>'http://code.google.com/p/swfupload/',
		 	 'code'=>'var '.self::$val.'# = new SWFUpload({##});', 
		 	 'js'=>array('swfupload/swfupload.js'),
		 );
		 
		 
	}
	function default_option(){
 		return '
				// Backend Settings
				upload_url: "/content/upload/swfupload",
				post_params: {"PHPSESSID" : "'.session_id().'"},
				// File Upload Settings
				file_size_limit : "102400",	// 100MB
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : "10",
				file_queue_limit : "0",
				// Event Handler Settings (all my handlers are in the Handler.js file)
				file_dialog_start_handler : fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				// Button Settings
				button_image_url : "XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder1",
				button_width: 61,
				button_height: 22,				
				// Flash Settings
				flash_url : "/plugin/swfupload/swfupload/swfupload.swf",
				custom_settings : {
					progressTarget : "fsUploadProgress1",
					cancelButtonId : "btnCancel1"
				},				
				// Debug Settings
				debug: false
			' ;
		
	}
	function view(){
		return '
		<div class="fieldset flash" id="fsUploadProgress2">
			<span class="legend">Small File Upload Site</span>
		</div>
		<div style="padding-left: 5px;">
			<span id="fsUploadProgress1"></span>
			<input id="btnCancel1" type="button" value="Cancel Uploads" onclick="cancelQueue(upload1);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
			<br />
		</div>';
	}
 	
}
 
 