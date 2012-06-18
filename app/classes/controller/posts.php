<?php

 
class Controller_Posts extends  \Controller_Base_Public
{
	function action_index()
	{
		$config = array(
		    'pagination_url' => Uri::create('posts/index'),
		    'total_items' => \Model_Post::count(),
		    'per_page' => 1,
		    'uri_segment' => 3,  
		); 		
		$this->config_paginate($config,'apple_pagination'); 	 
		$posts = \Model_Post::find('all',array(
			'limit'=>Pagination::$per_page,
			'offset'=>Pagination::$offset
		)); 
		$pagination = Pagination::create_links(); 
		$view  = \View::forge('posts/index');
		$view->set('posts', $posts, false);
		$view->set('pagination', $pagination, false);
		$this->template->content = $view;  
	}
 	
	function action_add()
	{
		$fieldset = Fieldset::forge()->add_model('Model_Post');
			
		if($fieldset->validation()->run() == true)
		{ 
			$fields = $fieldset->validated();
			$post = new Model_Post;
			$post->post_title     = $fields['post_title'];
			$post->post_content   = $fields['post_content'];
			$post->author_name    = $fields['author_name'];
			$post->author_email   = $fields['author_email'];
			$post->author_website = $fields['author_website'];
			$post->post_status    = $fields['post_status'];
			
			if($post->save())
			{
				\Response::redirect('posts/edit/'.$post->id);
			}
		}
		else
		{  
			$this->template->set('messages', $fieldset->validation()->show_errors(), false); 
		}
		if(isset($post)) $fieldset->populate($post);
		$form     = $fieldset->form(); 
		$form->add('submit', '', array('type' => 'submit', 'value' => 'Add', 'class' => 'btn medium primary'));	

		$this->template->set('content', $form->build(), false);
		
	}
	function action_edit($id)
	{
		$post = \Model_Post::find($id);

		$fieldset = Fieldset::forge()->add_model('Model_Post')->populate($post); 
		$form     = $fieldset->form();
		$form->add('submit', '', array('type' => 'submit', 'value' => 'Save', 'class' => 'btn medium primary'));

		if($fieldset->validation()->run() == true)
		{
			$fields = $fieldset->validated(); 
			$post->post_title     = $fields['post_title'];
			$post->post_content   = $fields['post_content'];
			$post->author_name    = $fields['author_name'];
			$post->author_email   = $fields['author_email'];
			$post->author_website = $fields['author_website'];
			$post->post_status    = $fields['post_status'];

			if($post->save())
			{
				\Response::redirect('posts/edit/'.$id);
			}
		}
		else
		{
			$this->template->set('messages', $fieldset->validation()->show_errors(), false);  
		}

		$this->template->set('content', $form->build(), false);
	}
	
 

 
}
