<?php
namespace Content;
/**
*  
* content type
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Type extends \Controller_Base_Auth{
	public $min;
	public $max;
	function before(){
		parent::before();
		if($this->cck_enable()!=1){
			exit(__('comm.Access deny,cck is locked'));
		}
		$this->menus = include __DIR__.'/../../menu.php';	  
		$this->menus['active_url'] = \Uri::create('content/home/index');
	}
	/**
	* @内容类型列表
	*/
	function action_index(){
	 	$this->min = \Model_Content_Type::min('sort');
		$this->max = \Model_Content_Type::max('sort'); 
		$url = \Uri::create('content/type/index');
		$this->lists($url,array('Model_Content_Type',array('order_by'=>array('sort'=>'asc','id'=>'asc'))),array('type/index',array('min'=>$this->min,'max'=>$this->max)),4);
		
	}
	/**
	* @添加内容类型
	*/
	function action_add(){
	    $fieldset = \Fieldset::forge('content_type');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');  
    	$val->add('name', __('comm.name'), array('value'=>$_POST['name']), array('trim', 'strip_tags', 'required'))	; 
    	$val->add('val', __('comm.val'), array('value'=>$_POST['val']), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', 'content_type.val');  
    		
 		if($fieldset->validation()->run() == true)
		{  
			$fields = $fieldset->validated();
			$post = new \Model_Content_Type;
			$post->name   = trim($fields['name']);
			$post->val   = trim($fields['val']); 		
			if($post->save()){  
				$post->sort = $post->id;
				\Vendor\Table::create($post->val);
				$post->save();
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('content/type/index'));
			}
		 
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}   
		$form     = $fieldset->form();  
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.add'), 'class' => 'btn btn-primary'));	 
		$this->template->set('content', $form->build(), false); 
	   
	   
	}
	/**
	* @内容类型编辑
	*/
	function action_edit($id){
		$this->menus['active'] = 2;
		$post = \Model_Content_Type::find($id);
		$old = $post->val;
	    $fieldset = \Fieldset::forge('content_type');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');  
    	$val->add('name', __('comm.name'), array('value'=>$post->name), array('trim', 'strip_tags', 'required'))	; 
    	$val->add('val', __('comm.val'), array('value'=>$post->val,'readonly'=>'readonly'), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', "content_type.val.$id");   
 		if($fieldset->validation()->run() == true)
		{  
			$fields = $fieldset->validated(); 
			$post->name   = trim($fields['name']);
			$post->val   = trim($fields['val']); 		
			if($post->save()){   
				\Vendor\Table::rename($old,$post->val);
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('content/type/index'));
			}
		 
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}   
		$form     = $fieldset->form();  
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.update'), 'class' => 'btn btn-primary'));	 
		$this->template->set('content', $form->build(), false); 
	   
	   
	}
	function action_sort($id,$s='up'){
		$this->_sort($id,$s,'\Model_Content_Type');
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/type/index')); 
	}
	/**
	* @自动生成对应的model文件
	*/
	function action_g(){
		$posts = \Model_Content_Type::find('all');
		$pre_old =  \Vendor\Table::$pre;
		$pre = str_replace('_','',$pre_old);
		$d = APPPATH.'classes/model/'.$pre;
		if(!is_dir($d)) \Vendor\Dir::mkdir($d); 
		
		foreach($posts  as $post){
			$name =  $post->val;
			$table_name = $pre_old.$name;
				foreach($post->fields as $f){
					switch($f->form->val){
						case "file":
					    	$_belongs['r_'.$f->name] = array( 
						        'key_from' => $f->name,
						        'model_to' => 'Model_File',
						        'key_to' => 'id',
						        'cascade_save' => false,
						        'cascade_delete' => false, 
							);
							break;
			    	}
			    	unset($ops);
			    	$ops = $f->options;			    
  					if($ops){
  						$opsm = 'Model_'.ucfirst($ops['rt']);
  						$rtcolumn = strtolower($ops['column']);
  						/*$in = array(
	  						7=>'relation_belongs_to',8=>'relation_has_one',9=>'relation_has_many'
	  					);*/
	  					if(in_array($f->form_id,array(7,8,9))){
	  						switch($f->form_id){
				    			case 7:
				    				//belongs_to
				    				$_belongs['r_'.$f->name] = array( 
								        'key_from' => $f->name,
								        'model_to' => $opsm,
								        'key_to' => 'id',
								        'cascade_save' => false,
								        'cascade_delete' => false, 
									);
				    				break;
				    		}
	  					}
  					}
  					
			    	
								
			}
			$word = "<?php\nclass Model_".ucfirst($pre)."_".ucfirst($name)." extends \Orm\Model
{
	protected static \$_table_name = '".$table_name."';
	protected static \$_primary_key = array('id');\n";
if($_belongs)
	$word .= "	protected static \$_belongs_to =\t"."
			".var_export($_belongs,true) .
			";\n";

$word .="
}
";			$file = $d.'/'.$name.'.php';
			file_put_contents($file,$word); 
		}

		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('content/type/index')); 
	}
}