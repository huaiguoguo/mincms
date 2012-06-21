<?php
namespace Content;
/**
*  
* for cck ,auto create update delete 
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Node extends \Controller_Base_Auth{
	public $min;
	public $max;
	public $file_path ='upload/files' ;
	public $plugins; //加载php插件
	function before(){
		parent::before();
		
		$this->menus = include __DIR__.'/../../menu.php';	  
		$this->menus['active_url'] = \Uri::create('content/home/index');
		error_reporting(0);
		/**
		* 加载插件中的PHP插件
		*/
		foreach (\Uri::segments() as $v){
			$link .= $v.'/';
		}
		$link = strtolower(substr($link,0,-1));		 
		$plugins = \Model_Plugin_Set::find('all',array('where'=>array('page'=>$link)));
		foreach($plugins as $plug){
			unset($op);
			if($plug->plugin->is_js==0){ 
				$php[$plug->html_element]['params'] = $plug->params;
				$php[$plug->html_element]['page'] = $plug->page;
				$op = unserialize($plug->plugin->options);
				$php[$plug->html_element]['code'] = $op['code'];
			}
		}
		$this->plugins = $php; 

	}
	function action_index($id){
		$this->menus['active'] = 1;  
	 	$model = \Model_Content_Type::find($id);
	 	$table =  $model->val; 
	 	$model_name =  \Vendor\Table::model_name($model->val);
	 	$model_name = '\\'.$model_name;  
	 	
		
	  
		$this->min = $model_name::min('sort');
		$this->max = $model_name::max('sort'); 
		
		$url = \Uri::create('content/node/index');
		$view = \View::forge('node/index');
		$view->set('hooks',$hooks,false);
		$view->set('id',$id,false);
		$view->set('model',$model,false);
		$view->set('min',$this->min,false);
		$view->set('max',$this->max,false); 
		$this->template->set('content',$view,false);	
	}
	
	
	
	function action_do($id,$fid=null){  
		$this->menus['active'] = 1; 
	 	$model = \Model_Content_Type::find($id, array(
			    'related' => array(
			        'fields' => array(
			            'order_by' => array('sort'=>'asc','id' => 'asc'), 
			        ),
			    ),
		));  
	 	$table =  $model->val;
	 	if(!$fid)
	 		$op = 'plus-sign'; 
	 	else
	 		$op = 'edit';
	 	
	 	$tname = $model_name =  \Vendor\Table::model_name($model->val);
	 	$model_name = '\\'.$model_name; 
	 	$tname = strtolower($tname);
	 	$tname = str_replace('model_','',$tname); 
	 	 
	 	if($fid){
	 	 
	 		
	 		$post = \DB::select('*')->from($tname)->where('id',$fid)->execute()->current(); 
	 	}
	 	
		if($model->fields){
	  		$len = 200;
	  		$t = 'varchar';
	  		foreach($model->fields as $v){
	  			unset($ops); 
	  			$label = $v->label;
	  			$name = $v->name?:null;
	  			if($v->form->use)
	  				$ht = $v->form->use;
	  			else
	  				$ht = $v->form->val;
	  			$ops = $v->options; 
	  			switch($ht){
	  				case 'orm': 
	  					
	  					if($ops){
	  						$opsm = strtolower($ops['rt']);
	  						$rtcolumn = strtolower($ops['column']);
	  						unset($rt_obj);
	  					 	$rt_obj = \DB::select('*')->from($opsm)->execute()->as_array();	  				 	  	
	  				 		foreach($rt_obj as $v){	  				 		
	  				 			$all_values[$v['id']] = $v[$rtcolumn];
	  				 		} 
	  					}
	  					$ht = 'select';
	  				
	  					break;
	  			}
	  			// change $v->id to $name
		  		$form[$name] = array('label'=>$label,
			  		'name'=>$name,
			  		'form'=>$ht, 
			  		'values'=>$all_values,
			  		'value'=>$post[$name],
			  		'rules'=>$v->rule->rules,
			  		'muit'=>$ops['muit'],
			  		'label_tip'=>trim($ops['label_tip']),
			  		'default_value'=>trim($ops['default_value']),
			  	);
		  		switch($v->form->val){
		  			case 'input':
		  				$t = 'varchar';
		  				break;
		  			case 'textarea':
		  				$t = 'text';
		  				break;	
		  		  
		  		}
		  		if($t == 'text') 
		  			$db[$v->name] = array('type' => $t);
		  		else
		  			$db[$v->name] = array('constraint' => $len, 'type' => $t);
		  	}
	  	}   
		$val = \Validation::forge();
	 	$http_files = $_FILES;
 
	 	foreach($form as $vo){ 
	 		$is_required = false;
	 		$rules = array();
	 		$rules = $vo['rules']; 
	 		$html_type = $vo['form'];
	 		if($html_type=='input') $html_type = 'text'; 
    		$form_build = $val->add_field($vo['name'],__('comm.'.$vo['label'].''), array('options'=>$vo['values'],'value'=>$vo['value'],'type'=>$html_type))	;
    		
    		$auto_form[] = $vo;
    		if($rules){
    			foreach($rules as $k=>$r){
    				switch($k){
    					case 'required': 
    						$form_build->add_rule($k);
    						$is_required = true;
    						break; 
    					default:
    						$form_build->add_rule($k,$r);
    						break;
    				} 
    			}
    		}	  
    	 
     	}
      
     	$hooks = "<p><a class='btn btn-primary' href='#'>
	  	<i class='icon-".$op." icon-white'></i>"
	     .__('comm.'.$model->name).$fid."
	</a>"."&nbsp;&nbsp;<a class='btn' href='".\Uri::create('content/node/index/'.$id)."'><i class='icon-list-alt'></i>".__('comm.lists')."</a></p>";
     	unset($_POST['submit']); 
     	$fields = \Input::all();
      
 		if($_POST&&$val->run())
		{   
		 
			if(!$fid)
				$post = new $model_name;
			else
				$post = $model_name::find($fid);
			foreach($form as $vo){ 
				if(trim($fields[$vo['name']]) && $vo['form'] != 'file'){
					$post->$vo['name']   = trim($fields[$vo['name']]); 
				} 
				if($vo['form'] == 'file'){ 
					$post->$vo['name']   =  \Format::forge($fields[$vo['name']])->to_json() ; 
				}
			} 
		 	$post->sort = 1;
		 	$post->active = 1;
		 	$post->create_at = time();
		 	$post->update_at = time(); 
			if($post->save()){  	 
				$post->sort = $post->id; 
				$post->save();
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('content/node/index/'.$id));
			} 
		}
		else
		{   
			a:
			 
			$this->template->set('messages', $val->show_errors().$error, false); 
		}   
		
	 
		$view = \View::forge('node/form');
		$view->set('cck_type',str_replace('auto_','',$tname));
		$view->set('form',$auto_form,false);
		$view->set('plugins',$this->plugins);
		$view->set('id',$id);
		$view->set('fid',$fid);
		$this->template->set('content', $view, false); 
		$this->template->set('hooks', $hooks, false);  
	}
	/**
	* @ download file
	*/
	function action_down($id,$title='download'){
		//$id is file_id;
		$post = \Model_File::find($id);
		\File::download(DOCROOT.'/'.$post->path, $title.'.'.$post->ext);
		exit;
	}
	/**
	* @ node remove file
	*/
	function action_remove_file(){
		extract($_POST);
		if(!$id || !$fid || !$type || !$file_id || ! $field ){ 
			exit;
		}
		$model = \Model_Content_Type::find($id, array(
			    'related' => array(
			        'fields' => array(
			            'order_by' => array('sort'=>'asc','id' => 'asc'), 
			        ),
			    ),
		));  
	 	$table =  $model->val;  
	 	$tname = $model_name =  \Vendor\Table::model_name($model->val);
	 	$model_name = '\\'.$model_name;
	 	$tname = strtolower($tname);
	 	$tname = str_replace('model_','',$tname);  	  
	 	$post = \DB::select('*')->from($tname)->where('id',$fid)->execute()->current(); 
	  
	 	$arr = \Format::forge($post[$field], 'json')->to_array() ;
	 	$k = array_search($file_id,$arr); 
	 	unset($arr[$k]);  
	 	$field_value = json_encode($arr); 
	 	 
	 	//update
	  	\DB::update($tname)->value($field, $field_value)->where('id','=',$fid)->execute(); 
 
	  	$find = \Model_Remove::find('first',array('where'=>array('type'=>$type,'val'=>$file_id)));
		if(!$find){
			$find = new \Model_Remove;
			$find->type = $type;
			$find->val = $file_id;
			$find->save(); 
		}
		//remove form $field;
		 
		exit;
	}
	/**
	* @ 删除内容
	*/
	function action_del($id,$fid){
		$type = \Model_Content_Type::find($id);
		$tname =  \Vendor\Table::model_name($type->val);
	 	$tname = strtolower($tname);
 		$tname = str_replace('model_','',$tname);  	 
 	    \DB::delete($tname)->where('id',$fid)->execute(); 
	 	 
	 	\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/node/index/'.$id.'/'.$fid));
	}
 	/**
 	* @排序
 	*/
	function action_sort($id,$fid,$s='up'){
		$type = \Model_Content_Type::find($id);
		$model_name =  \Vendor\Table::model_name($type->val);
	 	$model_name = '\\'.$model_name;  
		
		$this->_sort($fid,$s,$model_name );
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/node/index/'.$id.'/'.$fid));
	}
	/**
	* @显示内容或隐藏
	*/
	function action_active($id,$fid){
		$type = \Model_Content_Type::find($id);
		$model_name =  \Vendor\Table::model_name($type->val);
	 	$model_name = '\\'.$model_name; 
		$post = $model_name::find($fid); 
		if($post->active==1)
			$post->active = 0;
		else
			$post->active = 1;
		if($post->save())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('content/node/index/'.$id.'/'.$fid));
		}  
		 
		 
	}
}