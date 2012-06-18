<?php
 
if($posts): 
 
?>
<table class="table table-striped table-bordered table-condensed">
  <tr>	
    <td><?php echo __('comm.username'); ?></td>
	<td><?php echo __('comm.email'); ?></td>
	
	<td><?php echo __('comm.group'); ?></td>
 	<td><?php echo __('comm.active'); ?></td>  
	<td><?php echo __('comm.action'); ?></td>
  </tr>
  <?php  
  foreach($posts as $post){   	  
  	  $id = Crypt::encode($post->id, $encode);
   ?>
  <tr>
  	<td><?php echo $post->username; ?></td> 
  	<td><?php echo $post->email; ?></td>  
	
	<td><?php echo $post->groups->name; ?>
	<?php echo \Html::anchor('admin/group/bind/'.\Crypt::encode($post->groups->id, 'R@nd0mK~Y').'/'.\Crypt::encode($post->id, 'R@nd0mK~Y'), Asset::img('group.png') );?>
	</td> 
	<td>
	<a href="<?php echo Uri::create('admin/user/active/'.$id);?>">
		<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
	</a>
	
	</td>   
	<td>
 
	<?php echo \Html::anchor('admin/user/edit/'.$id, Asset::img('edit.png') );?>
 
	 
	
	</td>
  </tr>
  <?php } ?>
</table> 

 
 

<?php
 
endif;
?>
<?php echo $pagination;?>