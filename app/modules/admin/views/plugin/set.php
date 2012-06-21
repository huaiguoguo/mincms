<button class="btn btn-success"><?php echo __('comm.plugin_name');?>: <?php echo $post->name;?></button>
<button class="btn ">	
<?php if($post->is_js==1){?> <?php echo __('comm.it is js plugin');?><?php }else{?>
	<?php echo __('comm.it is php plugin');?>
<?php }?>
</button>
<p><pre><?php echo $post->discription;?></pre></p>
	
<?php   
	$type = $post->type;
 
	echo \View::forge('plugin/form',array('post'=>$post,'type'=>$type,'edit'=>false));?>
 
	


<?php
if($posts){
?>

<table class="table table-striped table-bordered table-condensed">
  <tr>
    <?php if($type=='content' || $type=='cck' ){?>
		<td><?php echo __('comm.filed'); ?></td> 
		<td><?php echo __('comm.content type'); ?></td> 
		<td><?php echo __('comm.params'); ?></td>
		<td><?php echo __('comm.action'); ?></td> 
 	<?php }else{?>
 		<td><?php echo __('comm.html_element'); ?></td> 
		<td><?php echo __('comm.page'); ?></td> 
		<td><?php echo __('comm.params'); ?></td>
		<td><?php echo __('comm.action'); ?></td> 
 	<?php }?>
  </tr>
  <?php  
  foreach($posts as $post){ 
   
  ?>
  <tr>
	<td><?php echo $post->html_element; ?></td> 
	<td><?php echo $post->page; ?></td>  
	<td><?php echo $post->params; ?></td>  
	 
	<td class='img_16'> 
		<?php echo \Html::anchor('admin/plugin/edit/'.$post->id.'/'.$id, Asset::img('edit.png') );?> &nbsp;
		<?php echo \Html::anchor('admin/plugin/del/'.$post->id.'/'.$id, Asset::img('error.png') ,array(
			'onclick'=>"return confirm('".__('comm.do you confirm delete')."');"
		));?> 
	</td>  
 
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>