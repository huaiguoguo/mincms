<?php
 
if($posts): 
 
?>
<table class="table table-striped table-bordered table-condensed">
  <tr>	
	<td><?php echo __('comm.name'); ?></td> 
	<td><?php echo __('comm.val'); ?></td> 
 	<td><?php echo __('comm.active'); ?></td>  
	<td><?php echo __('comm.action'); ?></td>
  </tr>
  <?php  
  foreach($posts as $post){   	  
  	  $id = Crypt::encode($post->id, $encode);
   ?>
  <tr>
  	<td><?php echo $post->name; ?></td>  
    <td><?php echo $post->val; ?></td>  
	<td>
		<a href="<?php echo Uri::create('admin/group/active/'.$post->id);?>">
			<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
		</a> 
	</td>   
	<td> 
	<?php echo \Html::anchor('admin/group/edit/'.$id, Asset::img('edit.png') );?>
	  &nbsp;
    <?php echo \Html::anchor('admin/group/bind/'.$id, Asset::img('preferences.png') );?>
	</td>
  </tr>
  <?php } ?>
</table> 

 
 

<?php
 
endif;
?>
<?php echo $pagination;?>