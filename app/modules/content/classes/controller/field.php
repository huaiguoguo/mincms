<?php
namespace Content;
/**
*  
* content field
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Field extends \Controller_Base_Auth{
	public $min;
	public $max;
	public $form;
	public $rules;
	public $db_type;
	public $tables;
	function before(){
		parent::before();
		if($this->cck_enable()!=1){
			exit(__('comm.Access deny,cck is locked'));
		}
		error_reporting(0);
		$tables = \DB::query("show tables",\DB::SELECT)->execute();
		$this->tables[] = __('comm.pls select');
		foreach($tables as $v){
			foreach($v as $vi){
				if($vi=='users' || strpos($vi,'auto_')!==false)
					$this->tables[$vi] = $vi;
			}
		}  
		$this->menus = include __DIR__.'/../../menu.php';	  
		$this->menus['active_url'] = \Uri::create('content/home/index');
		$forms = \Model_Content_Form::find('all',array('order_by'=>array('sort'=>'desc','id'=>'desc')));
		foreach($forms as $v){
			$this->form[$v->id] = $v->name;
		} 
		$this->db_type['int'] = 'int';
		$this->db_type['varchar'] = 'varchar';
		$this->db_type['text'] = 'text';
		$this->rules = array(
			'required'=>'required',
			'min_length'=>'min_length',
			'max_length'=>'max_length',
			'valid_email'=>'valid_email',
			'valid_url'=>'valid_url',
			'valid_ip'=>'valid_ip',
			'numeric_min'=>'numeric_min',
			'numeric_max'=>'numeric_max',
			'file'=>array(
				'max_size',
			    'ext_whitelist', 
			),
			'valid_string'=>array(
				'alpha','uppercase','lowercase','numeric'
			)  
		);
	}
	/**
	* @字段列表
	*/
	function action_index($id,$fid=null){ 
		$this->menus['active'] = 2;  
	  	$content = \Model_Content_Type::find($id, array(
			    'related' => array(
			        'fields' => array(
			            'order_by' => array('sort'=>'asc','id' => 'asc'), 
			        ),
			    ),
			));  
		if($content->fields){
	  	foreach($content->fields as $v){
	  		$arr[$v->id] = $v->sort;
	  	}}
	  	if($arr){
		    $this->min = min($arr);
		    $this->max = max($arr);
	    }
		$view = \View::forge('field/index');
	 
		$view->set('id',$id);
		$view->set('min',$this->min); 
		$view->set('max',$this->max); 
		$view->set('form',$this->form); 
		$view->set('content',$content);
		$view->set('rules',$this->rules);
		$view->set('db_type',$this->db_type);
		$view->set('tables',$this->tables);
		if($fid){
			//编辑时取得信息
			$edit = \Model_Content_Field::find($fid);
			$view->set('fid',$fid);
			$view->set('edit',$edit); 
		}
		
		if($_POST){ 
			extract($_POST); 
			$name = trim($name);
			/*
			* check value is not exists
			*/ 
			if(in_array($name,array('id','sort','create_at','update_at','active'))) {
				\Session::set_flash('error', __('comm.name is exists'));
				\Response::redirect(\Uri::create('content/field/index/'.$id)); 
			}
			if($rt && $column)
				$options = array('rt'=>$rt,'column'=>$column);
			
			$model = \Model_Content_Field::find('first',array('where'=>array('type_id'=>$id,
			'name'=>$name)));
			if(!$model)
				$model = new \Model_Content_Field;
			$model->type_id = $id;
			$model->label = $label;
			$model->name = $name; 
			$model->form_id = $type;
			if($options)
				$model->options = $options; 
			if($default)
				$model->default = $default;  
			$model->create_at = time();
			$model->update_at = time(); 
			$model->save(); 
			$model->sort = $model->id;
			$model->save();
			if($fid){
				\Model_Content_Rule::find('first',array('where'=>array('field_id'=>$fid)))->delete();
			}
			$model_rule = new \Model_Content_Rule;
			
			$model_rule->field_id =  $model->id; 
			$i=0;
		
			foreach($rule as $v){
				if($i>0&& $v && $value[$i]){
					$rules[$v] = $value[$i];
				}
				$i++;
			}	 
			if($rules){
				$model_rule->rules = $rules;
				$model_rule->save();
			}
			if($model){
				$this->field_one($model,$content->val);
				
			}
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('content/field/index/'.$id)); 
		}
		$this->template->content = $view;
	}
	/**
	* @删除字段
	*/
	function action_del($id,$fid){
		$post = \Model_Content_Type::find($id);
		$f = \Model_Content_Field::find($fid);
		echo $post->val.'<br>';
	 	$name = $f->name;
	 	$query = \DB::delete('content_fields');
	 	$query->where('id', $fid);
		$query->execute(); 
		\Vendor\Table::del($post->val,$name); 
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/field/index/'.$id)); 
	}
	protected function field_one($v,$table){ 
			$len = 200;
	  		$t = 'varchar';
	  		$rules = $v->rule->rules;
	  		$form[$v->id] = array('label'=>$v->label,'name'=>$v->name,'form'=>$v->form->val,'rules'=>$rules);
	  		if((int)$rules['max_length']>0) $len = (int)$rules['max_length'];
	  		switch($v->form->val){
	  			case 'input':
	  				$t = 'varchar';
	  				break;
	  			case 'textarea':
	  				$t = 'text'; 
	  				break;
	  		}
	  		switch($v->form->use){
	  			case 'orm':
	  				$t = 'int';
	  				$len = 11;
	  				break;
	  		}
	  		if($t == 'text') 
	  			$db[$v->name] = array('type' => $t);
	  		else
	  			$db[$v->name] = array('constraint' => $len, 'type' => $t); 
	  		\Vendor\Table::add($table,$db);
	}
	/**
	* 添加所有字段，仅供测试使用
	*/
	protected function field_all($model){
		$table =  $model->val;
		/**
		 (
            [label] => 标题
            [name] => title
            [form] => input
            [rules] => Array
                (
                    [required] => 1
                )

        ) 
        
		*/
		if($model->fields){
	  		$len = 200;
	  		$t = 'varchar';
	  		foreach($model->fields as $v){
	  		$form[$v->id] = array('label'=>$v->label,'name'=>$v->name,'form'=>$v->form->val,'rules'=>$v->rule->rules);
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
	  	}} 
	  	 
		\Vendor\Table::add($table,$db);
	}
	/**
	* @保存排序
	*/ 
	function action_sort($id,$s='up',$fid){
		$this->_sort($id,$s,'\Model_Content_Field');
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/field/index/'.$fid)); 
	}
	/**
	* @选择关联显示的字段
	*/
	function action_rtcolumns(){
		$t = $_POST['t'];
		if(!$t) return false;
		$ls = \DB::list_columns($t);
		foreach($ls as $k=>$v){
			$s .="<option value='".$k."'>".$k."</option>";
		}
	 	echo $s;
		exit;
	}
}