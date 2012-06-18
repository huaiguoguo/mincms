<?php namespace Vendor;
/**
* 时间
* @author: SUN 
* @email: 68103403@qq.com
*/
class Date{
 
	/**
	 * 
	 * 将 yyyy-mm-dd::hh:00:00 转成时间戳
	 * @param unknown_type $d
	 */
	static function totime($d){
		$d = str_replace('::',' ',$d);
		return  strtotime($d);
	}
	static function today ($time=null)
	{
		if(!$time) $time = time();
		$str = strftime('%w',$time); 
		$d = $this->week_d($str);
		return $d;
	}
	//计算星期几
	static function week($i){
		switch ( $i )
		{
			case 0:
				$d = '星期日';
				break;
			case 1:
				$d = '星期一';
				break;
			case 2:
				$d = '星期二';
				break;
			case 3:
				$d = '星期三';
				break;
			case 4:
				$d = '星期四';
				break;
			case 5:
				$d = '星期五';
				break;
			case 6:
				$d = '星期六';
				break; 
			 
		}
		return $d;
	}
	static function ago($time, $since=null)
	{
		$patterns = array(
				'seconds'   => t('less than a minute'),
				'minute'        => t('about a minute'),
				'minutes'   => t('%d minutes'),
				'hour'          => t('about an hour'),
				'hours'         => t('about %d hours'),
				'day'           => t('a day'),
				'days'          => t('%d days'),
				'month'         => t('about a month'),
				'months'        => t('%d months'),
				'year'          => t('about a year'),
				'years'         => t('%d years'),
		);
		if($since===null)
				$since=time();
		if(!is_int($since) && !ctype_digit($time))
				$since = strtotime($since);
		if(!is_int($time) && !ctype_digit($time))
				$time = strtotime($time);
		$seconds = abs($since - $time);
		$minutes = $seconds/60;
		$hours = $minutes/60;
		$days = $hours/24;
		$weeks = $days/7;
		$months = $days/30;
		$years = $days/365; 
		if($seconds < 45)
				$words = $patterns['seconds'];
		else if($seconds < 90)
				$words = $patterns['minute'];
		else if($minutes < 45)
				$words = sprintf($patterns['minutes'], $minutes);
		else if($minutes < 90)
				$words = $patterns['hour'];
		else if($hours < 24)
				$words = sprintf($patterns['hours'], $hours);
		else if($hours < 48)
				$words = $patterns['day'];
		else if($days < 30)
				$words = sprintf($patterns['days'], $days);
		else if($days < 60)
				$words = $patterns['month'];
		else if($days < 365)
				$words = sprintf($patterns['months'], $months);
		else if($years < 2)
				$words = $patterns['year'];
		else
				$words = sprintf($patterns['years'], $years);
		$suffix = $since - $time > 0 ?  t('ago') : t('from now');
	 
		return $words.$suffix;
		 
	}


	
	

}