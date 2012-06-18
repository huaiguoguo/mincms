<?php 
namespace Admin; 
class Controller_Group extends \Controller_Base_Auth
{ 
	public $encode = 'R@nd0mK~Y';
	public $role;
	function before(){
		parent::before();
		$this->menus = $this->auth_links; 
		$this->menus['active_url'] = \Uri::create('admin/user/index'); 
		$this->role = \Model_Controller::find('all',array('order_by'=>array('sort'=>'desc','id'=>'desc'))); 
	}
	/**
	* @ 用户组列表
	*/
	function action_index()
	{ 
		$url = \Uri::create('admin/user/index'); 
		$this->lists($url,'Model_Group',array('group/index',array('encode'=>$this->encode)),4);  
	}
	/**
	* @添加用户组
	*/
	function action_add()
	{
	 	$fieldset = \Fieldset::forge('groups');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');    
    	$val->add('name', __('comm.name'), array('value'=>$_POST['name']), array('trim', 'strip_tags', 'required')); 
    	$val->add('val', __('comm.val'), array('value'=>$_POST['val']), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', 'groups.val'); 
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			$post = new \Model_Group;
			$post->name   = trim($fields['name']); 
			$post->val   = trim($fields['val']); 
			if($post->save())
			{ 
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('admin/group/index'));
			}
			else
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/group/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}  
	 	$s = "<div class='alert alert-waring'>".__('comm.val is unique')."</div>";
		$form     = $fieldset->form();  
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.add'), 'class' => 'btn btn-primary'));	 
		$this->template->set('content', $s.$form->build(), false); 
		
	}
	/**
	* @编辑用户组信息
	*/
	function action_edit($id){
		$this->menus['active'] = 3;
		$id = \Crypt::decode($id, $this->encode);
		$post = \Model_Group::find($id);
		$fieldset = \Fieldset::forge('groups');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');    
    	$val->add('name', __('comm.name'), array('value'=>$post->name), array('trim', 'strip_tags', 'required')); 
    	$val->add('val', __('comm.val'), array('value'=>$post->val), array('trim', 'strip_tags', 'required'))
    	->add_rule('unique', "groups.val.$id"); 
 		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated(); 
			$post->name   = trim($fields['name']); 
			$post->val   = trim($fields['val']); 
			if($post->save())
			{ 
			 	\Session::set_flash('success', __('comm.save success') );
				\Response::redirect(\Uri::create('admin/group/index'));
			}
			else
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/group/index'));
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}  
	 	$s = "<div class='alert alert-waring'>".__('comm.val is unique')."</div>";
		$form     = $fieldset->form();  
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.update'), 'class' => 'btn btn-primary'));	 
		$this->template->set('content', $s.$form->build(), false); 
	}
	/**
	* @组绑定权限
	*/
	function action_bind($id,$fid=null){
		if($fid) { 
			$user = \Model_Users::find(\Crypt::decode($fid, 'R@nd0mK~Y'));
		}
		$this->menus['active'] = 3;
		$old_id = $id;
		$id = \Crypt::decode($id, $this->encode);
		$post = \Model_Group::find($id); 
     	$actions =	\Model_Acl::find('all',array('where'=>array('group_id'=>$id)));
     	$acts = array();
     	foreach($actions as $vo){
     		$acts[] = $vo->action_id;
     	} 
 		if($_POST['role'])
		{  
			if(count($_POST['role'])<1 || $id<1)
			{
		 		\Session::set_flash('error', 'There is error happend');
				\Response::redirect(\Uri::create('admin/group/index'));
			}
			\DB::delete('role_acl')->where('group_id',$id)->execute();
			 
			foreach($_POST['role'] as $v){ 
				$query = new \Model_Acl;
				$query->group_id   = $id; 
				$query->action_id   = $v; 
				$query->save();
			} 
			\Cache::delete('admin_groups_roles');
		 	\Session::set_flash('success', __('comm.save success') );
		 	if($fid)
				\Response::redirect(\Uri::create('admin/group/bind/'.$old_id.'/'.$fid));
			else
				\Response::redirect(\Uri::create('admin/group/bind/'.$old_id));
				
			
		}
	 
	  	$view = \View::forge('group/bind');
	  	$view->set('post',$post);
	  	$view->set('role',$this->role);
	  	$view->set('actions',$acts);
	  	$view->set('user',$user);
		$this->template->set('content', $view); 
	}
	
	
}