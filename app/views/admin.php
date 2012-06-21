<!DOCTYPE html>
	<html>
	<head>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title;?></title>
	    <?php  
		Casset::css('bootstrap.min.css');
		Casset::css('bootstrap-responsive.min.css');
		Casset::css('pagination.css');
		Casset::css('admin.css'); 
		
		Casset::js('jquery.min.js'); 
		Casset::js('bootstrap.min.js'); 
		Casset::js('my.tab.js'); 
		Casset::js('jquery.jeditable.mini.js'); 
		Casset::js('admin.js');  
		
		//合并输出css js	 	
		echo Casset::render_css();
		echo Casset::render_js();	
		
		$c = strtolower(\Request::active()->controller);
		$controller = str_replace('\\','_',$c);

		
	
	   ?> 
 <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
	  label{
	  	float: left;
	  }
    </style>
	</head>

	<body id="<?php echo $controller;?>" >
		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="<?php echo Uri::create('welcome/index');?>">
	    	<?php echo $page_out['admin_title'];?>
	    	</a>
			<?php 
			$menu_link = '			 
			  <li class="dropdown" id="menu1" >
				<a class="dropdown-toggle" data-toggle="dropdown" href="'.Uri::create('admin/module/index').'">
				  '.__('comm.modules').'
				  <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				  <li><a href="#">Action</a></li> 
				</ul>
			  </li> 
			 ';
			?>

	    	  <?php if(\Auth::check()){?>
	          <div class="nav-collapse">
			  	<?php 
				$droplink = '<a>'.Uri::create('admin/module/index').__('comm.modules')."</a>";
				$user = Auth::instance()->get_user_array();		
				$img = Html::img(\Vendor\Gravatar::init($user['email'],20),array('title'=>'http://www.gravatar.com')); 
				$top = array(
					array('label'=>__('comm.home'),'url'=>Uri::create('admin/home/index')), 
					array('label'=>__('comm.content'),'url'=>Uri::create('content/home/index')),
					array('label'=>__('comm.user'),'url'=>Uri::create('admin/user/index')),
					array('label'=>__('comm.plugin'),'url'=>Uri::create('admin/plugin/index')), 
					'html'=>$menu_link,
					array('label'=>__('comm.tools'),'url'=>Uri::create('admin/tools/index')),
					array('label'=>__('comm.config'),'url'=>Uri::create('admin/config/index')),
					array('label'=>__('comm.language'),'url'=>Uri::create('admin/translate/index')),
					
				);
				$top2 = array(
					array('label'=>$img,'url'=>\Uri::create('admin/user/profile')),
					array('label'=>__('comm.logout'),'url'=>Uri::create('admin/logout/index'),'options'=>array('onclick'=>"return confirm('".__('comm.will logout')."?');")),
				 
				);
				$top = array_merge($top,$top2);
			 	$top['active_url'] = $menus['active_url'];
				echo \Vendor\Menu::init($top,'nav nav-pills',true); 
				?>
			  <a href="<?php echo \Uri::base(false);?>" target='_blank' class='fx'>
	          <button type="button" class="btn  btn-success" >
	          		<?php echo __('comm.view web');?>
	          </button>  </a>
	          </div><!--/.nav-collapse -->
	          <?php }?>
	        </div>
	      </div>
	    </div>


		<div  class="container"> 
			<!--menus-->
			<div class="subnav">
				<?php echo \Vendor\Menu::init($menus);?>
			</div>
		 	<?php  //面包屑
		 		echo \Vendor\Breadcrumb::init($breadcrumb);
		 	?> 
        		
			<?php if(isset($messages) && $messages): ?>
				<div class="alert alert-error"> 
					<?php echo  $messages;?>			 
				</div>
			<?php endif; ?>
			<?php if(Session::get_flash('error')){?> 
				<div class='alert alert-error'><?php echo Session::get_flash('error');?></div>
			<?php }?>
			<?php if(Session::get_flash('success')){?> 
				<div class='alert alert-success'><?php echo Session::get_flash('success');?></div>
			<?php }?>
			 
			<?php echo $hooks; ?>
			<?php echo $content; ?>
		</div>
		<?php 
		//调用插件
		echo \Vendor\Plugin::init();
		?>
	</body>
	</html>