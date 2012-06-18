<?php
/*
* front controller
* Ç°¶Ë¿ØÖÆÆ÷
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
* @date: 2012-5
*/
 
class Controller_Base_Home extends \Controller_Base_Public
{
	 
 	public function before() {
 		parent::before(); 
		// website close 
 		if($this->_config('open') == 2){ 
			throw new HttpNotFoundException;
		}

		$this->page_title = $this->_config('title'); 
		$this->page_out = array(
			'stat'=>$this->_config('stat'),
			'footer'=>$this->_config('footer'),
			'seo'=>$this->_config('seo'),	
			'seo_author'=>$this->_config('seo_author'),
			'seo_copyright'=>$this->_config('seo_copyright'),
		);
		if($this->_config('url_suffix')){
			Config::set('url_suffix',$this->_config('url_suffix'));
		}
		if($this->_config('caching')==1){ 
			Config::set('caching',true);
		}
		if((int)$this->_config('cache_lifetime')>1){ 
			Config::set('cache_lifetime',(int)$this->_config('cache_lifetime'));
		}
		if($this->_config('profiling')==1){ 
			Config::set('profiling',true);
		}
		 
 	}
   
    


}
