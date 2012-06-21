<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Plugin extends \Orm\Model
{
	protected static $_table_name = 'plugin';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
  
	protected static $_has_many = array(
	    'sets' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Plugin_Set',
	        'key_to' => 'plugin_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	 
}