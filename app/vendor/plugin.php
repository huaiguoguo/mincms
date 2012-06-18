<?php
namespace Vendor;
/**
* 加载系统全局插件
* @auth: sun
* @mail: 68103403@qq.com
*/
class Plugin{
	 
	static function init(){  
	 
		$controller = \Request::active()->controller; 
		$controller = str_replace('controller_','',strtolower($controller));
		$action = '\\'.strtolower(\Request::active()->action);
		$link = $controller.$action;
		$link = str_replace('\\','/',$link);  
		foreach (\Uri::segments() as $v){
			$new_link .= $v.'/';
		}
		$new_link = strtolower(substr($new_link,0,-1));
	 	$link = $new_link;
		$c = str_replace('/','_',$link);
		$cache_id = 'admin_plugins_'.$c; 
		try
		{			
			$out = \Cache::get($cache_id);
		}
		catch (\CacheNotFoundException $e)
		{ 
			$ps = \Model_Plugin_Set::find('all');
			unset($in);
			foreach($ps as $p){
				if(strpos($link,$p->page)!==false){
					$in[] = $p->id; 
				}
				if(trim($p->page)=='*'){
					$in[] = $p->id; 
				}
			}
			if($in){
				$posts = \Model_Plugin_Set::find('all',array('where'=>array(array('id','in',$in))));
			}else{
				$posts = \Model_Plugin_Set::find('all',array('where'=>array('page'=>$link)));
			}
			foreach($posts as $p){
				if($p->plugin->active!=1) continue;
				$h = unserialize($p->plugin->options);
				if($h['code'] && $p->plugin->is_js==1){ 
					$codes = $h['code'];
					if($p->params && strpos($codes,'##') !== false){  
						$codes = str_replace('##',$p->params,$codes);
					}
					else{
						$codes = str_replace('##',null,$codes);
					}
 
					$codes = str_replace('#',"'".$p->html_element."'",$codes); 
				 	$js_code[] =  $codes;
				}
			 	$css_js[$p->plugin->id] = $h; 
			}
			if(!$css_js) goto c;
		 	foreach($css_js as $v){
		 		if(!$v) goto c;
		 		if($v['css']){
			 		foreach($v['css'] as $css){ 
			 		 
			 			$out .='<link type="text/css" rel="stylesheet" href="'.\Uri::base(false).$css.'" />'; 
			 		}
		 		}
		 		if($v['js']){
			 		foreach($v['js'] as $js){
			 			$out .='<script type="text/javascript" src="'.\Uri::base(false).$js.'"></script>'; 
			 		}
		 		} 
		 	 
		 	}
		 	c:
		 	if($p->plugin->is_js!=1)  return $out;
			if($js_code){
				$out .= "<script>jQuery(document).ready(function($) {";
				
				foreach($js_code as $v){
					$out.=$v;
				}
				$out .="});</script>";
				 
			}
		/*	$cache = \Model_Cache::find('first',array('where'=>array('cache_id'=>$cache_id)));
			if(!$cache)
				$cache = new \Model_Cache;
			$cache->cache_id = $cache_id;
			$cache->save();
			\Cache::set($cache_id, $out);*/
			
		} 

		return $out;
		
		
		
	}

}