<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Content_Type extends \Orm\Model
{
	protected static $_table_name = 'content_type';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_has_many = array(
	    'fields' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Content_Field',
	        'key_to' => 'type_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	); 
	 
}