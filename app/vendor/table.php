<?php
namespace Vendor;
/**
*  
* table
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
/**
* \Vendor\Table::create();
*/
class Table{ 
	static $pre='auto_';
	public $forge;
	static function create($table){
		if(!$table) return false;
		$table = self::$pre.$table;
		if(\DBUtil::table_exists($table)){
			
		} else {
			\DBUtil::create_table(
			    $table,
			    array(
			        'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			        'sort' => array('type' => 'int'),
			        'create_at' => array('type' => 'int'),
			        'update_at' => array('type' => 'int'),
			    	'active' => array('type' => 'TINYINT','constraint' => 1),
			    				       
			    ),
			    array('id'), false, 'MyISAM', 'utf8_unicode_ci'
			); 
		} 
	}
	static function rename($old,$table){
		if(!$table || !$old) return false; 
		 
		if(\DBUtil::table_exists($table)){
			$table = self::$pre.$table;
			DBUtil::rename_table($old,$table);
		} 
		else{
			self::create($table);
		}
		 
	}
	
	static function add($table,$array){
		$table = self::$pre.$table;
		$ext = self::_re_array($array);
		 
		if(!\DBUtil::field_exists($table, array($ext))){
            \DBUtil::add_fields($table, $array);
        }  
		
	}
	
	static function _re_array($a){
		foreach($a as $k=>$v){
			$o[] = $k;
		}
		return $o;
	}
	static function edit($table,$array){
		$table = self::$pre.$table;
		\DBUtil::modify_fields($table, $array);
	}
	static function del($table,$f){
		$table = self::$pre.$table;
		if(\DBUtil::field_exists($table, array($f))){               
			\DBUtil::drop_fields($table,$f);
        }  
        
	
	}
	static function model_name($name){
		return "Model_".ucfirst(self::$pre).ucfirst($name);
	}
	
	
	 
	
	
}