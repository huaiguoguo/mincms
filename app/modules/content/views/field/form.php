<?php 
$k = 'add field';
if($fid) $k = 'edit field';
echo Form::fieldset_open(null, __('comm.'.$k));
	echo Form::open();  
  
	?>
<input type='hidden' value="<?php echo $id;?>" name='type_id'>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <td><?php echo __('comm.field label'); ?></td>
	<td><?php echo __('comm.field key'); ?>[*<?php echo __('comm.just english,will put to database');?>]</td>
	<td><?php echo __('comm.field type'); ?></td>  
	<td class='rt'><?php echo __('comm.relation shop'); ?></td> 
	<td><?php echo __('comm.multi select'); ?></td> 
	<td><?php echo __('comm.value'); ?></td> 
	
  </tr>	
  <tr> 
    <td><?php echo Form::input('label',$edit->label);?> </td>  
	<td><?php echo Form::input('name',$edit->name);?> </td>  
	<td><?php echo Form::select('type',$edit->form->id, $form);?>   </td> 
	<td class='rt'>
	  <?php echo Form::select('rt',$_POST['rt'], $tables);?>
	  <?php echo Form::select('column',$_POST['column'], $tables);?>
	 </td> 
	<td><?php echo Form::select('muit',$edit->options['muit'],$muit);?> </td> 
	<td><?php echo Form::textarea('default');?> </td> 
  </tr>
      
</table>
<p><span class="label label-info"><?php echo __('comm.others setting');?></span></p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <td><?php echo __('comm.defaul value'); ?></td> 
	<td><?php echo __('comm.label tip'); ?></td>  
  </tr>	
  <tr>
    <td><?php echo Form::input('default_value',$edit->options['default_value']);?></td>  
    <td><?php echo Form::input('label_tip',$edit->options['label_tip']);?></td> 
	
  </tr>
<table/>

<p><span class="label label-info"><?php echo __('comm.add rules');?></span></p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <td><?php echo __('comm.rules'); ?></td>
	<td><?php echo __('comm.value'); ?></td> 
  </tr>	
  <tr> 
    <td><?php echo Form::select('rule[]',null, $rules,array('class'=>'rule'));?></td>  
 	<td><?php echo Form::input('value[]',null,array('class'=>'value'));?> <button type="button" class="btn cck_add"><?php echo __('comm.add');?></button></td>  
  </tr> 
</table>
<p><span class="label label-success"><?php echo __('comm.has add rules');?></span></p>
<table id='cck' class="table table-striped table-bordered table-condensed">
    <tr>
    	<td><?php echo __('comm.rules'); ?></td>
		<td><?php echo __('comm.value'); ?></td> 
	</tr>
	<?php if($fid){?>
		<?php 
			foreach($edit->rule->rules as $key=>$value){
		?>
		<tr>	  
			<td><input class='a'  name="rule[]" value="<?php echo $key;?>"></td>
			<td><input   class='b' name="value[]" value="<?php echo $value;?>"> 
			<button type="button" class="btn cck_remove"><?php echo __('comm.remove');?></button>
			</td>
		</tr>	
		<?php }?>
	
	<?php }?>
	<tr class="cck_add_list" style='display:none;'>	  
		<td><input class='a'  name="rule[]"></td>
		<td><input   class='b' name="value[]"> 
		<button type="button" class="btn cck_remove"><?php echo __('comm.remove');?></button>
		</td>
	</tr>	
</table>
<div class="form-actions">
<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>

</div>
<?php echo Form::close();echo Form::fieldset_close();?>
