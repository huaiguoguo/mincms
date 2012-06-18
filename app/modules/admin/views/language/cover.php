<?php 
if($models){
?>
<?php echo Form::open();?>
<div class='alert alert-info'><?php echo __('comm.cover language :a to :b',array(':a'=>$base,':b'=>$in)) ?></div>
<div class="form-actions">
<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
<button class="btn" type="reset"><?php echo __('comm.reset');?></button>
</div>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.code'); ?></td> 
  </tr>
  <?php 
 
  foreach($models as $k=>$v){  
 
  ?>
  <tr>
	<td><?php echo Form::input('name[]',$k);?></td>
	<td><?php echo Form::input('out[]',$v);?> </td>  
  </tr>
  <?php } ?>
</table> 
<div class="form-actions">
<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
<button class="btn" type="reset"><?php echo __('comm.reset');?></button>
</div>
<?php echo Form::close();?>

<?php }?>

 