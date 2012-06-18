<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */
$groups = array();
$roles = array();


try
{
	$data = Cache::get('admin_groups_roles');
}
catch (\CacheNotFoundException $e)
{ 
	$g = \Model_Group::find('all');
	foreach($g as $v){
		$groups[$v->id]['name'] =$v->val;
		foreach($v->acls as $ac){
			$c = \Vendor\Str::replace($ac->action->controller->val);
			$groups[$v->id]['roles'][$ac->action->controller_id] = $c.$v->id; 
			$action = $ac->action->val;
			$action = str_replace('action_','',$action);
			$roles[$c.$v->id][$c][] = trim($action);
		}
	} 
	$data[0] = $groups;
	$data[1] = $roles;
	Cache::set('admin_groups_roles', $data);
} 
$groups = $data[0];
$roles = $data[1];
 
return array(

	/**
	 * DB connection, leave null to use default
	 */
	'db_connection' => null,

	/**
	 * DB table name for the user table
	 */
	'table_name' => 'users',

	/**
	 * Choose which columns are selected, must include: username, password, email, last_login,
	 * login_hash, group & profile_fields
	 */
	'table_columns' => array('*'),

	/**
	 * This will allow you to use the group & acl driver for non-logged in users
	 */
	'guest_login' => false,

 
	'groups' => $groups,
 
	'roles' => $roles, 

	/**
	 * Salt for the login hash
	 */
	'login_hash_salt' => 'asfdIO&(*sdf',

	/**
	 * $_POST key for login username
	 */
	'username_post_key' => 'email',

	/**
	 * $_POST key for login password
	 */
	'password_post_key' => 'password',
);
