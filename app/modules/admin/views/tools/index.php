
<?php
if($posts){
?>

<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.code'); ?></td> 
	<td><?php echo __('comm.author'); ?></td> 
	<td><?php echo __('comm.im'); ?></td>
	<td><?php echo __('comm.active'); ?></td> 
	<td><?php echo __('comm.sort'); ?></td> 
  </tr>
  <?php  
  foreach($posts as $post){ 
   
  ?>
  <tr>
	<td><?php echo $post->label; ?></td>
	<td><?php echo $post->url; ?></td>  
	<td><?php echo $post->author; ?></td>  
	<td><?php echo $post->im; ?></td>  
	<td>
	<a href="<?php echo Uri::create('admin/tools/active/'.$post->id);?>">
		<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
	</a> 
	</td> 
	<td class='img_16'>
		<?php if($post->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('admin/tools/sort/'.$post->id.'/up'), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($post->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('admin/tools/sort/'.$post->id.'/down'), Asset::img('down.png')); ?>
		<?php }?>
	</td>  
	 
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>