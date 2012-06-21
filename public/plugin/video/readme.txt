video play  
it needn't install .
use by yourself

demo:


<?php 
 $params = array('id'=>'player','video'=>$video->path,'img'=>null);
 echo \Vendor\Plugin::load('video',$params);
 ?>
 <div id='player'>JW Player goes here</div>