<?php
$f = false;
$d = $this->cck_enable();
if($d==1)
	$f = true;
return  array(
	array('label'=>__('comm.content'),'url'=>\Uri::create('content/home/index')),
	array('label'=>__('comm.content type'),'url'=>\Uri::create('content/type/index'),'display'=>$f), 
 	array('label'=>__('comm.content type add'),'url'=>\Uri::create('content/type/add'),'display'=>$f), 
	array('label'=>__('comm.content form field'),'url'=>\Uri::create('content/form/index'),'display'=>$f), 
);