<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Users extends \Orm\Model
{
	protected static $_table_name = 'users';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_belongs_to = array(
	    'groups' => array(
	        'key_from' => 'group',
	        'model_to' => 'Model_Group',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	 
}