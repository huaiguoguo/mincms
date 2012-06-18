<?php
namespace Admin;
 
class Controller_Login extends \Controller_Base_Admin
{ 
 	/**
 	* @ 用户登录
 	*/
 	function action_index()
	{
		$fieldset = \Fieldset::forge('user');   
		$val = $fieldset->validation(); 
		$val->add_callable('\Vendor\Validate');
		$val->add('username', __('comm.username'), array('value'=>$_POST['username']), array('trim',  'required')); 
		$val->add('password',__('comm.password'), array('value'=>$_POST['password'],'type'=>'password'), array('trim',  'required'))
		->add_rule('min_length', 6); 
					
		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			
			$username     = $fields['username'];
			$password   = $fields['password'];  
			if(\Auth::instance()->login($username,$password))
			{
				\Response::redirect('admin/home/index');
			}
			else
			{
				\Session::set_flash('error', 'Username and/or password is incorrect');
				 
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}
		if(isset($post)) $fieldset->populate($post);
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => __('comm.login'), 'class' => 'btn'));	 
		$this->template->set('content', $form->build(), false);
		
	}
	
	
 	
  
}
