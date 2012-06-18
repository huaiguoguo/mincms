<?php 
if($posts){
?>
<p>
 
</p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>	
	<td><?php echo __('comm.action'); ?></td>	
  </tr>
  <?php  
  foreach($posts as $post){ 
  ?>
  <tr>
	<td><?php echo $post->name; ?></td>
	<td> 
	 <a class="btn btn-primary" href="<?php echo \Uri::create('content/node/do/'.$post->id);?> ">
	 	<i class="icon-plus-sign icon-white"></i> <?php echo __('comm.add');?>
	</a>  
	<a class="btn btn-small" href="<?php echo \Uri::create('content/node/index/'.$post->id);?> ">
	 	<i class="icon-list-alt"></i> <?php echo __('comm.lists');?>
	</a>
 
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>