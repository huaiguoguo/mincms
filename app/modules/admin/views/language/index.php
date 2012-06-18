
<?php
echo $msg; 
if($posts){
?>
<p>
<!--<button class="btn btn-inverse" href="<?php echo \Uri::create('admin/language/upload');?>">
	<?php echo __('comm.upload language');?>
</button> -->
</p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.code'); ?></td>
	<td><?php echo __('comm.complete progress'); ?></td> 
	<td><?php echo __('comm.active'); ?></td> 
	<td><?php echo __('comm.default language'); ?></td> 
	<td><?php echo __('comm.action'); ?></td>
  </tr>
  <?php 

  foreach($posts as $post){ 
  $percent = (count($post->file)/$count)*100;
  ?>
  <tr>
	<td><?php echo $post->name; ?></td>
	<td><?php echo $post->code; ?></td> 
	<td> 
		<div class="progress">
		  <div class="bar"
			   style="width:<?php echo $percent;?>%;"></div>
		</div>  
	</td>
	<td>
	<a href="<?php echo Uri::create('admin/language/active/'.$post->id);?>">
		<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
	</a>
	
	</td> 
	<td>
	<?php if($post->default!=1){ ?>
	<a href="<?php echo Uri::create('admin/language/enable/'.$post->id);?>">
	<?php } ?>
	<?php echo $post->default==1?Asset::img('right.png'):Asset::img('error.png'); ?>
	<?php if($post->default!=1){ ?>
	</a>
	<?php } ?>
	
	</td> 

	<td>
	<?php if($max!=$post->code){ ?>
	<a href="<?php echo Uri::create('admin/language/cover/'.$post->code.'/'.$max);?>" 
		title="<?php echo $percent.' '. __('comm.cover to language'); ?>">
	<?php echo Asset::img('earth.png');?>
	</a> &nbsp;
	<?php } ?>
	<?php echo \Html::anchor('admin/language/edit/'.$post->id, Asset::img('edit.png') );?>
	<!--<span class='right'>
		<button class="btn btn-info" href="<?php echo \Uri::create('admin/language/backup/'.$post->id);?>"><?php echo __('comm.backup language');?></button> 
	</span>-->
	</td>
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>