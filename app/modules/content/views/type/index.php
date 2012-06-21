<p><a href="<?php echo \Uri::create('content/type/g');?>"><button class="btn"><?php echo __('comm.generate models');?></button></a></p>

<?php 
if($posts){
?>
<p>
 
</p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.val'); ?></td> 
	<td><?php echo __('comm.active'); ?></td>  
	<td><?php echo __('comm.sort'); ?></td> 
	<td><?php echo __('comm.action'); ?></td>
	
  </tr>
  <?php  
  foreach($posts as $post){ 
  ?>
  <tr>
	<td><?php echo $post->name; ?></td>
	<td><?php echo $post->val; ?></td> 
	 
	<td>
	<a href="<?php echo Uri::create('content/type/active/'.$post->id);?>">
		<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
	</a>
	
	</td>  
	<td class='img_16'>
		<?php if($post->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('content/type/sort/'.$post->id.'/down'), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($post->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('content/type/sort/'.$post->id.'/up'), Asset::img('down.png')); ?>
		<?php }?>
	</td>  
	<td> 
	 
	<a class="btn btn-primary" href="<?php echo \Uri::create('content/type/edit/'.$post->id);?> ">
	  	<i class="icon-edit icon-white"></i>
	    <?php echo __('comm.edit');?>
	</a>
	<a class="btn btn-small" href="<?php echo \Uri::create('content/field/index/'.$post->id);?> ">
	 	<i class="icon-cog"></i> <?php echo __('comm.field mange');?>
	</a>		
	<a class="btn btn-danger" href="<?php echo \Uri::create('content/type/remove/'.$post->id);?>" 
			onclick="return confirm('<?php echo __('comm.could you want to remove this content type');?>');">
		<i class="icon-trash icon-white"></i> 
		<?php echo __('comm.delete content type');?>
	</a>
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>