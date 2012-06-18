<?php

 
class Controller_Users extends \Controller_Base_Public
{
 	public function before() {
 		parent::before(); 
 	}
 	
 	function action_login()
	{
		$fieldset = Fieldset::forge()->add_model('Model_Users');			
		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			$post = new Model_Users;
			$post->username     = $fields['username'];
			$post->password   = $fields['password']; 
		 
			if(Auth::instance()->login($post->username,$post->password))
			{
				\Response::redirect('posts/index');
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
		$form->add('submit', '', array('type' => 'submit', 'value' => 'Login', 'class' => 'btn'));	 
		$this->template->set('content', $form->build(), false);
		
	}
	function action_logout(){
		Auth::instance()->logout();
		\Response::redirect('welcome/index');
	}
	function action_add()
	{
		$fieldset = Fieldset::forge()->add_model('Model_Users');			
		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			$post = new Model_Users;
			$post->username     = $fields['username'];
			$post->password   = $password = Auth::instance()->hash_password($fields['password']); 			
			if($post->save())
			{
				\Response::redirect('posts/index');
			}
			else
			{
				\Session::set_flash('error', 'There is error happend');
				 
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}
		if(isset($post)) $fieldset->populate($post);
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => 'Login', 'class' => 'btn'));	 
		$this->template->set('content', $form->build(), false);
		
	}
 	
  
}
