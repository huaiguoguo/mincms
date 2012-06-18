<p><a href="<?php echo \Uri::create('admin/cache/clear');?>"><button class="btn btn-success"><?php echo __('comm.clear all cache');?></button></a></p>

<?php
 
if($posts):  
?>
<table class="table table-striped table-bordered table-condensed">
  <tr>	
    <td><?php echo __('comm.cache_id'); ?></td>
 
	<td><?php echo __('comm.action'); ?></td>
  </tr>
  <?php  
  foreach($posts as $post){   	  
  	 
   ?>
  <tr>
  	<td><?php echo $post->cache_id; ?></td>  
	<td> 
	<?php echo \Html::anchor('admin/cache/del/'.$post->id, Asset::img('error.png') );?> 
	</td>
  </tr>
  <?php } ?>
</table> 

 
 

<?php
 
endif;
?>
<?php echo $pagination;?>