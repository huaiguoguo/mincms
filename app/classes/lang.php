<?php
class Lang extends Fuel\Core\Lang {
	
	public static function get($line, array $params = array(), $default = null)
	{ 
		 
		$s = \Str::tr(\Fuel::value(\Arr::get(static::$lines, $line, $default)), $params); 
	 	if(!$s){
	 		$a = explode('.',$line);
	 		$s = $a[1];
	 	}
	 	return $s;
	}
}
