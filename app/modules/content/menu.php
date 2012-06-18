<?php
return  array(
	array('label'=>__('comm.content'),'url'=>\Uri::create('content/home/index')),
	array('label'=>__('comm.content type'),'url'=>\Uri::create('content/type/index'),'display'=>$this->cck_enable()), 
 	array('label'=>__('comm.content type add'),'url'=>\Uri::create('content/type/add'),'display'=>$this->cck_enable()), 
	array('label'=>__('comm.content form field'),'url'=>\Uri::create('content/form/index'),'display'=>$this->cck_enable()), 
);