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
	 	$hooks = "<p><a class='btn btn-primary' href='".\Uri::create('content/node/do/'.$id)."'>
	  	<i class='icon-plus-sign icon-white'></i>"
	     .__('comm.'.$model->name)."
		</a>"."</p>";
		
	  
		$this->min = $model_name::min('sort');
		$this->max = $model_name::max('sort'); 
		$hooks .=  \Request::forge('views/home/column/'.$id,false)->execute();
		$hooks .= \Request::forge('views/home/index/'.$id,false)->execute();
		$url = \Uri::create('content/node/index');
		$view = \View::forge('node/index');
		$view->set('hooks',$hooks,false);
		$view->set('id',$id,false);
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
	 	
	 	if($fid){
	 	 
	 		$tname = strtolower($tname);
	 		$tname = str_replace('model_','',$tname); 
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
	  			switch($ht){
	  				case 'orm': 
	  					$ops = $v->options;
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
	  			
		  		$form[$v->id] = array('label'=>$label,
			  		'name'=>$name,
			  		'form'=>$ht, 
			  		'values'=>$all_values,
			  		'value'=>$post[$name],
			  		'rules'=>$v->rule->rules);
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
    						if($html_type!='file')
    						$form_build->add_rule($k);
    						$is_required = true;
    						break; 
    					default:
    						$form_build->add_rule($k,$r);
    						break;
    				} 
    			}
    		}	 
    		if($html_type == 'file'){
    			if($rules['ext_whitelist'])
	 				$ext_whitelist = explode(',',$rules['ext_whitelist']);
	 			$config = array(
				    'path' => DOCROOT.DS.$this->file_path,
				    'randomize' => true, 
				); 
	 			 
	 			if($ext_whitelist){
	 				$config['ext_whitelist'] = $ext_whitelist;
	 			}   
	 			if($_FILES){
		 		 	$_FILES = array($vo['name']=>$http_files[$vo['name']]);  
				    \Upload::process($config);  
					if (\Upload::is_valid())
					{   
							\Upload::save();
							//更新数据时，删除原文件
							$fp = $vo['name'];
							$ex_file = \DB::select('*')->from('files')->where('id',$post[$fp])->execute()->current(); 
							@unlink(DOCROOT.DS.$ex_file['path']);
							\DB::delete('files')->where('id',$post[$fp])->execute(); 
							
							//
						    $model_file = new \Model_File;    
							$get_files = \Upload::get_files();  
							$list = $get_files[0];
							if($list){
								$model_file->name  = $list['name'];
								$model_file->type  = $list['type'];
								$model_file->ext  = $list['extension'];
								$model_file->path  = $this->file_path.'/'.$list['saved_as'];
								$model_file->create_at  = time();
								$model_file->uid  = $this->uid;
								$model_file->size  = $list['size'];
								$model_file->save();
							 	$file_ids[$vo['name']] = $model_file->id;
							 	$_POST[$vo['name']] = $model_file->id;
							}	   
					 	
					}
					 
					foreach (\Upload::get_errors() as $file)
					{
					  
					     if(!$post && $is_required == true && count($file['errors'])>0){ 
					     	if($_POST)
					     		$error = $hooks.= "<p>".__("comm.field").': '.__('comm.'.$vo['name']).'  '.__('comm.'.$file['errors'][0]['message']).'</p>';
					     }
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
			  
			if($error) {
				foreach($file_ids as $nid){
					$e = \Model_File::find($nid);
					@unlink(DOCROOT.DS.$e->path);
					$e->delete();
				}
				goto a;
			}  
			if(!$fid)
				$post = new $model_name;
			else
				$post = $model_name::find($fid);
			foreach($form as $vo){ 
				if(trim($fields[$vo['name']]))
					$post->$vo['name']   = trim($fields[$vo['name']]);
			}
		 	$post->sort = 1;
		 	$post->active = 1;
		 	$post->create_at = time();
		 	$post->update_at = time();
		 	if($file_ids){
		 		foreach($file_ids as $file_field=>$file_id){
		 			if($file_id)
		 				$post->$file_field = $file_id;
		 		}
		 	} 
		 	  
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
		$view->set('form',$auto_form);
		$view->set('plugins',$this->plugins);
		
		$this->template->set('content', $view, false); 
		$this->template->set('hooks', $hooks, false);  
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