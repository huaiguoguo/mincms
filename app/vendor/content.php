<?php
namespace Vendor;
/**
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Content{
	
	static function decode($arr){
		return; \Format::forge($arr, 'json')->to_array() ;
	}
	static function icon($type='txt',$params=null){   
		switch($type){
			case '':
				$img = 'zip.png';
				break;
			case 'txt':
				$img = 'txt.png';
				break;
			case 'doc':
				$img = 'word.png';
				break;
			case 'pdf':
				$img = 'pdf.png';
				break;
			case 'wps':
				$img = 'word.png';
				break;
			default:
				$img = 'file.png';
				break;
		}
		if(in_array($type,array(
			'flv','mp4','webm','avi','rmvb'
			))){
			$img = 'video.png';	
		}
		if(!$type){
			$img = 'none.png';
			$params = array('title'=>__('comm.file not exists'));
		}
		
		
		return \Asset::img($img,$params);
			 
	}
	/**
	* load data
	*/
	static function node($table,$params=null,$cck=true){
		$post = self::_node_load($table,$params,$cck);
		return $post->get();
	}
	
	static function node_one($table,$params=null,$cck=true){
		$post = self::_node_load($table,$params,$cck);
		if(!is_array($params)){ 
			return $post;
		}
		return $post->get_one();
	}
	
	static function node_page($table,$params,$current_url,$uri_segment=3,$per_page=10,$paginate_class='apple_pagination'){
		$config = array(
		    'pagination_url' => $current_url,
		    'total_items' => $model::count(), 
		    'uri_segment' => $uri_segment,
		    'per_page'=>$per_page
		); 		
		\Vendor\Db::config_paginate($config,$paginate_class);  
		$pagination = \Pagination::create_links(); 
		$params['limit'] = \Pagination::$per_page;
		$params['offset'] = \Pagination::$offset;
		$post = self::_node_load($table,$params);
	 	$post = $post->get();
		return array($post,$pagination);
	}
	
	/**
	* 
	*/
	static function _node_load($table,$params=null,$cck=true){
		if(true === $cck)
			$model = '\\Model_Auto_'.ucfirst($table);
	 	else
	 		$model = '\\Model_'.ucfirst($table);
	 
		if(!is_array($params)){ 
			 return $model::find($params);
		}
		$post = $model::find();
		if(is_array($params['order_by'])){
			foreach($params['order_by'] as $k=>$v){
				$post = $post->order_by($k,$v);
			}
		}
		if($params['r']){		
			$post = $post->related($params['r'][0],$params['r'][1]);
		}
		if($params['count'])
			$post = $post->offset($params['count']);
		if($params['max'])
			$post = $post->offset($params['max']);
		if($params['min'])
			$post = $post->offset($params['min']);
		if($params['limit'])
			$post = $post->limit((int)$params['limit']);
		if($params['offset'])
			$post = $post->offset((int)$params['offset']);
		
		return $post;
	}
	 
}