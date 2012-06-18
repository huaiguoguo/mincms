<?php
namespace Admin;
/**
* Generate language file to /app/lang/en/file.php
* need auth,just admin has access. so use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Translate extends \Controller_Base_Auth
{ 
	function before(){
		parent::before();
		$this->menus = array(
			array('label'=>__('comm.translation'),'url'=>\Uri::create('admin/translate/index')),
			array('label'=>__('comm.translation add'),'url'=>\Uri::create('admin/translate/add')),
			array('label'=>__('comm.language'),'url'=>\Uri::create('admin/language/index')),
			array('label'=>__('comm.language add'),'url'=>\Uri::create('admin/language/add')),
		); 
		$this->menus['active_url'] = \Uri::create('admin/translate/index');
	}
 	function action_index()
	{ 
		$this->run();
		$url = \Uri::create('admin/translate/index');
		$this->lists($url,array('Model_Language_File',array('order_by'=>array('id'=>'desc'))),'translate/index',4);
	}
	
 	function action_add()
	{ 
		$fieldset = \Fieldset::forge('language_file');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');
		$val->add('name', __('comm.name'), array('value'=>$post->name), array('trim', 'required'))
    	->add_rule('unique', 'language_file.name');
    	$val->add('out', __('comm.display'), array('value'=>$post->out), array('trim',  'required'));
    	$rows = \Model_Language::find('all');
    	foreach($rows as $row){ 
    		$ops[$row->id] = $row->code;
			if($row->default==1)
			$select_v = $row->id;
    	} 
    	$val->add('language_id', __('comm.language'), array(
			'options' => $ops, 
			'type' => 'select',
			'value'=>$select_v
		));
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			$post = new \Model_Language_File;
			$post->name   = trim($fields['name']);
			$post->out   = trim($fields['out']);
			$post->language_id   = trim($fields['language_id']); 
			$post->create_at = time();	 			
			if($post->save())
			{ 
			 	\Session::set_flash('success', __('comm.save success') );
				$this->run();
				\Response::redirect(\Uri::create('admin/translate/add'));
			}
			else
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/translate/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		} 
		// build form 
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.add'), 'class' => 'btn'));	 
		$this->template->set('content', $form->build(), false); 
	}
	
	function action_edit($id)
	{
		$this->menus['active'] = 1;
		$this->breadcrumb = array(
			array('label'=>__('comm.translation'),'url'=>\Uri::create('admin/translate/index')),
			array('label'=>__('comm.edit'),'url'=>\Uri::create('admin/translate/add'),'active'=>true),
		);
		$post = \Model_Language_File::find($id); 
		$select_v = $post->language_id;
		$fieldset = \Fieldset::forge('language_file');  
		$fieldset->populate($post); 
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');
		$val->add('name', __('comm.name'), array('value'=>$post->name), array('trim', 'required'))
    	->add_rule('unique', "language_file.name.$id");
    	$val->add('out', __('comm.display'), array('value'=>$post->out), array('trim',  'required'));
    	$rows = \Model_Language::find('all');
    	foreach($rows as $row){ 
    		$ops[$row->id] = $row->code;
    	} 
    	$val->add('language_id',__('comm.language'), array('options' => $ops, 'type' => 'select','value'=>$select_v));
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated(); 
			$post->name   = trim($fields['name']);
			$post->out   = trim($fields['out']);
			$post->language_id   = trim($fields['language_id']); 
			$post->update_at = time();	 			
			if($post->save())
			{ 
			 	\Session::set_flash('success', __('comm.save success') );
				$this->run();
				\Response::redirect(\Uri::create('admin/translate/add'));
			}
			else
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/translate/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		} 
		// build form 
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.update'), 'class' => 'btn'));	 
		$this->template->set('content', $form->build(), false); 
		
		 
	}
	function run(){
		$posts = \Model_Language_File::find('all');
		foreach($posts as $post){   
			$array[$post->language->code]['comm'][$post->name] = $post->out;
		}
		unset($s); 
		foreach($array as $k=>$value){ 
			foreach($value as $key=>$v){ 
				$s = "<?php \nreturn  ". var_export($v,true) ."\n;";
				$path = APPPATH.'/lang/'.$k;
				if(!is_dir($path)) \Vendor\Dir::mkdir($path);
				file_put_contents($path.'/'.$key.'.php',$s);
			}
		}
	}
	
	
 	
  
}
