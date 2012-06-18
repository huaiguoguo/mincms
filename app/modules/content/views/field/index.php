<p><pre><?php echo __('comm.content type').': '. $content->name;?></pre></p>
<?php if(!$fid){?>
<p><button type="button" class="btn click btn-success" rel="t0"><?php echo __('comm.add field');?></button></p>
<?php }else{?>
	
	
<?php }?>

<div id='t0' <?php if(!$fid){?> style='display:none;' <?php }?>>	

<?php echo \View::forge('field/form',array(
	'tables'=>$tables,
	'rules'=>$rules,
	'id'=>$id,
	'fid'=>$fid,
	'form'=>$form,
	'edit'=>$edit
	));
$op = $edit->options;	
?>
 
</div>
 
<?php if($content->fields){ 
?>

<table id='cck' class="table table-striped table-bordered table-condensed">
    <tr>
    	<td><?php echo __('comm.label'); ?></td>
		<td><?php echo __('comm.name'); ?></td> 
		<td><?php echo __('comm.html type'); ?></td> 
		<td><?php echo __('comm.rules'); ?></td> 
		<td><?php echo __('comm.sort'); ?></td>
		<td><?php echo __('comm.action'); ?></td>
	</tr>
	<?php foreach($content->fields as $vo){?>
	<tr>	  
		<td><?php echo $vo->label;?></td>
		<td><?php echo $vo->name;?></td>
		<td><?php echo $vo->form->val;?></td> 
		<td>
		<?php  if($vo->rule->rules){
			$r = unserialize($vo->rule->rules);
			foreach($r as $key=>$item){
			?>
			
			<p><span class="label label-info"><?php echo __('comm.'.$key);?></span>
			<span class="label"><?php echo $item;?></span></p>
		<?php }}?>
		</td>
		<td>
		<?php if($vo->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('content/field/sort/'.$vo->id.'/down/'.$id), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($vo->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('content/field/sort/'.$vo->id.'/up/'.$id), Asset::img('down.png')); ?>
		<?php }?>
		</td>
		<td>
			<?php echo \Html::anchor('content/field/index/'.$id.'/'.$vo->id, Asset::img('edit.png') );?>	
			&nbsp;
			<?php echo Html::anchor(\Uri::create('content/field/del/'.$id.'/'.$vo->id), Asset::img('error.png'),array(
				'onclick'=>"return confirm('".__('comm.do you confirm delete')."');"
			)); ?>		
		</td>
	</tr>
	<?php }?>	
</table>

<?php }?>

<script>
$(function(){
	
 	$("#form_type").change(function(){
 		select($(this).val());
 	});
 	
 	select($("#form_type ").val());
 	<?php if($fid){?>
 		$('#form_rt option').each(function(){ 
 			if($(this).val() == "<?php echo $op['rt'];?>"){
 				$(this).attr('selected',true);
 			}
 		});
 		
 		$.post("<?php echo \Uri::create('content/field/rtcolumns');?>", { t: $('#form_rt').val() },
		function(data) { 
		     if(data){
		     	$('#form_column').html(data);
		     	$('#form_column option').each(function(){ 
		 			if($(this).val() == "<?php echo $op['column'];?>"){
		 				$(this).attr('selected',true);
		 			}
		 		});
		     }
		});
		
		
	 	
 		
 		
 	<?php }?>
 	 
 	function select(val){
 		if(val == 7 || val == 8 || val == 9){
 			$('.rt').show();
 		}else{
 			$('.rt').hide();
 		}
 	}
	$('#form_rt').change(function(){ 
		var obj = this;
		$.post("<?php echo \Uri::create('content/field/rtcolumns');?>", { t: $(this).val() },
		function(data) { 
		     if(data){
		     	$('#form_column').html(data);
		     }
		});
		return false;
	});
	
});
</script>