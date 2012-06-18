<?php

namespace Vendor;
/**
 * 面包削导航
 * \Vendor\Breadcrumb::init();
 * array(
 * 　		array('label'=>'sss','url'=>'#','active'=>true)
 * )
 * 
 * @author : sun kange
 * @email: 68103403@qq.com
 *        
 */
class Breadcrumb {
	static $word = array (
		'divider'=>'<span class="divider">/</span>',
		'class'=>'breadcrumb',
		'active'=>'active'
	);
	static function init($array = array(), $url_auto = false) { 
		if(!is_array($array) || count($array)<1) return;
		$active_class = null;
		$arr = array_merge ( self::$word, $array ); 
		$cls = $arr ['class'];
		$divider = $arr ['divider'];
		$active = $arr ['active']; 
		$str = "<ul class='$cls'>"; 
		foreach ( $arr as $vo ) {
			if (is_array ( $vo )) { 
				$out[] = $vo;
			}
		}
		$n = count($out);
		$i = 1;
		foreach($out as $vo){
			$url = $vo ['url'];
			if ($url && true === $url_auto)
				$url = Uri::create ( $vo ['url'] );
			if ($url)
				$label = "<a href='" . $url . "'>".$vo['label']."</a>";
			else
				$label = $vo ['label'];
			if (array_key_exists('active',$vo))
				$active_class = "class=".$active;
			if($i>=$n) $divider = null;
			$str .= " <li  $active_class>" . $label . $divider . "</li>";
			$i++;
			
		}
		$str .= "</ul>";
		return $str;
	}

}