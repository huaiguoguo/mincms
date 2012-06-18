<?php
namespace Vendor;
/**
* 
$mail = new \Vendor\Email;
$mail->send($to,$subjct,$content);
*/
class Email{ 
	public $forge;
	function __construct(){
		\Package::load('email');
		$this->forge['driver'] = $driver = $this->_config('email_driver');
		if($driver=='smtp'){
			$this->forge['smtp']	= array(
				'host'		=> $this->_config('email_smtp_host'),
				'port'		=> $this->_config('email_smtp_port')?:25,
				'username'	=> $this->_config('email_smtp_username'),
				'password'	=> $this->_config('email_smtp_password'),
				'timeout'	=> 5,
			);
			$this->forge['from'] = array('email'=>$this->_config('email_smtp_username'),'name'=>$this->_config('email_from_name'));
		}
		else{
			$this->forge['useragent'] = $this->_config('email_useragent');
			$this->forge['from'] = array('email'=>$this->_config('email_from'),'name'=>$this->_config('email_from_name'));
		}  
	 
	}
	
	function send($to=array(),$subject,$content,$attach=null){	  
		$email = \Email::forge($this->forge);  
		$email->subject($subject);
		$email->to($to); 
		$email->body($content);
		if($attach)
			$email->attach($attach);
		try
		{
		    $email->send();
		}
		catch(\EmailValidationFailedException $e)
		{
		    return false;
		}
		catch(\EmailSendingFailedException $e)
		{ 
		     return false;
		}
	 	 return true;
	}
	
	
	/**
	* 取得数据库config信息
	*/
	protected function _config($name){ 
		try
		{
			$data = \Cache::get('admin_config');
		}
		catch (\CacheNotFoundException $e)
		{ 
			$models = \Model_Config::find('all');
			foreach($models as $model){
				if(false!==strpos($model->name,'password')){ 
					 $model->val = \Crypt::decode($model->val, 'jE@I');
				}
				$data[$model->name] = $model->val; 
			} 
			\Cache::set('admin_config', $data);
		} 
		return $data[$name];
	}
	
	
}