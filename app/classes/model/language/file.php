<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Language_File extends \Orm\Model
{
	protected static $_table_name = 'language_file';
	protected static $_primary_key = array('id');
	protected static $_properties = array();
	
	protected static $_belongs_to = array(
		'language' => array(
			'key_from' => 'language_id',
			'model_to' => 'Model_Language',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		)
	);
	
}