<p>
<a href="<?php echo \Uri::create('tools/database/backup_do'); ?>" class="btn btn-primary"><?php echo __('comm.backup database'); ?></a>
<a href="#" id="import" class="btn"><?php echo __('comm.import database'); ?></a>
<span class="label label-info"><?php echo count($posts); ?></span>
</p>
<?php
 
if($posts){
?>
<script type="text/javascript">
	$(function(){
		$('.hide').hide();
		$('#import').click(function(){ 
			if(confirm("<?php echo __('comm.confirm open import tag');?>?"))
				$('.hide').show();
		});
	});
</script>

<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td> 
	<td><?php echo __('comm.file_size'); ?></td>
	<td><?php echo __('comm.action'); ?></td> 
  </tr>
  <?php  
  $i=0;
  foreach($posts as $v){   
  $id = \Crypt::encode($v, 'Joa&lo9'); 
  ?>
  <tr <?php if(\Session::get_flash('success') && $i==0){ echo "style='background:#F89406'";}?> > 
	<td><?php echo $v; ?></td>  
	<td><?php echo \Vendor\File::size(filesize($path.'/'.$v)); ?></td>
	<td> 
		<?php echo \Html::anchor('tools/database/import/'.$id, Asset::img('database_go.png'),array(
			'class'=>'hide',
			'onclick'=>"return confirm('".__('comm.import to database')."?');",
			'title'=>__('comm.import to database')) );?>
		<?php echo \Html::anchor('tools/database/remove/'.$id, Asset::img('error.png'),array(
			'title'=>__('comm.confirm delete'),
			'onclick'=>"return confirm('".__('comm.confirm delete')."?');") );?> 
	</td>
  </tr>
  <?php $i++; } ?>
</table> 

<?php }?>

<?php echo $pagination;?>