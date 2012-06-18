<?php
 
if($posts): 
?>

<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.display'); ?></td>
	<td><?php echo __('comm.language'); ?></td>
	<td><?php echo __('comm.create_time'); ?></td>
	<td><?php echo __('comm.action'); ?></td>
  </tr>
  <?php foreach($posts as $post):?>
  <tr>
	<td><?php echo $post->name; ?></td>
	<td><?php echo $post->out; ?></td>
	<td><?php echo $post->language->name; ?></td>
	<td><?php echo date('Y-m-d H:i',$post->create_at); ?></td>
	<td><?php echo \Html::anchor('admin/translate/edit/'.$post->id, __('comm.edit'));?></td>
  </tr>
  <?php endforeach; ?>
</table> 

<?php endif;?>

<?php echo $pagination;?>