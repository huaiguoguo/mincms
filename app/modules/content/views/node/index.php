
<?php  
 
echo \Request::forge('views/home/column/'.$id)->execute();
echo \Request::forge('views/home/index/'.$id,false)->execute();
?>
 
 