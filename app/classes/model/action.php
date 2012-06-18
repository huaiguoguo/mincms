<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Action extends \Orm\Model
{
	protected static $_table_name = 'role_action';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_belongs_to = array(
	    'controller' => array(
	        'key_from' => 'controller_id',
	        'model_to' => 'Model_Controller',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ), 
	);
	protected static $_has_many = array(
	    'acls' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Acl',
	        'key_to' => 'action_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	 
}