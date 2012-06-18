<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Views extends \Orm\Model
{
	protected static $_table_name = 'views';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_belongs_to = array(
	   'type' => array(
	        'key_from' => 'type_id',
	        'model_to' => 'Model_Content_Type',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
	    'field' => array(
	        'key_from' => 'field_id',
	        'model_to' => 'Model_Content_Field',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
	);
	 
}