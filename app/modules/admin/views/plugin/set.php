<button class="btn btn-success"><?php echo __('comm.plugin_name');?>: <?php echo $post->name;?></button>
<button class="btn ">	
<?php if($post->is_js==1){?> <?php echo __('comm.it is js plugin');?><?php }else{?>
	<?php echo __('comm.it is php plugin');?>
<?php }?>
</button>
<p><pre><?php echo $post->discription;?></pre></p>
	
	
<div class='block'>
<?php echo Form::open(array('class'=>'well form-vertical'));?> 
	<div class='row'> 
	<label><?php echo __('comm.html_element');?></label>
	<?php echo Form::input('html_element'); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.page');?></label>
	<?php echo Form::input('page'); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.params');?></label>
	<?php echo Form::textarea('params'); ?>
	</div>
	<p>
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset" ><?php echo __('comm.reset');?></button>
 	</p>
 
<?php echo Form::close();?>
</div>
	


<?php
if($posts){
?>

<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.html_element'); ?></td> 
	<td><?php echo __('comm.page'); ?></td> 
	<td><?php echo __('comm.params'); ?></td>
	<td><?php echo __('comm.action'); ?></td> 
 
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