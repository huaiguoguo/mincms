<?php
/**
* core model
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Model_Content_Field extends \Orm\Model
{
	public $options_array;
	protected static $_table_name = 'content_fields';
	protected static $_primary_key = array('id');
	protected static $_properties = array(); 
	protected static $_belongs_to = array(
	    'type' => array(
	        'key_from' => 'type_id',
	        'model_to' => 'Model_Content_Form',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
	    'form' => array(
	        'key_from' => 'form_id',
	        'model_to' => 'Model_Content_Form',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
	    'view' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Views',
	        'key_to' => 'field_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
	);
	protected static $_has_one = array(
	    'rule' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Content_Rule',
	        'key_to' => 'field_id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);
	protected static $_observers = array( 
        'Orm\\Observer_Self' => array(
            'before_save',
            'after_load',
        ),
    );
   	public function _event_before_save(){    
   		if($this->options)
        	$this->options = json_encode($this->options);
         
    }

    public function _event_after_load(){  
    	 
    	if($this->options){  
        	$this->options = json_decode($this->options,true);
        	if(!is_array($this->options))
        		$this->options = json_decode($this->options,true);
        }
        
    }

	 
}