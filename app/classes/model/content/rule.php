<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Content_Rule extends \Orm\Model
{
	protected static $_table_name = 'content_rule';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_observers = array( 
        'Orm\\Observer_Self' => array(
            'before_save',
            'after_load',
        ),
    );
   	public function _event_before_save(){  
   		if($this->rules)  
        	$this->rules = json_encode($this->rules); 
    }

    public function _event_after_load(){  
        if($this->rules){  
        	$this->rules = json_decode($this->rules,true);
        	if(!is_array($this->rules))
        		$this->rules = json_decode($this->rules,true);
        }
        
    } 
	 
}