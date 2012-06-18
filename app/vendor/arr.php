<?php 
namespace Vendor;
/**
* 数组处理
* @author: SUN 
* @email: 68103403@qq.com
*/
class Arr{
	/**
	*
	* 将数组转成字符串
	array('a'=>'b')
	a='b'
	*/
	static function to_string($arr){
		$i=0;
		foreach($arr as $k=>$v){
			$s .=$k.'='."\"".$v."\"";
			$i++;
		}
		return $s;
	}
	static function new_array_combine($a,$b){ 
		 $i=0;
		 foreach($a as $k){
			  $rt[$k] = $b[$i];
			  $i++;
		 }
		 return $rt;
	}
	 /**
	 * 将二维数组以某个key的值做group分组
	 * 返回一个新的数组
	 */
	 function group($arr=array(),$key){
	 	 foreach($arr as $v){
	 	 	$new[$v[$key]][] = $v;
	 	 }
	 	 return $new; 
	 }
	 /**
	 * 
	 * 数组排序
	 * 使用方法 array_orderby($row,$order,SORT_DESC);
	 */
	function array_orderby() {
		$args = func_get_args ();
		$data = array_shift ( $args );
		foreach ( $args as $n => $field ) {
			if (is_string ( $field )) {
				$tmp = array ();
				if(!$data) return;
				foreach ( $data as $key => $row )
					$tmp [$key] = $row [$field];
				$args [$n] = $tmp;
			}
		}
		$args [] = &$data;
		if($args){
			call_user_func_array ( 'array_multisort', $args );
			return array_pop ( $args );
		}
		return;
	}



	 /**
	 * 所多维数组 转成一维数组
	 *
	 * @param unknown_type $array
	 * @return unknown
	 */
	function array_values_one($array)
	{
		$arrayValues = array();
		$i = 0;
		foreach ($array as $key=>$value)
		{
			if (is_scalar($value) or is_resource($value))
			{
				$arrayValues[$key] =$span.$value;
			}
			elseif (is_array($value))
			{

				$arrayValues = array_merge($arrayValues, self::array_values_one($value));
			}
		}

		return $arrayValues;
	}

	 
	
}