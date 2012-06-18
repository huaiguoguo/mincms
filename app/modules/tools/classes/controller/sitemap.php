<?php
namespace Tools;

function sitemap_install(){
	return array(
		'label'=>'sitemap',	
		'url'=>'index',
		'author'=>'sun kang',
		'im'=>'68103403@qq.com',
	); 
}
/**
* site map for this application 
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Sitemap extends \Controller_Base_Auth{  
	
	function before(){
		parent::before();
		$this->menus = \Vendor\Tools::init(); 
		$this->menus['active_url'] = \Uri::create('admin/tools/index'); 
 	}
 
	function action_index(){ 
		return false;
		$view = \View::forge('database/backup');
		$view->set('posts',$data); 
		$view->set('path',$this->path); 
		$this->template->content = $view;
	}
	
	function action_do(){
		$s = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		$s .= '	<url>';
		$s .= '		<loc>http://wjqtaichi.com</loc>';
		$s .= '		<lastmod>2012-05-27</lastmod>';
		$s .= '		<changefreq>daily</changefreq>';
		$s .= '		<priority>0.6</priority>';
		$s .= '	</url>';
		$s = '</urlset>';
	}
}