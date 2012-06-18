<?php
namespace Admin;
/**
*  
* use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Acl extends \Controller_Base_Auth
{ 
	public $s;
	function before(){
		parent::before();
		$this->menus = $this->auth_links;
		$this->menus['active_url'] = \Uri::create('admin/user/index');  
 	}
 	/**
 	* @ACL权限首页
 	*/
 	function action_index(){ 		
 		$url = \Uri::create('admin/user/index'); 
		$view = \View::forge('acl/index');
		$posts = \Model_Controller::find('all');
		$view->set('posts',$posts);
		$this->template->content = $view;
		 
 	}
  	/**
  	* @加载所有控制器及动作至ACL
  	*/
  	function action_do(){
  		$this->run();
  		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('admin/acl/index'));
  	}
 	protected function run()
	{ 
		$lists = $this->_get_modules(); 
		//移除已不存在的控制器 动作
		foreach($lists as $controller=>$vo){
			$controllers[] = $controller;
		}
		$cs = \DB::select('id','val')->from('role_controller')
					->execute()->as_array(); 
		foreach($cs as $v){
			$comp[] = $v['val'];
		}
		if(!$comp) goto next;
		$remove = array_diff($comp,$controllers);
		//$adds = array_diff($controllers,$comp);
		if($remove){
			foreach($remove as $vo){
				$post = \Model_Controller::find('first',array('where'=>array(
						'val'=>$vo,
				)));
				if($post){
					\DB::delete('role_action')->where('controller_id',$post->id)
					->execute();
				}
				$post->delete(); 
			} 
		} 
		next:
		//控制器 动作入库，且不重复
		foreach($lists as $controller=>$vo){ 
			$mo = \Model_Controller::find('first',array('where'=>array(
					'val'=>$controller,
			)));
			$id = $mo->id;
			if(!$id){
				$r = \DB::insert('role_controller')
					->set(array(
						'name'=>$controller,
						'val'=>$controller,
					))
					->execute();
				$id = $r[0];
			}
			if(!$id) continue;
			foreach($vo as $v){
				$model = \Model_Action::find('first',array('where'=>array(
						'controller_id'=>$id, 
						'val'=>$v[1],
				)));
			 	if(!$model){
					\DB::insert('role_action')->set(array(
							'controller_id'=>$id,
							'name'=>$v[0],
							'val'=>$v[1],
						))->execute();
				}
			}
		}
		
		
	}
	
	/**
	* 使用反射取得注释信息
	*/
	protected function _get_modules(){
		$p = APPPATH.'modules/';
		$lists = \Vendor\Dir::listFile($p,'controller,.php');
		$dirs = $lists['dir'];   
		foreach($dirs as $dir){
			if ($handle = fopen($dir,'r')) { 
				while (!feof ($handle)) { 
					$file_content = fgets($handle);
					$check = trim($file_content);
					$arrs = explode(' ',$check); 
					foreach ($arrs as $arr)
					{  
						if(substr(trim($arr),0,6)=='action' && trim($arr)!='actions()' 
							&& trim($arr)!='actions.' && trim($arr)!='actions:' ){ 
							$key = substr($dir,0,-4); 
							$name = str_replace($p,'',$key);
							$namespace = ucfirst(substr($name,0,strpos($name,'/'))); 
							$cls ='\\'.$namespace."\Controller_";   
							$cls .= ucfirst(substr($key,strrpos($key,'/')+1)); 
							$key = str_replace(APPPATH,'',$key);
							$key = str_replace('/modules/','',$key);
							$key = str_replace('/controllers/','_',$key);   
							$action =  str_replace('(','',$arr);
							$action =  str_replace(')','',$action);
							$action =  str_replace('{','',$action); 
							$len = strpos($action,'$');
							if($len>0)
								$action = substr($action,0,$len); 
							 
							@include_once($dir);
							$mark = false;  
							if ($hand = fopen($dir,'r')) {
								while (!feof ($hand)) {
									$cont = fgets($hand);
									$rg = '/\s+extends\s(.*?)\s+/i';
									preg_match($rg,$cont,$out);
									if(false!==strpos(trim($out[1]),'Controller_Base_Auth')) {
										$mark = true;
										goto c;
									}
								}
							 } 
							 @closedir($hand);
						 	 c:
						 	 if($mark!=true) continue;
							//使用反射取得注释信息
							$r=new \ReflectionMethod($cls,$action);
							$doc = $r->getDocComment(); 
							$rg = '/\s+@\s(.*?)\s+/i';
							preg_match($rg,$doc,$note);
							$note = str_replace('#','',$note); 
							if(!$note){
								$rg = '/\s+@(.*?)\s+/i';
								preg_match($rg,$doc,$note);
								$note = str_replace('#','',$note); 
							} 
							$cls = substr($cls,1); 
							$new_arr[$cls][] = array($note[1],$action); 
						}
					}
				}
				@closedir($handle);
			}
			
		} 
		return $new_arr; 
	}
 	 
	
	
 	
  
}
