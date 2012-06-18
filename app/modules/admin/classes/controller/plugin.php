<?php
namespace Admin;
/**
* tools 
* need auth,just admin has access. so use Controller_Base_Auth
* @auth: sun kang
* QQ or Mail : 68103403@qq.com 
*/
class Controller_Plugin extends \Controller_Base_Auth
{ 
	public $s;
	public $min;
	public $max;
	function before(){
		parent::before();
		 
		$this->menus['active_url'] = \Uri::create('admin/plugin/index');
 	}
 	/**
 	* @插件列表
 	*/
 	function action_index()
	{  
		$path = DOCROOT.'plugin';
		$list = scandir($path);
		foreach($list as $vo){   
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{ 
				$f = $path.'/'.$vo.'/'.$vo.'.php';
				include $f;
				$fun = "plugin_".$vo;
				$info = $fun::install();
				if(file_exists($f)){
					$file[] = array('cls'=>$fun,'name'=>$vo,'path'=>'plugin/'.$vo.'/'.$vo.'.php','info'=>$info);
					$ex[] = $vo;
				
				}
			} 
		}
		//移除已经不存在的插件
		if($ex){
			\DB::delete('plugin')->where('name', 'not in',$ex)->execute();
			$this->clear_all_cache();
		}
	 
		foreach($file as $vo){
				unset($css_new,$css,$js,$js_new,$code,$op,$op_html);
				$post = \Model_Plugin::find('first',array('where'=>array('name'=>$vo['name'])));
				if(!$post)
			 	$post = new \Model_Plugin; 
				$post->name = $vo['name'];
				$post->path = $vo['path'];
				$post->discription = $vo['info']['discription'];
				$post->web = $vo['info']['web'];
				$post->auth = $vo['info']['auth']; 
				
				$css = $vo['info']['css'];
				$op_html = $vo['info']['html'];
				if($op_html)
					$op['html'] = $op_html;
				if($css){
					foreach($css as $v){
						$css_new[] = 'plugin/'.$vo['name'].'/'.$v;
					}
					$op['css'] = $css_new;
				}
				$js = $vo['info']['js'];
				if($js){
					foreach($js as $v){
						$js_new[] = 'plugin/'.$vo['name'].'/'.$v;
					}
					$op['js'] = $js_new;
				}
				$code = $vo['info']['code'];
				if($code)
					$op['code'] = $code; 
			  
				if($op)
					$post->options = serialize($op);
				$post->save();
				if(!$post->id)
					$post->sort = $post->id;
				$is = 1;
				if($vo['info']['is_php'])
					$is = 0;
				$post->is_js = $is;
				$post->save();
			 
		} 
	 	$this->min = \Model_Plugin::min('sort');
		$this->max = \Model_Plugin::max('sort');
  
		$posts = \Model_Plugin::find('all');
		$view = \View::forge('plugin/index');
		$view->set('posts',$posts);
		$view->set('min',$this->min);
		$view->set('max',$this->max);
		$this->template->content = $view; 
	}

	/**
	* @启用或禁用插件
	*/
	function action_active($id){ 
		$post = \Model_Plugin::find($id); 
		if($post->active==1)
			$post->active = 0;
		else
			$post->active = 1;
		$this->clear_all_cache();
		if($post->save())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/plugin/index'));
		} 
	}
	
	/**
	* @删除插件配置
	*/
	function action_del($id,$fid){ 
		$post = \Model_Plugin_Set::find($id);  
		$this->clear_all_cache(); 
		if($post->delete())
		{ 
			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/plugin/set/'.$fid));
		} 
	}
	/**
	*
	* @插件排序
	*/
	function action_sort($id,$s='up'){
		$this->_sort($id,$s,'\Model_Plugin');
		\Session::set_flash('success', __('comm.save success'));
		\Response::redirect(\Uri::create('admin/plugin/index')); 
	}
	/**
	* @插件配置 
	*/
	function action_edit($id){
		$post = \Model_Plugin_Set::find($id); 
		$view = \View::forge('plugin/edit');
		if($_POST){
 			extract($_POST);   
			$post->html_element = $html_element; 
			$post->page = $page;
			$post->params = $params;
			$post->save(); 	 
			$this->clear_all_cache();
 			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/plugin/set/'.$post->plugin->id)); 
 		
 		}
 		
		$view->set('id',$id);
 		$view->set('post',$post); 
 		$this->template->content = $view;
	}
 	/**
 	* @插件配置列表
 	*/
 	function action_set($id){
 		$post = \Model_Plugin::find($id); 
 		$posts = \Model_Plugin_Set::find('all',array('where'=>array('plugin_id'=>$id))); 
 		$view = \View::forge('plugin/set');
 		if($_POST){
 			extract($_POST); 
 			$model = \Model_Plugin_Set::find('first',array('where'=>array('plugin_id'=>$id,'html_element'=>$html_element)));
 			if(!$model){ 		
 				$model = new \Model_Plugin_Set;
 				$model->plugin_id = $id;
 				$model->html_element = $html_element; 
 				$model->page = $page;
 				$model->params = $params;
 				$model->save(); 	
 				$this->clear_all_cache();		
 			}
 			\Session::set_flash('success', __('comm.save success'));
			\Response::redirect(\Uri::create('admin/plugin/set/'.$id)); 
 		
 		}
 		$view->set('id',$id);
 		$view->set('post',$post);
 		$view->set('posts',$posts);
 		$this->template->content = $view;
 	}
 
	
 	
  
}
