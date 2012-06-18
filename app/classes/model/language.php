<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Language extends \Orm\Model
{
	protected static $_table_name = 'language';
	protected static $_primary_key = array('id');
	protected static $_properties = array();
 
	protected static $_has_many = array(
		'file' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Language_File',
			'key_to' => 'language_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		)
	);
	
}