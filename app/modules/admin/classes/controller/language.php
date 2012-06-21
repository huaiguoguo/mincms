<?php
namespace Admin;
/**
* Generate language,shuch as zh, en .etc for system
* need auth,just admin has access. so use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Language extends \Controller_Base_Auth
{ 
	public $s;
	function before(){
		parent::before();
		$this->menus = array(
			array('label'=>__('comm.translation'),'url'=>\Uri::create('admin/translate/index')),
			array('label'=>__('comm.translation add'),'url'=>\Uri::create('admin/translate/add')),
			array('label'=>__('comm.language'),'url'=>\Uri::create('admin/language/index')),
			array('label'=>__('comm.language add'),'url'=>\Uri::create('admin/language/add')),
		); 
		$this->menus['active_url'] = \Uri::create('admin/translate/index');
		$this->s = "<div class='alert alert-info'>".__('comm.pls confirm you are admin language is very importent')."</div>";
	}
	/**
	* @语言列表
	*/
 	function action_index()
	{ 
		$lans = \Model_Language::find('all', array(
			'related' => array('file')
		));
		foreach($lans as $v){ 
			$counts[] = count($v->file); 
			$mu[count($v->file)] = $v->code;
		}
		$count = max($counts);
		$lan = \Model_Language::find('first', array(
			'where'=>array('default' => 1)
		)); 
		$max = $lan->code;
		 
		$this->template->set('msg',$this->s);
		$url = \Uri::create('admin/language/index');
		$this->template->content = $this->lists($url,'Model_Language',array('language/index',array('msg'=>$this->s,'count'=>$count,'max'=>$max)),4);
		
	}
	/**
	* @添加新语言
	*/
 	function action_add()
	{ 
		$fieldset = \Fieldset::forge('language');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');
		$val->add('name', __('comm.name'), array('value'=>$post->name), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', 'language.name');
    	$val->add('code', __('comm.language_key'), array('value'=>$post->code), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', 'language.code');
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			$post = new \Model_Language;
			$post->name   = trim($fields['name']);
			$post->code   = trim($fields['code']); 			
			if($post->save())
			{ 
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('admin/language/index'));
			}
			else
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/language/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		} 
		// build form 
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.add'), 'class' => 'btn'));	 
		$this->template->set('content', $this->s.$form->build(), false); 
	}
	/**
	*@编辑语言
	*/
	function action_edit($id)
	{
	 	$this->menus['active'] = 3;
		$post = \Model_Language::find($id);
		$fieldset = \Fieldset::forge('language');  
		$fieldset->populate($post);
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');
		$val->add('name', __('comm.name'), array('value'=>$post->name), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', "language.name.$id");
    	$val->add('code', __('comm.language_key'), array('value'=>$post->code), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', "language.code.$id");
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated(); 
			$post->name   = trim($fields['name']);
			$post->code   = trim($fields['code']); 			
			if($post->save())
			{ 
			 	\Session::set_flash('success', __('comm.save success'));
				\Response::redirect(\Uri::create('admin/language/index'));
			}
			else
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/language/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		} 
		// build form 
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.update'), 'class' => 'btn'));	 
		$this->template->set('content', $this->s.$form->build(), false); 
	}
	/**
	* @激活对应的语言
	*/
	function action_active($id){
		$this->menus['active'] = 3;
		$post = \Model_Language::find($id);
		if($post->default==1){
			\Session::set_flash('error', __('comm.save error'));
			\Response::redirect(\Uri::create('admin/language/index'));
		}
		if($post->active==1)
			$post->active = 0;
		else
			$post->active = 1;
		if($post->save())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/language/index'));
		} 
	}
	/**
	* @设为默认语言
	*/
	function action_enable($id){
		$this->menus['active'] = 3;
		\DB::update('language')
			->value("default",0) 
			->execute(); 
		$post = \Model_Language::find($id);
		$post->active = 1;
		$post->default = 1; 
		if($post->save())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/language/index'));
		} 
	}
	/**
	* @转换语言包
	*/
	function action_cover($in,$base){
		$this->menus['active'] = 3;
		\Vendor\Cache::disable();
		$post = \Model_Language::find('first',array('where'=>array('code'=>$base)));
		$lan_id = $post->id; 
		$in_post = \Model_Language::find('first',array('where'=>array('code'=>$in)));
		//当前语言ID
		$current_lang_id = $in_post->id; 
		if($_POST){  
			$i=0;
			$a = $_POST['name']; 
			$b = $_POST['out'];  
			foreach($a as $k){ 
				$v = $b[$i++];  
				$k = trim($k);
				$v = trim($v);
				if(!$k || !$v)continue;
				unset($model);
				$model = \Model_Language_File::find('first',array(
					'where'=>array(
						'language_id'=>$current_lang_id,
						'name'=>$k
					)
				));
				if(!$model)
					$model = new \Model_Language_File; 
				$model->language_id = $current_lang_id;
				$model->name = $k;
				$model->out = $v;
				
				$model->create_at = time();
				$model->save(); 
			}  
			 
			\Session::set_flash('success', __('comm.save success') ); 
			\Response::redirect(\Uri::create('admin/language/cover/'.$in.'/'.$base));
			 
		 }
		 //当前翻译的语言内容
		$current_post = \Model_Language_File::find('all',array('where'=>array('language_id'=>$current_lang_id)));
		// 模板语言
		$posts = \Model_Language_File::find('all',array('where'=>array('language_id'=>$lan_id),'order_by'=>array('id'=>'desc')));
	 	foreach( $current_post as  $v )
		{
			 $u[$v->name] = $v->out;
		}
		foreach($posts as $v){ 
			$out[$v->name] = $u[$v->name];
		}			 
		
		
	 	 
		$view = \View::forge('language/cover');
		$view->set('models',$out);
		$view->set('in',$in);
		$view->set('base',$base);
		$this->template->content = $view;
	}
 	
  
}
