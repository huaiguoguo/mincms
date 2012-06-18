<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Group extends \Orm\Model
{
	protected static $_table_name = 'groups';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_has_many = array(
	    'acls' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Acl',
	        'key_to' => 'group_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	
	 
}