<?php 
if($posts){
?>
<p>
 
</p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.val'); ?></td>  
	<td><?php echo __('comm.sort'); ?></td>   
  </tr>
  <?php  
  foreach($posts as $post){ 
  ?>
  <tr>
	<td><?php echo $post->name; ?></td>
	<td><?php echo $post->val; ?></td>  
	 
	<td class='img_16'>
		<?php if($post->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('content/form/sort/'.$post->id.'/up'), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($post->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('content/form/sort/'.$post->id.'/down'), Asset::img('down.png')); ?>
		<?php }?>
	</td>  
	 
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>