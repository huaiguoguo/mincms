<?php
namespace Views;
 
/** 
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Home extends \Controller_Base_Comm{
  
	public $min;
	public $max;
	public $type_id;
	public $type = 'admin';
	function before(){
		parent::before(); 
		
 	}
 	/**
 	* @分页显示内容，字段由设置决定
 	*/
 	function action_index($id){ 
 	
 		$this->type_id = $id;
 		$model = \Model_Content_Type::find($id);
	 	$table =  $model->val; 
	 	$model_name =  \Vendor\Table::model_name($model->val);
	 	$model_name = '\\'.$model_name;
	 	$table_name = strtolower($model_name);  
	 	$table_name = str_replace('\\model_','',$table_name);	 
 	 	$views = \Model_Views::find('all',array('where'=>array('type_id'=>$id,'type'=>$this->type)));
	 	$this->min = $model_name::min('sort');
		$this->max = $model_name::max('sort'); 
		
		//test
	 	$url = \Uri::create('views/home/index/'.$id.'/');
		//
		return  $this->lists($url,array($model_name,array('order_by'=>array('sort'=>'desc','id'=>'desc'))),array('home/index',array('hooks'=>$hooks,'views'=>$views,'id'=>$id,'min'=>$this->min,'max'=>$this->max)),5,(int)$this->_config('admin_pagination')?:10);
	 
		 
 	
 	}
 	/**
 	* @设置需要显示的字段，后台列表
 	*/
 	function action_column($id){
 		$this->type_id = $id;
 		$model = \Model_Content_Type::find($id);
	 	$table =  $model->val; 
	 	$model_name =  \Vendor\Table::model_name($model->val);
	 	$model_name = '\\'.$model_name;
	 	$table_name = strtolower($model_name);  
	 	$table_name = str_replace('\\model_','',$table_name);	   
 	 	 
		$rows = \Model_Content_Field::find('all',array('where'=>array('type_id'=>$id),'order_by'=>array('sort'=>'asc','id'=>'asc'))); 
		$views = \Model_Views::find('all',array('order_by'=>array('sort'=>'desc'),'where'=>array('type_id'=>$id,'type'=>$this->type)));
		$min = \Model_Views::find('first',array('order_by'=>array('sort'=>'asc'),'where'=>array('type_id'=>$id,'type'=>$this->type)));
		$max = \Model_Views::find('first',array('order_by'=>array('sort'=>'desc'),'where'=>array('type_id'=>$id,'type'=>$this->type)));
		foreach($views as $v){
			$ids[] = $v->field_id;
		}
		$this->min = $min->sort;
		$this->max = $max->sort;
	 
		$view = \View::forge('home/set');
		$view->set('rows',$rows);
		$view->set('id',$id);
		$view->set('ids',$ids);
		$view->set('model',$model);
		$view->set('url',\Uri::create('views/home/index/'.$id));
		$view->set('min',$this->min);
		$view->set('max',$this->max);
 		return  \Response::forge($view);
 	}
 	/*
 	* @开启显示或隐藏字段
 	*/
 	function action_ajax(){
 		 
 		$field_id = $_POST['fid'];
 		$id = $_POST['id'];
 		if(!$id || !$field_id) return false;
 		$model = \Model_Views::find('first',array('where'=>array('type_id'=>$id,'field_id'=>$field_id,'type'=>$this->type)));
 		if($model){
 			$model->delete();
 			echo 2;
 			exit;
 		}
 		$model = new \Model_Views; 
 		$model->type_id = $id;
 		$model->field_id = $field_id;
 		$model->type = $this->type;
 		$model->save();
 		echo 1; 
 		exit;
 	}
	 
}