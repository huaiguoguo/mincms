<?php
namespace Vendor;
/**
* Generate menus from database 'tools'
* \Vendor\Tools::init();
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Tools{
	static function init(){
		$tools = \Model_Tool::find('all',array(
			'order_by'=>array('sort'=>'desc','id'=>'desc'),
			'where'=>array('active'=>1)
		));
		$menus[] = array('label'=>__('comm.tools'),'url'=>\Uri::create('admin/tools/index'));
		foreach($tools as $t){
			$menus[] = array('label'=>__('comm.'.$t->label),'url'=>\Uri::create($t->url));
		}
		return $menus;
	}
	
}