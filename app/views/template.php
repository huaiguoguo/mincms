<!DOCTYPE html>
	<html>
	<head>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title;?></title>
		<meta name="description" content="<?php echo $page_out['seo'];?>" />
		<meta name="keywords" content="<?php echo $page_out['seo'];?>" />
		<meta name="author" content="<?php echo $page_out['seo_author'];?>" />
		<meta name="Copyright" content="<?php echo $page_out['seo_copyright'];?>" /> 
<?php 
 
Casset::css('bootstrap.min.css'); 
Casset::css('awesome/css/font-awesome.css'); 
Casset::css('../../theme/default/index.css'); 

Casset::js('jquery.min.js'); 
Casset::js('jquery.masonry.min.js');  
Casset::js('../../theme/default/index.js'); 
echo Casset::render_css();
echo Casset::render_js();
//调用插件
//echo \Vendor\Plugin::init();
/**
$js = <<<EOF
    var foo = "$bar";
EOF;
*/
echo Casset::render_js_inline();
?>
<!--[if lt IE 8]><link rel="stylesheet" href="<?php echo \Uri::base(false);?>/assets/css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]--> 

<style type="text/css" media="screen">
 body {
padding-top: 30px;  
}
  p, table, hr, .box { margin-bottom:25px; }
  .box p { margin-bottom:10px; }
  .nav{padding:0;}
</style>
 
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
 
	</head>

	<body>
		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container"> 
	         
	            <ul class="nav">
	              <li class="active"><a href="#">Home</a></li>
	              <li><a href="#about">About</a></li>
	              <li><a href="#contact">Contact</a></li>
	            </ul>
	          
	        </div>
	      </div>
	    </div>
	    	
		<div class="container" id="page"> 
			<div id='top'>
				<img src='http://www.nutritionix.com/images/logo_sm.png' />
				<form action="" class='right'>
					<input type="text" class="input-medium search-query">
				    <button type="submit" class="btn">Search</button>
	  			</form>
  			</div>
			<?php if(isset($messages)): ?>
				<div class="message"> 
					<?php echo  $messages;?>			 
				</div>
			<?php endif; ?>
			<?php if(Session::get_flash('error')){?> 
				<div class='alert alert-error'><?php echo Session::get_flash('error');?></div>
			<?php }?>
			<?php if(Session::get_flash('success')){?> 
				<div class='alert alert-success'><?php echo Session::get_flash('success');?></div>
			<?php }?>  
  
 
			<div id='content'>
				<?php echo $content; ?>
				</div>
		</div>
		<?php echo $page_out['stat'];?>
		<?php echo $page_out['footer'];?>
	</body>
	</html>