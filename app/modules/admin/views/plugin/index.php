
<?php
if($posts){
?>

<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.code'); ?></td>  
	<td><?php echo __('comm.website'); ?></td>
	<td><?php echo __('comm.active'); ?></td> 
	<td><?php echo __('comm.sort'); ?></td> 
	<td><?php echo __('comm.setting'); ?></td> 
  </tr>
  <?php  
  foreach($posts as $post){ 
   
  ?>
  <tr>
	<td><?php echo $post->name; ?></td>
	<td><?php echo $post->discription; ?></td>   
	<td><?php echo $post->web; ?></td>  
	<td>
	<a href="<?php echo Uri::create('admin/plugin/active/'.$post->id);?>">
		<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
	</a> 
	</td> 
	<td class='img_16'>
		<?php if($post->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('admin/plugin/sort/'.$post->id.'/up'), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($post->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('admin/plugin/sort/'.$post->id.'/down'), Asset::img('down.png')); ?>
		<?php }?>
	</td>  
	<td> 
		<?php if($post->active == 1){?>
			<?php echo Html::anchor(\Uri::create('admin/plugin/set/'.$post->id), Asset::img('preferences.png'),array('rel'=>'facybox')); ?>	
		<?php }else{?>
			<span class='btn btn-danger'><?php echo __('comm.pls active plugin first');?></span>
		<?php }?>
	</td>  
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>