<?php 
namespace Admin; 
class Controller_User extends \Controller_Base_Auth
{ 
	public $encode = 'R@nd0mK~Y';
	public $group;
	function before(){
		parent::before();
		$this->menus = $this->auth_links;
		 
		$this->menus['active_url'] = \Uri::create('admin/user/index');
		$g = \Model_Group::find('all',array('order_by'=>array('sort'=>'desc','id'=>'desc')));
    	$group[''] = __('comm.pls select');
    	foreach($g as $v){
    		$this->group[$v->id] = $v->name;
    	}
	}
	/**
	* @ set use profile
	*/
	function action_profile(){
		$this->menus = null;
		// get all language
		$rows = \Model_Language::find('all');
    	foreach($rows as $row){ 
    		$ops[$row->id] = $row->code;
			if($row->default==1)
			$select_v = $row->id;
    	} 
    	$user = \Model_Users::find($this->uid);
    	
    	$user->profile_fields = \Format::forge($user->profile_fields, 'json')->to_array() ;
    	if(!$user->profile_fields['language']){
    		$user->profile_fields['language'] = $select_v;
    	}
    	$view = \View::forge('user/profile');
		$view->set('languages',$ops);
	 	$view->set('user',$user,false);
		if($_POST){
			extract($_POST);
			$profile_fields['language'] = $language;
			$profile_fields = json_encode($profile_fields);  
		 	//update user profile
		  	\DB::update('users')
		  		->value('profile_fields', $profile_fields)->where('id','=',$this->uid)->execute(); 
		  	\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/user/profile'));
		}
		$this->template->content = $view;
		
	}
	/**
	* @用户列表
	*/
	function action_index()
	{  
		 
		$url = \Uri::create('admin/user/index');
		
		$this->template->content = $this->lists($url,'Model_Users',array('user/index',array('encode'=>$this->encode)),4);  
	}
	/**
	* @启用或禁用用户
	*/
	function action_active($id){ 
		$this->menus['active'] = 3;
		$id = \Crypt::decode($id, $this->encode);
		$post = \Model_Users::find($id); 
		if($post->active==1)
			$post->active = 0;
		else
			$post->active = 1;
		if(in_array($id,$this->super_admin)){
			$post->active = 1;
		}
		if($post->save())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/user/index'));
		} 
	}
	/**
	* @添加用户
	*/
	function action_add()
	{ 
	 	$fieldset = \Fieldset::forge('language');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate'); 
    	$val->set_message('match_pattern', __('comm.the field :label should be tel'));
    	$val->add('username', __('comm.username'), array('value'=>$_POST['username']), array('trim', 'strip_tags', 'required'))
		//->add_rule('match_pattern','/(13[0-9]{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|5|6|7|8|9]\d{8})/')
    	->add_rule('unique', 'users.username'); 
    	$val->add('email', __('comm.email'), array('value'=>$_POST['email']), array('trim','valid_email', 'strip_tags', 'required'))
    	->add_rule('unique', 'users.email');
    	$val->add('password', __('comm.password'), array('type'=>'password'), array('trim', 'strip_tags', 'required'))
    	->add_rule('min_length', 6);
    	
    	$val->add('group', __('comm.group'), array('value'=>$_POST['group'],'options'=>$this->group,'type'=>'select'), array('required'));
    		
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			
			if(\Auth::instance()->create_user(
				trim($fields['username']),
				$fields['password'],
				trim($fields['email']),$fields['group'])){ 
				$mail = new \Vendor\Email;
				$mail->send(array($fields['email']),'后台管理信息',"后台管理员用户信息：<br>您的帐号名: ".$fields['username']."  或使用您的邮箱：".$fields['email']."  登录<br>密码： ".$fields['password']);	  
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('admin/user/index'));
			}
		 
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}  
	 	$s = "<div class='alert alert-waring'>".__('comm.you can login tel or email')."</div>";
		$form     = $fieldset->form(); 
		
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.add'), 'class' => 'btn btn-primary'));	 
		$this->template->set('content', $s.$form->build(), false); 
		
	}
	/**
	* @修改用户信息
	*/
	function action_edit($id){
		$this->menus['active'] = 1;
		$id = \Crypt::decode($id, $this->encode);
		$post = \Model_Users::find($id);
		$fieldset = \Fieldset::forge('language');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate'); 
    	$val->set_message('match_pattern', __('comm.the field :label should be tel'));
    	$val->add('username', __('comm.username'), array('value'=>$post->username), array('trim', 'strip_tags', 'required'))
		//->add_rule('match_pattern','/(13[0-9]{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|5|6|7|8|9]\d{8})/')
    	->add_rule('unique', "users.username.$id");
    	$val->add('email', __('comm.email'), array('value'=>$post->email), array('trim','valid_email', 'strip_tags', 'required'))
    	->add_rule('unique', "users.email.$id");
    	$val->add('password', __('comm.password'), array('type'=>'password'), array('trim', 'strip_tags'))
    	->add_rule('min_length', 6);
    	
    	$val->add('group', __('comm.group'), array('value'=>$post->group,'options'=>$this->group,'type'=>'select'), array('required'));
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated(); 
			$post->username   = trim($fields['username']);
			$post->email   = trim($fields['email']); 
			if($fields['password'] && strlen($fields['password'])>5)
				$post->password  =  \Auth::instance()->hash_password($fields['password']);
			$post->group = $fields['group'];
			$post->created_at = time();  			
			if($post->save())
			{ 
				$mail = new \Vendor\Email;
				$send = $mail->send(array($fields['email']),'密码变更通知',"密码变更通知：<br>您的帐号名: ".$fields['username']."  或使用您的邮箱：".$fields['email']." 于".date('Y-m-d H:i:s',$post->created_at)."变更了密码<br>您的新密码为： ".$fields['password']);	  
				if($send){
				 	\Session::set_flash('success', __('comm.save success') );
					\Response::redirect(\Uri::create('admin/user/index'));
				}else{
					\Session::set_flash('error', __('comm.there is error happend for send mail'));
					\Response::redirect(\Uri::create('admin/user/index'));
				}
			}
			else
			{
		 		\Session::set_flash('error', __('comm.there is error happend for send mail'));
				\Response::redirect(\Uri::create('admin/user/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}  
	 	$s = "<div class='alert alert-waring'>".__('comm.you can login tel or email')."</div>";
		$form     = $fieldset->form(); 
		
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.add'), 'class' => 'btn btn-primary'));	 
		$this->template->set('content', $s.$form->build(), false); 
	}
}