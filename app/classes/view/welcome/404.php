<?php

/**
 * The welcome 404 view model.
 *
 * @package  app
 * @extends  ViewModel
 */
class View_Welcome_404 extends ViewModel
{
 
	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 * 
	 * @return void
	 */
	public function view()
	{
		$d = \Model_Config::find('first',array('where'=>array('name'=>'open')));
		if($d->val==2){
			$post = \Model_Config::find('first',array('where'=>array('name'=>'close_info')));
			$content = $post->val?:__('comm.our website now is close,any problem pls connect us');
			$this->message = $content;
		}else{
			$this->message = __('comm.page not find');
		}

		$messages = array('Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?');
		$this->title = $messages[array_rand($messages)];
		
	}
}
