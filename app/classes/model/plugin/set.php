<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Plugin_Set extends \Orm\Model
{
	protected static $_table_name = 'plugin_setting';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
 	protected static $_belongs_to = array(
	    'plugin' => array(
	        'key_from' => 'plugin_id',
	        'model_to' => 'Model_Plugin',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
	    
	);
	 
}