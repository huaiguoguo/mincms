<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Acl extends \Orm\Model
{
	protected static $_table_name = 'role_acl';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_belongs_to = array(
	    'action' => array(
	        'key_from' => 'action_id',
	        'model_to' => 'Model_Action',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	 
}