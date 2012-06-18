<?php
namespace Vendor;
/**
* menus for FuelPHP 1.2 under the MIT license
* just support link create by \Uri::create
* echo \Vendor\Menu::init($menus);
*
in controller:
$this->menus = array(
	array('label'=>'User List','url'=>\Uri::create('admin/user/index')),
	array('label'=>'User Add','url'=>\Uri::create('admin/user/add')), 
);
you need a comm controller like Controller_Base_Pubic,some code here:
public $menus = array();
in function after() or your current controller.

$this->template->set('menus',$this->menus);

active first menus
$this->menus['active'] = 1;


$this->menus['active_url'] = \Uri::create('admin/language/index');
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
* @date: 2012-5-24
*/
class Menu{
	 
	static function init($menus,$class='nav nav-pills',$act=false){  
			if(!is_array($menus)) return;
			$controller = \Request::active()->controller; 
			$controller = str_replace('controller_','',strtolower($controller));
			$action = '\\'.strtolower(\Request::active()->action);
			$link = $controller.$action;
			$link = str_replace('\\','/',$link);  
			$link = \Uri::create($link);	 
	        $str = "<ul class='$class'>";
			$i = 1;
			if($menus['active']) $j = (int)$menus['active'];
			if($menus['active_url'] && true==$act) $act_url = $menus['active_url'];
			unset($menus['active'],$menus['active_url']); 
	        foreach($menus as $key=>$menu){
				if($key == 'html' && !is_array($menu)){
					$str .= $menu;  continue;
				} 
	        	unset($cls);
				if(array_key_exists('display',$menu) && $menu['display']!=1)  continue;
	        	if($link==$menu['url'])
	        		$cls = "class='active'";
				if($j == $i)
					$cls = "class='active'";
				if($act_url == $menu['url'])
					$cls = "class='active'";
				if($menu['options']){
					$op = \Vendor\Arr::to_string($menu['options']);
				}
	        	$str .="<li $cls>";
	           	$str .="<a href='".$menu['url']."' $op >".$menu['label']."</a>";
	           	$str .="</li>";
				$i++;
	         }
	         $str .= "</ul>";
	         return $str; 
	}

}