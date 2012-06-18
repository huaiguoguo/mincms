<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Controller extends \Orm\Model
{
	protected static $_table_name = 'role_controller';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	
	protected static $_has_many = array(
	    'actions' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Action',
	        'key_to' => 'controller_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	
	 
}