<?php
namespace Vendor;
/**
* core file
* hook model for content model
*/
class Model extends \Orm\Model{
	static $_hooks;
	public function _event_before_save(){  
		self::hook($this,'before_save'); 
    }

    public function _event_after_save(){  
    	self::hook($this,'after_save'); 
    } 
		
	static function hook($obj,$event){
	 	$cls = get_class ($obj);
	 	$cls = strtolower($cls);
	 	$cls = str_replace('\\','',$cls);
	 	$cls = str_replace('model_','',$cls);
	 	$f = APPPATH.'/hooks/'.$cls.'.php';
	 	if(file_exists($f)){
	 		if(!self::$_hooks[$class]){
	 			include $f;
	 			self::$_hooks[$class] = true;
	 		}
	 		$class = 'hook_'.$cls;
	 		
	 		if(!class_exists($class)) goto end;
	 		if(method_exists(new $class,$event)){
	 			$class::$event($obj);
	 		}
	 		
	 	}
	 	end: 
	}
	 protected static $_observers = array( 
        'Orm\\Observer_Self' => array(
            'before_save',
            'after_save',
        ),
    );
     

}